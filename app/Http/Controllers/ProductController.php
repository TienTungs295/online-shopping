<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductController extends Controller
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
            $products = Product::paginate(25);
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
        return view('backend.product.edit');
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
        ]);

        $product = new Product;
        $product->name = $request->input('name');
        $product->content = $request->input('content');

        $image_url = $request->input('image');
        if ($image_url != null && $image_url != "") {
            $start_position = strripos($image_url, "/") + 1;
            $image_url = substr($image_url, $start_position, strlen($image_url) - $start_position);
        }
        $product->image = $image_url;
        $product->author_id = 1;
        $product->author_type = 1;

//        $product->is_featured = $request->input('is_featured');
        $product->save();

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
        return view('backend.product.edit', compact('product'));
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
            $product = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route("productView")->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $request->validate([
            'name' => 'required|max:255',
        ]);

        $product->name = $request->input('name');
        $product->content = $request->input('content');
        $image_url = $request->input('image');
        if ($image_url != null && $image_url != "") {
            $start_position = strripos($image_url, "/") + 1;
            $image_url = substr($image_url, $start_position, strlen($image_url) - $start_position);
            if ($image_url != $product->image) {
                $delete_url = 'uploads\images\\' . $product->image;
                if (File::exists(public_path($delete_url))) {
                    File::delete(public_path($delete_url));
                }
            }
        }
        $product->image = $image_url;
        //        $product->is_featured = $request->input('is_featured');
        $product->update();
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

        $product->delete();

        return redirect()->back()->with('success', 'Thành công');
    }
}
