<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\BaseCustomController;
use App\Models\Product;
use App\Models\Discount;
use Cart;
use Validator;
use Carbon\Carbon;
use App\Http\Responses\AjaxResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class CartRestController extends BaseCustomController
{
    public function findAll(Request $request)
    {
        $this->refreshCart();
        $ajax_response = new AjaxResponse();
        if (Cart::instance('cart')->count() == 0)
            session()->forget(self::$CODE);
        if (!is_null(session()->get(self::$CODE)))
            return $ajax_response->setData($this->doApplyCoupon(session()->get(self::$CODE)))->toApiResponse();

        return $ajax_response->setData($this->buildCartResponse())->toApiResponse();
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
        $this->refreshCart();
        $ajax_response = new AjaxResponse();
        $cart = $request->post('cart');
        foreach ($cart as $key => $item) {
            try {
                Cart::instance('cart')->update($item['rowId'], $item['qty']);
            } catch (InvalidRowIDException $e) {
            }
        }
        if (!is_null(session()->get(self::$CODE)))
            return $ajax_response->setData($this->doApplyCoupon(session()->get(self::$CODE)))->toApiResponse();

        return $ajax_response->setData($this->buildCartResponse())->toApiResponse();
    }


    public function remove(Request $request)
    {
        $this->refreshCart();
        $ajax_response = new AjaxResponse();
        $rowId = $request->post('row_id');
        try {
            Cart::instance('cart')->remove($rowId);
        } catch (InvalidRowIDException $e) {
        }
        if (Cart::instance('cart')->count() == 0)
            session()->forget(self::$CODE);
        if (!is_null(session()->get(self::$CODE)))
            return $ajax_response->setData($this->doApplyCoupon(session()->get(self::$CODE)))->toApiResponse();

        return $ajax_response->setData($this->buildCartResponse())->toApiResponse();
    }

    public function applyCoupon(Request $request)
    {
        $this->refreshCart();
        session()->forget(self::$CODE);
        $ajax_response = new AjaxResponse();
        $validator = Validator::make($request->all(),
            [
                'code' => 'required',
            ],
            [
                'code.required' => 'Mã giảm giá không được phép bỏ trống',
            ]
        );
        if ($validator->fails())
            return $ajax_response->setData($this->buildCartResponse($validator->errors()))->toApiResponse();

        return $ajax_response->setData($this->doApplyCoupon($request->post("code")))->toApiResponse();
    }

    public function removeCoupon(Request $request)
    {
        $this->refreshCart();
        session()->forget(self::$CODE);
        $ajax_response = new AjaxResponse();
        return $ajax_response->setData($this->buildCartResponse())->toApiResponse();
    }
}
