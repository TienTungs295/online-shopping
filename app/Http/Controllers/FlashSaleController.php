<?php

namespace App\Http\Controllers;

use App\Models\FlashSale;
use App\Models\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FlashSaleController extends Controller
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
            $flash_sales = FlashSale::where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            })->orderBy('id', 'DESC')
                ->paginate(25);
            $flash_sales->appends(['q' => $q]);
        } else {
            $flash_sales = FlashSale::paginate(25);
        }
        return View('backend.flash-sale.index', compact("flash_sales", "q"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $flash_sale = new FlashSale();
        $flash_sale->end_date = Carbon::now();
        return view('backend.flash-sale.edit', compact('flash_sale'));
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
            'end_date' => 'required',
        ]);

        $flash_sale = new FlashSale;
        $flash_sale->name = $request->input('name');
        $flash_sale->end_date = Carbon::createFromFormat('d-m-Y', $request->input('end_date'))->format("Y-m-d");
        $flash_sale->save();
        $this->storeProducts($request, $flash_sale);
        return redirect()->route("flashSaleView")->with('success', 'Thành công');
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
            $flash_sale = FlashSale::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }
        $product_ids = $flash_sale->products()->get()->pluck("id")->toArray();
        if (count($product_ids) != 0) {
            $flash_sale->product_ids = implode(",", $product_ids);
        }
        return view('backend.flash-sale.edit', compact('flash_sale'));
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
            $flash_sale = FlashSale::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route("flashSaleView")->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $request->validate([
            'name' => 'required|max:255',
        ]);

        $flash_sale->name = $request->input('name');
        $flash_sale->end_date = Carbon::createFromFormat('d-m-Y', $request->input('end_date'))->format("Y-m-d");
        $flash_sale->update();
        $this->storeProducts($request, $flash_sale);
        $product_ids = explode(',', $request->input('product_ids'));
        $db_pro_ids = $flash_sale->products()->get()->pluck("id");
        $del_pro_ids = [];
        foreach ($db_pro_ids as $id) {
            if (!in_array((int)$id, $product_ids)) {
                array_push($del_pro_ids, $id);
            }
        }
        if (count($del_pro_ids) != 0) {
            $flash_sale->products()->detach($del_pro_ids);
        }

        return redirect()->route("flashSaleView")->with('success', 'Thành công');
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
            $flash_sale = FlashSale::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $flash_sale->delete();

        return redirect()->back()->with('success', 'Thành công');
    }

    private function storeProducts($request, $flash_sale)
    {
        $product_ids = explode(',', $request->input('product_ids'));
        if (count($product_ids) == 0) return;
        foreach ($product_ids as $id) {
            $extra = Arr::get($request->input('products_extra', []), $id);

            if (!$extra || !isset($extra['price']) || !isset($extra['quantity'])) {
                continue;
            }

            $extra['price'] = (double)$extra['price'];
            $extra['quantity'] = (int)$extra['quantity'];

            if ($flash_sale->products()->where('id', $id)->count()) {
                $flash_sale->products()->sync([(int)$id => $extra]);
            } else {
                $flash_sale->products()->attach($id, $extra);
            }
        }
    }
}
