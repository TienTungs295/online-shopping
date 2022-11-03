<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Carbon\Carbon;
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
                $query->where('code', 'like', '%' . $q . '%');
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
        $request->validate(
            [
                'code' => 'required|max:50',
                'value' => 'required|numeric|min:1',
            ],
            [
                'code.required' => 'Mã giảm giá không được phép bỏ trống',
                'name.max' => 'Mã giảm giá không được vượt quá 50 ký tự',
                'value.required' => 'Giá trị không được phép bỏ trống',
                'value.numeric' => 'Giá trị phải là số',
                'value.min' => 'Giá trị phải lớn hơn 1',
            ]);

        $count_exist = Discount::where('code', $request->code)->count();
        if ($count_exist >= 1) {
            return redirect()->back()->with('error', 'Mã giảm giá đã tồn tại');
        }

        $discount = new Discount();

        if (!$request->input('start_date'))
            $start_date = Carbon::now()->format("Y-m-d");
        else
            $start_date = Carbon::createFromFormat('d-m-Y', $request->input('start_date'))->format("Y-m-d");

        if ($request->has('un_limited'))
            $discount->quantity = $request->input("quantity");

        if (!$request->has('unlimited_time') && $request->input('end_date'))
            $discount->end_date = Carbon::createFromFormat('d-m-Y', $request->input('end_date'))->format("Y-m-d");

        $target = $request->input('target');
        if ($target) {
            if ($target == 'all-orders')
                $discount_on = 'per-order';
            else
                $discount_on = $request->input("discount_on");
            $discount->discount_on = $discount_on;
        }

        $discount->code = $request->input("code");
        $discount->start_date = $start_date;
        $discount->type_option = $request->input("type_option");
        $discount->value = $request->input("value");
        $discount->target = $request->input("target");
        $product_ids = $request->input("product_ids");
        $product_ids = explode(",", $product_ids);
        $discount->save();
        $discount->products()->attach($product_ids);

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
