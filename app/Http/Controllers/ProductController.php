<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCollection;
use App\Models\ProductLabel;
use App\Models\RelatedProduct;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use League\CommonMark\Parser\Block\ParagraphParser;
use function Sodium\add;
use File;

class ProductController extends BaseCustomController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->input('q');
        if ($q != "") {
            $products = Product::where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            })->orderBy('id', 'DESC')
                ->paginate(25);
            $products->appends(['q' => $q]);
        } else {
            $products = Product::orderBy('id', 'DESC')->paginate(25);
        }

        return View('backend.product.index', compact("products", "q"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_categories = ProductCategory::all()->toArray();
        $labels = ProductLabel::all();
        $collections = ProductCollection::all();
        return view('backend.product.edit', compact('product_categories', 'labels', 'collections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Tên sản phẩm không được phép bỏ trống',
            ]
        );

        $category_id = $request->input('category_id');
        try {
            if ($category_id != 0) ProductCategory::findOrFail($category_id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Danh mục không tồn tại hoặc đã bị xóa');
        }

        $product = new Product;
        $product->name = $request->input('name');
        $product->slug = Str::slug($product->name);;
        $product->content = $request->input('content');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        $product->sku = $request->input('sku');
        $product->is_featured = $request->has('is_featured') ? 1 : 0;
        $is_contact_price = $request->has('is_contact');
        if (!$is_contact_price) {
            $product->price = empty($request->input('price')) ? 0 : $request->input('price');
            if (!empty($request->input('sale_price'))) {
                $product->sale_price = $request->input('sale_price');
            }
            if ($request->has('apply_time')) {
                $start_date = $request->input('start_date');
                $end_date = $request->input('end_date');
                $is_flash_sale = $request->has('is_flash_sale');
                if (!empty($start_date) && !empty($end_date)) {
                    $start_date_to_time_stamp = Carbon::createFromFormat('d-m-Y H:i:s', $start_date)->timestamp;
                    $end_date_to_time_stamp = Carbon::createFromFormat('d-m-Y H:i:s', $end_date)->timestamp;
                    if ($start_date_to_time_stamp > $end_date_to_time_stamp) return redirect()->back()->with('error', 'Ngày kết thúc phải lớn hơn ngày bắt đầu');
                }
                if (!empty($start_date)) {
                    $product->start_date = Carbon::createFromFormat('d-m-Y H:i:s', $start_date)->format("Y-m-d H:i:s");
                }
                if (!empty($end_date)) {
                    if ($product->start_date == null)
                        $product->start_date = Carbon::now()->format("Y-m-d H:i:s");
                    $product->end_date = Carbon::createFromFormat('d-m-Y H:i:s', $end_date)->format("Y-m-d H:i:s");
                    $product->is_flash_sale = $is_flash_sale ? 1 : 0;
                }
            }
        }
        $with_storehouse_management = $request->has('with_storehouse_management');
        if (!$is_contact_price && $with_storehouse_management) {
            $product->with_storehouse_management = 1;
            $product->quantity = empty($request->input('quantity')) ? 0 : $request->input('quantity');
            $product->allow_checkout_when_out_of_stock = $request->has('allow_checkout_when_out_of_stock') ? 1 : 0;
        } else {
            $product->with_storehouse_management = 0;
            $product->stock_status = $request->input('stock_status');
        }
        $product->is_contact = $is_contact_price ? 1 : 0;
        $product->is_trending = $request->has('is_trending') ? 1 : 0;

        //image
        $upload_path = "/uploads/images/";
        $image_url = $request->input('image');
        if ($image_url != null && $image_url != "" && str_contains($image_url, "/uploads/images/")) {
            $start_position = strpos($image_url, "/uploads/images/") + strlen($upload_path);
            $image_name = substr($image_url, $start_position, strlen($image_url) - $start_position);
            $product->image = $image_name;
        }

        //images
        $image_string = $request->input('images');
        $images = [];
        if ($image_string != null && $image_string != "") {
            $image_urls = explode(",", $image_string);
            foreach ($image_urls as $item) {
                if (!str_contains($item, "/uploads/images/")) continue;
                $start_position = strpos($item, "/uploads/images/") + strlen($upload_path);
                $image = new Image;
                $image->image = substr($item, $start_position, strlen($item) - $start_position);
                array_push($images, $image);
            }
        }

        $related_product_ids = $request->input('related_product_ids');
        if ($related_product_ids) {
            $related_product_ids = explode(",", $related_product_ids);
        }
        $labels = $request->input("labels");
        $collections = $request->input("collections");

        DB::beginTransaction();
        try {
            $product->save();
            $product->images()->saveMany($images);
            $product->productLabels()->attach($labels);
            $product->productCollections()->attach($collections);
            $related_products = [];
            if ($related_product_ids) {
                foreach ($related_product_ids as $related_product_id) {
                    array_push($related_products, ['from_product_id' => $product->id, "to_product_id" => $related_product_id]);
                }
            }
            RelatedProduct::insert($related_products);
            $this->updateTotalProductsFromProductPage($product->category_id, true);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return redirect()->route("productView")->with('success', 'Thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }
        $image_string = "";
        $size = $product->images()->count();
        foreach ($product->images()->get() as $key => $item) {
            $image_string .= url('uploads/images/' . $item->image);
            if ($key < $size - 1) $image_string .= ",";
        }
        if ($product->image) {
            $product->image = url('uploads/images/' . $product->image);
        }
        $product->images = $image_string;
        $related_products = $product->productsRelated()->get();
        $product->related_products = $related_products;
        $related_product_ids = $related_products->pluck("id")->toArray();
        if (count($related_product_ids) != 0) {
            $product->related_product_ids = implode(",", $related_product_ids);
        }
        $product_categories = ProductCategory::all()->toArray();
        $labels = ProductLabel::all();
        $collections = ProductCollection::all();
        $product->label_ids = $product->productLabels()->get()->pluck("id")->toArray();
        $product->collection_ids = $product->productCollections()->get()->pluck("id")->toArray();
        return view('backend.product.edit', compact('product', 'product_categories', 'labels', 'collections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Tên sản phẩm không được phép bỏ trống',
            ]);

        try {
            $product = Product::findOrFail($id);
            $old_category_id = $product->category_id;
        } catch (ModelNotFoundException $e) {
            return redirect()->route("productView")->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $category_id = $request->input('category_id');
        try {
            if ($category_id != 0) ProductCategory::findOrFail($category_id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Danh mục không tồn tại hoặc đã bị xóa');
        }

        $product->name = $request->input('name');
        $product->slug = Str::slug($product->name);
        $product->content = $request->input('content');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        $product->sku = $request->input('sku');
        $product->is_featured = $request->has('is_featured') ? 1 : 0;
        $is_contact_price = $request->has('is_contact');
        if ($is_contact_price) {
            $product->price = null;
            $product->sale_price = null;
        } else {
            $product->price = empty($request->input('price')) ? 0 : $request->input('price');
            $product->sale_price = empty($request->input('sale_price')) ? null : $request->input('sale_price');
        }

        if (!$is_contact_price && $request->has('apply_time')) {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $is_flash_sale = $request->has('is_flash_sale');
            if (!empty($start_date) && !empty($end_date)) {
                $start_date_to_time_stamp = Carbon::createFromFormat('d-m-Y H:i:s', $start_date)->timestamp;
                $end_date_to_time_stamp = Carbon::createFromFormat('d-m-Y H:i:s', $end_date)->timestamp;
                if ($start_date_to_time_stamp > $end_date_to_time_stamp) return redirect()->back()->with('error', 'Ngày kết thúc phải lớn hơn ngày bắt đầu');
            }
            if (!empty($start_date)) {
                $product->start_date = Carbon::createFromFormat('d-m-Y H:i:s', $start_date)->format("Y-m-d H:i:s");
            } else {
                $product->start_date = null;
            }
            if (!empty($end_date)) {
                if ($product->start_date == null)
                    $product->start_date = Carbon::now()->format("Y-m-d H:i:s");
                $product->end_date = Carbon::createFromFormat('d-m-Y H:i:s', $end_date)->format("Y-m-d H:i:s");
                $product->is_flash_sale = $is_flash_sale ? 1 : 0;
            } else {
                $product->is_flash_sale = 0;
                $product->end_date = null;
            }
        } else {
            $product->start_date = null;
            $product->end_date = null;
            $product->is_flash_sale = 0;
        }

        $with_storehouse_management = $request->has('with_storehouse_management');
        if (!$is_contact_price && $with_storehouse_management) {
            $product->with_storehouse_management = 1;
            $product->quantity = empty($request->input('quantity')) ? 0 : $request->input('quantity');
            $product->allow_checkout_when_out_of_stock = $request->has('allow_checkout_when_out_of_stock') ? 1 : 0;
            $product->stock_status = null;
        } else {
            $product->with_storehouse_management = 0;
            $product->quantity = null;
            $product->allow_checkout_when_out_of_stock = null;
            $product->stock_status = $request->input('stock_status');
        }
        $product->is_contact = $is_contact_price ? 1 : 0;
        $product->is_trending = $request->has('is_trending') ? 1 : 0;

        //image
        $del_image_names = [];
        $image_url = $request->input('image');
        $image_name = "";
        $delete_url = null;
        $upload_path = "/uploads/images/";
        if ($image_url != null && $image_url != "" && str_contains($image_url, "/uploads/images/")) {
            $start_position = strpos($image_url, "/uploads/images/") + strlen($upload_path);
            $image_name = substr($image_url, $start_position, strlen($image_url) - $start_position);
        }

        if ($image_name != $product->image && $product->image != null) {
            array_push($del_image_names, $product->image);
        }
        $product->image = $image_name;

        //images
        $image_string = $request->input('images');
        $db_images = $product->images()->get();
        $db_image_names = $db_images->pluck("image")->toArray();
        $db_images = $db_images->toArray();

        $param_images = [];
        $new_images = [];
        $del_image_ids = [];
        if ($image_string != null && $image_string != "") {
            $image_urls = explode(",", $image_string);
            foreach ($image_urls as $item) {
                if (!str_contains($item, "/uploads/images/")) continue;
                $start_position = strpos($item, "/uploads/images/") + strlen($upload_path);
                $image_name = substr($item, $start_position, strlen($item) - $start_position);
                array_push($param_images, $image_name);
            }
        }

        foreach ($param_images as $param_image) {
            if (!in_array($param_image, $db_image_names)) {
                $image = new Image;
                $image->image = $param_image;
                array_push($new_images, $image);
            }
        }

        foreach ($db_images as $db_image) {
            if (!in_array($db_image["image"], $param_images)) {
                array_push($del_image_ids, $db_image["id"]);
                array_push($del_image_names, $db_image["image"]);
            }
        }

        $related_product_ids = [];
        if ($request->input('related_product_ids')) {
            $related_product_ids = explode(",", $request->input('related_product_ids'));
        }

        $db_to_product_ids = $product->productsRelated()->get()->pluck("id")->toArray();
        $new_related_products = [];
        $del_related_product_ids = [];
        if ($related_product_ids) {
            foreach ($related_product_ids as $id) {
                if (!in_array($id, $db_to_product_ids)) {
                    array_push($new_related_products, ['from_product_id' => $product->id, "to_product_id" => $id]);
                }
            }
        }

        foreach ($db_to_product_ids as $id) {
            if (!in_array($id, $related_product_ids)) {
                array_push($del_related_product_ids, $id);
            }
        }
        $labels = $request->input("labels");
        $collections = $request->input("collections");

        DB::beginTransaction();
        try {
            $product->update();
            $product->images()->saveMany($new_images);
            $product->images()->whereIn('id', $del_image_ids)->delete();
            $product->productLabels()->sync($labels);
            $product->productCollections()->sync($collections);
            RelatedProduct::whereIn('to_product_id', $del_related_product_ids)->delete();
            RelatedProduct::insert($new_related_products);
            if ($old_category_id != $product->category_id) {
                //minus 1
                $this->updateTotalProductsFromProductPage($old_category_id);
                //plus 1
                $this->updateTotalProductsFromProductPage($product->category_id, true);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        foreach ($del_image_names as $del_image_name) {
            $delete_url = 'uploads\images\\' . $del_image_name;
            if (File::exists(public_path($delete_url))) {
                File::delete(public_path($delete_url));
            }
        }

        return redirect()->route("productView")->with('success', 'Thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }
        $del_images = [];
        $images = $product->images()->get()->pluck("image")->toArray();
        $image = $product->image;
        $del_images = array_merge($del_images, $images);
        array_push($del_images, $image);

        DB::beginTransaction();
        try {
            $this->updateTotalProductsFromProductPage($product->category_id, false, true);
            $product->images()->delete();
            $product->reviews()->delete();
            $product->delete();
            RelatedProduct::where("from_product_id", $id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        foreach ($del_images as $image) {
            $delete_url = 'uploads\images\\' . $image;
            if (File::exists(public_path($delete_url)))
                File::delete(public_path($delete_url));
        }

        return redirect()->back()->with('success', 'Thành công');
    }
}
