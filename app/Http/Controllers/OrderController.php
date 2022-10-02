<?php

namespace App\Http\Controllers;

use App\Models\Order;

use Illuminate\Http\Request;

class OrderController extends Controller
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
            $orders = Order::where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            })->orderBy('id', 'DESC')
                ->paginate(25);
            $orders->appends(['q' => $q]);
        } else {
            $orders = Order::paginate(25);
        }
        return View('backend.order.index', compact("orders", "q"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.order.edit');
    }

    public function changeStatus(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }
        $expect_status = $request->input('expect_status');

        if ($expect_status == 2 && $order->status != 1)
            return redirect()->back()->with('error', 'Trạng thái hiện tại không hợp lệ');
        if ($order->payment_method == 1) {
            if ($expect_status == 3 && $order->status != 2)
                return redirect()->back()->with('error', 'Trạng thái hiện tại không hợp lệ');
            if ($expect_status == 4 && $order->status != 3)
                return redirect()->back()->with('error', 'Trạng thái hiện tại không hợp lệ');
        } else {
            if ($expect_status == 3 && $order->status != 4)
                return redirect()->back()->with('error', 'Trạng thái hiện tại không hợp lệ');
            if ($expect_status == 4 && $order->status != 2)
                return redirect()->back()->with('error', 'Trạng thái hiện tại không hợp lệ');
        }
        if ($expect_status == 3) {
            $request->validate([
                'received_price' => 'required'
            ]);
            $order->received_price = $request->input('received_price');
        }
        $order->status = $expect_status;
        $order->update();
        return redirect()->back()->with('success', 'Thành công test abcde');
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
            $order = Order::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route("updateOrderView")->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        return view('backend.order.edit', compact('order'));
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
            $order = Order::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $order->delete();

        return redirect()->back()->with('success', 'Thành công');
    }
}
