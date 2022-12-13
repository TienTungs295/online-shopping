<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\ProductCollection;
use Illuminate\Support\Str;


class ProductCollectionController extends Controller
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
            $product_collections = ProductCollection::where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            })->orderBy('id', 'DESC')
                ->paginate(25);
            $product_collections->appends(['q' => $q]);
        } else {
            $product_collections = ProductCollection::orderBy('id', 'DESC')->paginate(25);
        }
        return View('backend.product-collection.index', compact("product_collections", "q"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product-collection.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count_exist = ProductCollection::where('name', $request->name)->count();
        if ($count_exist >= 1) {
            return redirect()->back()->with('error', 'Tên bộ sưu tập đã tồn tại');
        }
        $request->validate([
            'name' => 'required|max:255',
        ], [
            'name.required' => 'Tên bộ sưu tập không được phép bỏ trống',
            'name.max' => 'Tên bộ sưu tập không được vượt quá 255 ký tự'
        ]);

        $product_collection = new ProductCollection;
        $product_collection->name = $request->input('name');
        $product_collection->slug = Str::slug($request->input('name'));;
        $product_collection->description = $request->input('description');
        $featured = $request->has("is_featured") ? 1 : 0;
        $product_collection->is_featured = $featured;
        $product_collection->priority = $request->input('priority');
        $product_collection->save();

        return redirect()->route("collectionView")->with('success', 'Thành công');
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
            $product_collection = ProductCollection::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }
        return view('backend.product-collection.edit', compact('product_collection'));
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
            $product_collection = ProductCollection::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route("collectionView")->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $request->validate([
            'name' => 'required|max:255',
        ], [
            'name.required' => 'Tên bộ sưu tập không được phép bỏ trống',
            'name.max' => 'Tên bộ sưu tập không được vượt quá 255 ký tự'
        ]);

        $count_exist = ProductCollection::where('name', $request->name)->where('id', '<>', $id)->count();
        if ($count_exist >= 1) {
            return redirect()->back()->with('error', 'Tên bộ sưu tập đã tồn tại');
        }
        $product_collection->name = $request->input('name');
        $product_collection->slug = Str::slug($request->input('name'));;
        $product_collection->description = $request->input('description');
        $featured = $request->has("is_featured") ? 1 : 0;
        $product_collection->is_featured = $featured;
        $product_collection->priority = $request->input('priority');
        $product_collection->update();
        return redirect()->route("collectionView")->with('success', 'Thành công');
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
            $product_collection = ProductCollection::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $product_collection->delete();

        return redirect()->back()->with('success', 'Thành công');
    }
}
