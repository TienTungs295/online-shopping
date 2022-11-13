<?php

namespace App\Http\Controllers;


use App\Http\Responses\AjaxResponse;
use App\Models\Discount;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Cart;

class BaseCustomController extends Controller
{
    protected static $SHIPPING_FEE = 30000;
    protected static $CODE = "CODE";

    protected function refreshCart()
    {
        if (Cart::instance("cart")->count() > 0) {
            $cart = Cart::instance("cart")->content();
            $product_ids = [];
            $cartMap = array();
            foreach ($cart as $key => $item) {
                $product_id = $item->id;
                array_push($product_ids, $product_id);
                $cartMap[$product_id] = $item->rowId;
            }
            $products = Product::whereIn('id', $product_ids)->get();
            $db_pro_ids = $products->pluck('id')->toArray();

            //all products are deleted
            if (sizeof($db_pro_ids) == 0) {
                foreach ($cartMap as $key => $value) {
                    try {
                        Cart::instance("cart")->remove($value);
                    } catch (InvalidRowIDException $e) {
                    }
                }
                return;
            }

            //some products are deleted
            foreach ($product_ids as $product_id) {
                if (!in_array($product_id, $db_pro_ids)) {
                    try {
                        Cart::instance("cart")->remove($cartMap[$product_id]);
                    } catch (InvalidRowIDException $e) {
                    }
                }
            }

            //update product in cart
            foreach ($products as $product) {
                $rowId = $cartMap[$product->id];
                if ($rowId != null) {
                    if ($product->is_contact) {
                        try {
                            Cart::instance("cart")->remove($rowId);
                        } catch (InvalidRowIDException $e) {
                        }
                        continue;
                    }
                    Cart::instance("cart")->update($rowId,
                        ['id' => $product->id, 'name' => $product->name, 'price' => $product->real_price, 'options' => [
                            'image' => $product->image,
                            'slug' => $product->slug,
                            'price' => $product->price,
                            'on_sale' => $product->on_sale,
                            'is_out_of_stock' => $product->is_out_of_stock,
                            'sale_off' => $product->sale_off
                        ]]
                    );
                }
            }
        }
    }


    protected function buildCartResponse($errors = null)
    {
        $sub_total = Cart::instance('cart')->subTotal(0, '', '');
        $data = array(
            'cart' => Cart::instance('cart')->content(),
            'subTotal' => $sub_total,
            'subTotalFinal' => (int)$sub_total + self::$SHIPPING_FEE,
            'shippingFee' => self::$SHIPPING_FEE,
            'total' => Cart::instance('cart')->count(),
            'activeDiscountCode' => session()->get(self::$CODE)
        );
        if ($errors != null) $data["errors"] = $errors;
        return $data;
    }

    protected function doApplyCoupon($code)
    {
        $db_discount = Discount::with(["products"])->where("code", $code)->first();
        if ($db_discount == null)
            return $this->buildCartResponse(array("code" => ["Mã giảm giá không hợp lệ"]));
        $now = Carbon::now()->timestamp;
        if ($db_discount->start_date != null && $now < strtotime($db_discount->start_date))
            return $this->buildCartResponse(array("code" => ["Mã giảm giá không hợp lệ"]));
        if ($db_discount->end_date != null && $now > strtotime($db_discount->end_date))
            return $this->buildCartResponse(array("code" => ["Mã giảm giá hết hiệu lực"]));
        $cart_instance = Cart::instance('cart');
        $sub_total = $cart_instance->subTotal(0, '', '');
        $specific_product_ids = [];
        $specific_product_map = [];
        $product_match_with_discount = null;
        $discount_value = null;
        if ($db_discount->target == "specific-product") {
            $has_specific_product_in_cart = false;
            $specific_products = $db_discount->products();
            if ($specific_products->count() > 0) {
                foreach ($specific_products->get() as $item) {
                    array_push($specific_product_ids, $item->id);
                    $specific_product_map[$item->id] = $item;
                }
            }

            foreach ($cart_instance->content() as $key => $item) {
                if (in_array($item->id, $specific_product_ids)) {
                    $has_specific_product_in_cart = true;
                    $product_match_with_discount = $specific_product_map[$item->id];
                    break;
                }
            }
            if (!$has_specific_product_in_cart) return $this->buildCartResponse(array("code" => ["Mã giảm giá không có hiệu lực cho đơn hàng"]));
            if ($db_discount->type_option == "amount")
                $discount_value = $db_discount->value;
            elseif ($db_discount->type_option == "percentage")
                $discount_value = floor($product_match_with_discount->real_price * $db_discount->value / 100);
        } else if ($db_discount->target == "all-orders") {
            if ($db_discount->type_option == "amount")
                $discount_value = $db_discount->value;
            elseif ($db_discount->type_option == "percentage")
                $discount_value = floor($sub_total * $db_discount->value / 100);
        }
        $data = array(
            'cart' => Cart::instance('cart')->content(),
            'subTotal' => $sub_total,
            'shippingFee' => self::$SHIPPING_FEE,
            'total' => Cart::instance('cart')->count()
        );
        if ($discount_value != null) {
            $sub_total_with_code = (int)$sub_total - $discount_value;
            if ($sub_total_with_code < 0) $sub_total_with_code = 0;
            $data['discountValue'] = $discount_value;
            $data['subTotalFinal'] = $sub_total_with_code + self::$SHIPPING_FEE;
            $data['activeDiscountCode'] = $code;
            session()->put(self::$CODE, $code);
        } else {
            $data['subTotalFinal'] = (int)$sub_total + self::$SHIPPING_FEE;
        }
        return $data;
    }
}
