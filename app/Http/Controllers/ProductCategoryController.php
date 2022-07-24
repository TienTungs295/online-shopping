<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
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
        $request->validate([
            'name' => 'required|max:255',
            'parent_id' => 'required',
        ]);

        $count_exist = ProductCategory::where('name', $request->name)->count();
        if ($count_exist >= 1) {
            return redirect()->back()->with('error', 'Tên danh mục đã tồn tại');
        }

        $product_category = new ProductCategory;
        $product_category->name = $request->input('name');
        $product_category->parent_id = $request->input('parent_id');
        $product_category->description = $request->input('description');
//        $product_category->is_featured = $request->input('is_featured');
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

        $request->validate([
            'name' => 'required|max:255',
            'parent_id' => 'required',
        ]);

        $count_exist = ProductCategory::where('name', $request->name)->where('id', '<>', $id)->count();
        if ($count_exist >= 1) {
            return redirect()->back()->with('error', 'Tên danh mục đã tồn tại');
        }

        $parent_id = $request->input('parent_id');
        try {
            $product_category = ProductCategory::findOrFail($parent_id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Danh mục cha không tồn tại hoặc đã bị xóa');
        }

        $allChilds = ProductCategory::with('allChilds')->where('id', '=', $id)->get()->toArray();
        $childIds = $this->getAllChildIds($allChilds);
        if (in_array($parent_id, $childIds) || $parent_id == $id) {
            return redirect()->back()->with('error', 'Danh mục cha không hợp lệ');
        }
        $product_category->name = $request->input('name');
        $product_category->parent_id = $parent_id;
        $product_category->description = $request->input('description');
//        $product_category->is_featured = $request->input('is_featured');
        $product_category->update();

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
                $product_category->delete();
            } catch (ModelNotFoundException $e) {
                return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
            }
        } else {
            return redirect()->back()->with('error', 'Bạn không thể xóa danh mục này');
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
