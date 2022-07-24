<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DiscountController extends Controller
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
            $discounts = Discount::where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            })->orderBy('id', 'DESC')
                ->paginate(25);
            $discounts->appends(['q' => $q]);
        } else {
            $discounts = Discount::paginate(25);
        }
        return View('backend.discount.index', compact("discounts", "q"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.discount.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count_exist = Discount::where('name', $request->name)->count();
        if ($count_exist >= 1) {
            return redirect()->back()->with('error', 'Tên nhãn đã tồn tại');
        }
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'color' => 'required',
        ]);
        Discount::create($validatedData);

        return redirect()->route("discountView")->with('success', 'Thành công');
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
            $discount = Discount::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route("updateDiscountView")->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }
        return view('backend.discount.edit', compact('product_discount'));
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
            Discount::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route("updateDiscountView")->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $count_exist = Discount::where('name', $request->name)->where('id', '<>', $id)->count();
        if ($count_exist >= 1) {
            return redirect()->back()->with('error', 'Tên nhãn đã tồn tại');
        }
        $validated_data = $request->validate([
            'name' => 'required|max:255',
            'color' => 'required'
        ]);
        Discount::whereId($id)->update($validated_data);


        return redirect()->route("discountView")->with('success', 'Thành công');
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
            $discount = Discount::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $discount->delete();

        return redirect()->back()->with('success', 'Thành công');
    }
}
