<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use File;

class ProductCategoryController extends BaseCustomController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product_categories = ProductCategory::all()->toArray();
        return View('backend.product-category.index')->with(['product_categories' => $product_categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_categories = ProductCategory::all()->toArray();
        $product_category = null;
        return view('backend.product-category.edit', compact("product_categories", "product_category"));
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
                'name' => 'required|max:255',
                'parent_id' => 'required',

            ],
            [
                'name.required' => 'Tên danh mục không được phép bỏ trống',
                'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
                'parent_id.required' => 'Danh mục cha không được phép bỏ trống'
            ]);

        $count_exist = ProductCategory::where('name', $request->name)->count();
        if ($count_exist >= 1) {
            return redirect()->back()->with('error', 'Tên danh mục đã tồn tại');
        }

        $parent_id = $request->input('parent_id');
        try {
            if ($parent_id != 0) ProductCategory::findOrFail($parent_id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Danh mục cha không tồn tại hoặc đã bị xóa');
        }

        $product_category = new ProductCategory;
        //image
        $upload_path = "/uploads/images/";
        $image_url = $request->input('image');
        if ($image_url != null && $image_url != "" && str_contains($image_url, "/uploads/images/")) {
            $start_position = strpos($image_url, "/uploads/images/") + strlen($upload_path);
            $image_name = substr($image_url, $start_position, strlen($image_url) - $start_position);
            $product_category->image = $image_name;
        }

        $product_category->name = $request->input('name');
        $product_category->parent_id = $request->input('parent_id');
        $product_category->description = $request->input('description');
        $featured = $request->has("is_featured") ? 1 : 0;
        $product_category->is_featured = $featured;
        $product_category->priority = $request->input('priority');
        $product_category->save();
        return redirect()->route("categoryView")->with('success', 'Thành công');
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
            $product_category = ProductCategory::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route("categoryView")->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }
        $allChilds = ProductCategory::with('allChilds')->where('id', '=', $id)->get()->toArray();
        $childIds = $this->getAllChildIds($allChilds);
        array_push($childIds, (int)$id);
        $product_categories = ProductCategory::whereNotIn('id', $childIds)->get()->toArray();
        return view('backend.product-category.edit', compact('product_category', 'product_categories'));
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
        try {
            $product_category = ProductCategory::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route("categoryView")->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $request->validate(
            [
                'name' => 'required|max:255',
                'parent_id' => 'required'
            ],
            [
                'name.required' => 'Tên danh mục không được phép bỏ trống',
                'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
                'parent_id.required' => 'Danh mục cha không được phép bỏ trống'
            ]);

        $count_exist = ProductCategory::where('name', $request->name)->where('id', '<>', $id)->count();
        if ($count_exist >= 1) {
            return redirect()->back()->with('error', 'Tên danh mục đã tồn tại');
        }

        $parent_id = $request->input('parent_id');
        try {
            if ($parent_id != 0) ProductCategory::findOrFail($parent_id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Danh mục cha không tồn tại hoặc đã bị xóa');
        }

        $allChilds = ProductCategory::with('allChilds')->where('id', '=', $id)->get()->toArray();
        $childIds = $this->getAllChildIds($allChilds);
        if (in_array($parent_id, $childIds) || $parent_id == $id) {
            return redirect()->back()->with('error', 'Danh mục cha không hợp lệ');
        }
        $product_category->name = $request->input('name');
        //image
        $image_url = $request->input('image');
        $image_name = "";
        $delete_url = null;
        $del_image_name = null;
        $upload_path = "/uploads/images/";
        if ($image_url != null && $image_url != "" && str_contains($image_url, "/uploads/images/")) {
            $start_position = strpos($image_url, "/uploads/images/") + strlen($upload_path);
            $image_name = substr($image_url, $start_position, strlen($image_url) - $start_position);
        }

        if ($image_name != $product_category->image && $product_category->image != null)
            $del_image_name = $product_category->image;

        $product_category->image = $image_name;
        $old_parent_id = $product_category->parent_id;
        $this->updateTotalProductsFromCatPage($product_category->id);
        $product_category->parent_id = $parent_id;
        $product_category->description = $request->input('description');
        $featured = $request->has("is_featured") ? 1 : 0;
        $product_category->is_featured = $featured;
        $product_category->priority = $request->input('priority');

        $product_category->update();
        if ($old_parent_id != $parent_id) {
            $this->updateTotalProductsFromCatPage($product_category->id);
        }

        if (!empty($del_image_name)) {
            $delete_url = 'uploads\images\\' . $del_image_name;
            if (File::exists(public_path($delete_url)))
                File::delete(public_path($delete_url));
        }

        return redirect()->route("categoryView")->with('success', 'Thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count = ProductCategory::where('parent_id', $id)->count();
        if ($count == 0) {
            try {
                $product_category = ProductCategory::findOrFail($id);
                $this->updateTotalProductsFromCatPage($product_category->id);
                $product_category->delete();
            } catch (ModelNotFoundException $e) {
                return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
            }
        } else {
            return redirect()->back()->with('error', 'Bạn không thể xóa danh mục này, cần xóa hết toàn bộ thư mục con trước');
        }
        return redirect()->back()->with('success', 'Thành công');
    }

    protected function _flattened($array)
    {
        $flatArray = [];

        if (!is_array($array)) {
            $array = (array)$array;
        }

        foreach ($array as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $flatArray = array_merge($flatArray, $this->_flattened($value));
            } else {
                $flatArray[0][$key] = $value;
            }
        }

        return $flatArray;
    }

    protected function getAllChildIds($array, $isChild = false)
    {
        $ids = [];
        foreach ($array as $key => $value) {
            if (is_array($value) || is_object($value)) {
                if ($isChild) array_push($ids, $value["id"]);
                if (sizeof($value["all_childs"]) == 0) continue;
                $ids = array_merge($ids, $this->getAllChildIds($value["all_childs"], true));
            }
        }
        return $ids;
    }

}
