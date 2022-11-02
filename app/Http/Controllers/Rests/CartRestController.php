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
        if (Cart::instance("cart")->count() > 0) {
            $cart = Cart::instance("cart")->content();
            $product_ids = [];
            $cartMap = array();
            foreach ($cart as $key => $item) {
                $product_id = $item["id"];
                array_push($product_ids, $product_id);
                $cartMap[$product_id] = $item["rowId"];
            }

            $query = Product::whereIn('id', $product_ids)->get();
            $db_pro_ids = $query->pluck('id');
            $products = $query->toArray();
            foreach ($products as $product) {
                $rowId = $cartMap[$product->id];
                if ($rowId != null) {
                    if ($product->is_contact) {
                        Cart::instance("cart")->remove($rowId);
                        continue;
                    }
                    Cart::instance("cart")->update($rowId,
                        ['id' => $product->id, 'name' => $product->name, 'price' => $product->real_price, 'options' => [
                            'image' => $product->image,
                            'slug' => $product->slug,
                            'price' => $product->price,
                            'on_sale' => $product->on_sale,
                            'sale_off' => $product->sale_off
                        ]]
                    );
                }
            }
            foreach ($db_pro_ids as $db_product_id)
                if (!in_array($db_product_id, $product_ids)) Cart::instance("cart")->remove($cartMap[$db_product_id]);
        }
        $shipping_fee = 30000;
        $sub_total = Cart::instance('cart')->subTotal(0, '', '');
        $sub_total_with_shipping_fee = (int)$sub_total + $shipping_fee;
        $data = array(
            'cart' => Cart::instance('cart')->content(),
            'subTotal' => $sub_total,
            'subTotalWithShippingFee' => $sub_total_with_shipping_fee,
            'shippingFee' => $shipping_fee,
            'total' => Cart::instance('cart')->count()
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
        if ($product->is_contact) return $ajax_response->setMessage("Không thể thêm sản phẩm vào giỏ hàng. Liên hệ để biết thêm giá sản phẩm!")->toApiResponse();
        $qty = 1;
        if (!is_null($request->input('qty'))) $qty = $request->input('qty');
        $cart = Cart::instance('cart')->add(['id' => $product->id, 'name' => $product->name, 'qty' => $qty, 'price' => $product->real_price, 'options' => [
            'image' => $product->image,
            'slug' => $product->slug,
            'price' => $product->price,
            'on_sale' => $product->on_sale,
            'sale_off' => $product->sale_off
        ]]);
        return $ajax_response->setData($cart)->setMessage("Thêm " . ($qty > 1 ? $qty . " " : "") . $product->name . " vào giỏ hàng thành công!")->toApiResponse();
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
