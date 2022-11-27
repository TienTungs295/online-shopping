<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use File;

class ProductCategoryController extends Controller
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
            $product_categories = ProductCategory::where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            })->orderBy('id', 'DESC')
                ->paginate(25);
            $product_categories->appends(['q' => $q]);
        } else {
            $product_categories = ProductCategory::orderBy('id', 'DESC')->paginate(25);
        }
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
                'name' => 'required|max:255'
            ],
            [
                'name.required' => 'Tên danh mục không được phép bỏ trống',
                'name.max' => 'Tên danh mục không được vượt quá 255 ký tự'
            ]);

        $count_exist = ProductCategory::where('name', $request->name)->count();
        if ($count_exist >= 1) {
            return redirect()->back()->with('error', 'Tên danh mục đã tồn tại');
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
        $product_category->description = $request->input('description');
        $featured = $request->has("is_featured") ? 1 : 0;
        $product_category->is_featured = $featured;
        $priority = $request->input('priority');
        $product_category->priority = is_null($priority) ? 0 : $priority;
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
        return view('backend.product-category.edit', compact('product_category'));
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
                'name' => 'required|max:255'
            ], [
            'name.required' => 'Tên danh mục không được phép bỏ trống',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự'
        ]);

        $count_exist = ProductCategory::where('name', $request->name)->where('id', '<>', $id)->count();
        if ($count_exist >= 1) {
            return redirect()->back()->with('error', 'Tên danh mục đã tồn tại');
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
        $product_category->description = $request->input('description');
        $featured = $request->has("is_featured") ? 1 : 0;
        $product_category->is_featured = $featured;
        $priority = $request->input('priority');
        $product_category->priority = is_null($priority) ? 0 : $priority;
        $product_category->update();

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
        try {
            $product_category = ProductCategory::findOrFail($id);
            $product_category->delete();
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
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
