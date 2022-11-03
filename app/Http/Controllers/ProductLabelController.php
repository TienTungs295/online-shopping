<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\ProductLabel;

class ProductLabelController extends Controller
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
            $product_labels = ProductLabel::where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            })->orderBy('id', 'DESC')
                ->paginate(25);
            $product_labels->appends(['q' => $q]);
        } else {
            $product_labels = ProductLabel::paginate(25);
        }
        return View('backend.product-label.index', compact("product_labels", "q"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product-label.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count_exist = ProductLabel::where('name', $request->name)->count();
        if ($count_exist >= 1) {
            return redirect()->back()->with('error', 'Tên nhãn đã tồn tại');
        }
        $validatedData = $request->validate(
            [
                'name' => 'required|max:255',
                'color' => 'required',
            ],
            [
                'name.required' => 'Tên nhãn không được phép bỏ trống',
                'color.required' => 'Màu nhãn không được phép bỏ trống',
                'name.max' => 'Tên nhãn không được vượt quá 255 ký tự',
            ]);
        ProductLabel::create($validatedData);

        return redirect()->route("labelView")->with('success', 'Thành công');
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
            $product_label = ProductLabel::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route("updateLabelView")->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }
        return view('backend.product-label.edit', compact('product_label'));
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
            ProductLabel::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route("updateLabelView")->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $count_exist = ProductLabel::where('name', $request->name)->where('id', '<>', $id)->count();
        if ($count_exist >= 1) {
            return redirect()->back()->with('error', 'Tên nhãn đã tồn tại');
        }
        $validated_data = $request->validate(
            [
                'name' => 'required|max:255',
                'color' => 'required'
            ],
            [
                'name.required' => 'Tên nhãn không được phép bỏ trống',
                'color.required' => 'Màu nhãn không được phép bỏ trống',
                'name.max' => 'Tên nhãn không được vượt quá 255 ký tự',
            ]);
        ProductLabel::whereId($id)->update($validated_data);


        return redirect()->route("labelView")->with('success', 'Thành công');
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
            $product_label = ProductLabel::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $product_label->delete();

        return redirect()->back()->with('success', 'Thành công');
    }
}
