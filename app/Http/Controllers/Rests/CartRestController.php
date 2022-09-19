<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Cart;
use App\Http\Responses\AjaxResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CartRestController extends Controller
{

    public function findAll(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $shipping_fee = 30000;
        $sub_total = Cart::instance('cart')->subTotal(0, '', '');
        $sub_total_with_shipping_fee = (int)$sub_total + $shipping_fee;
        $data = array(
            'cart' => Cart::instance('cart')->content(),
            'subTotal' => $sub_total,
            'subTotalWithShippingFee' => $sub_total_with_shipping_fee,
            'shippingFee' => $shipping_fee,
        );
        return $ajax_response->setData($data)->toApiResponse();
    }

    public function count(Request $request)
    {
        $ajax_response = new AjaxResponse();
        return $ajax_response->setData(Cart::instance('cart')->count())->toApiResponse();
    }

    public function store(Request $request)
    {
        $ajax_response = new AjaxResponse();
        try {
            $product = Product::findOrFail($request->post("product_id"));
        } catch (ModelNotFoundException $e) {
            return $ajax_response->setMessage("Sản phẩm hiện không được bày bán!")->toApiResponse();
        }
        $qty = 1;
        if (!is_null($request->input('qty'))) $qty = $request->input('qty');
        $cart = Cart::instance('cart')->add(['id' => $product->id, 'name' => $product->name, 'qty' => $qty, 'price' => $product->real_price, 'options' => [
            'image' => $product->image,
            'slug' => $product->slug,
            'price' => $product->price,
            'on_sale' => $product->on_sale,
            'sale_off' => $product->sale_off
        ]]);
        return $ajax_response->setData($cart)->setMessage("Thêm " . $product->name . " vào giỏ hàng thành công!")->toApiResponse();
    }

    public function update(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $cart = $request->post('cart');
        foreach ($cart as $key => $item) {
            Cart::instance('cart')->update($item['rowId'], $item['qty']);
        }
        return $ajax_response->setData(Cart::instance('cart')->content())->toApiResponse();
    }


    public function remove(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $rowId = $request->post('row_id');
        Cart::instance('cart')->remove($rowId);
        return $ajax_response->setData($rowId)->toApiResponse();
    }
}
