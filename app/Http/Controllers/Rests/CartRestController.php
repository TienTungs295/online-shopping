<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Discount;
use Cart;
use Validator;
use Carbon\Carbon;
use App\Http\Responses\AjaxResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CartRestController extends Controller
{
    public $shipping_fee = 30000;

    public function findAll(Request $request)
    {
        $ajax_response = new AjaxResponse();
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
                return $ajax_response->setData($this->buildCartResponse())->toApiResponse();
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
                            'sale_off' => $product->sale_off
                        ]]
                    );
                }
            }
        }

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

    public function applyCoupon(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $validator = Validator::make($request->all(),
            [
                'code' => 'required',
            ],
            [
                'code.required' => 'Mã giảm giá không hợp lệ',
            ]
        );
        if ($validator->fails())
            return $ajax_response->setErrors($validator->errors())->toApiResponse();
        $code = $request->post('code');
        $db_discount = Discount::with(["products"])->where("code", $code)->first();
        if ($db_discount == null)
            return $ajax_response->setErrors(array("code" => "Mã giảm giá không hợp lệ"))->toApiResponse();
        $now = Carbon::now()->timestamp;
        if ($db_discount->start_date != null && $now < strtotime($db_discount->start_date))
            return $ajax_response->setErrors(array("code" => "Mã giảm giá không hợp lệ"))->toApiResponse();
        if ($db_discount->end_date != null && $now > strtotime($db_discount->end_date))
            return $ajax_response->setErrors(array("code" => "Mã giảm giá hết hiệu lực"))->toApiResponse();
        $cart_instance = Cart::instance('cart');
        $sub_total = $cart_instance->subTotal(0, '', '');
        $sub_total_with_shipping_fee = (int)$sub_total + $this->shipping_fee;
        $specific_product_ids = [];
        $specific_product_map = [];

        $discount_map = ["amount" => [], "percentage" => []];
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
                    $product = $specific_product_map[$item->id];
                    if ($db_discount->type_option == "amount") {
                        $discount_value = $db_discount->value;
                        $discount_item = array(
                            "title" => "Giảm " . $discount_value . " đ cho sản phẩm " . $product->name,
                            "value" => $discount_value
                        );
                        array_push($discount_map["amount"], $discount_item);
                    } elseif ($db_discount->type_option == "percentage") {
                        $discount_value = floor($product->real_price * $db_discount->value / 100);
                        $discount_item = array(
                            "title" => "Giảm " . $db_discount->value . "% cho sản phẩm " . $product->name,
                            "value" => $discount_value
                        );
                        array_push($discount_map["percentage"], $discount_item);
                    }
                }
            }
            if (!$has_specific_product_in_cart) return $ajax_response->setErrors(array("code" => "Mã giảm giá không có hiệu lực cho đơn hàng"))->toApiResponse();
        } else if ($db_discount->target == "all-orders") {
            if ($db_discount->type_option == "amount") {
                $discount_value = "Giảm " . $db_discount->value . "đ";
                $discount_item = ["title" => $discount_value . "đ", "value" => $discount_value];
                array_push($discount_map["amount"], $discount_item);
            } elseif ($db_discount->type_option == "percentage") {
                $discount_value = floor($sub_total * $db_discount->value / 100);
                $discount_item = [
                    "title" => "Giảm " . $db_discount->value . "%",
                    "value" => $discount_value
                ];
                array_push($discount_map["percentage"], $discount_item);
            }
        }
        $data = array(
            'cart' => Cart::instance('cart')->content(),
            'subTotal' => $sub_total,
            'subTotalWithShippingFee' => $sub_total_with_shipping_fee,
            'shippingFee' => $this->shipping_fee,
            'total' => Cart::instance('cart')->count()
        );
        if (sizeof($discount_map["percentage"]) > 0 || sizeof($discount_map["amount"]) > 0) {
            $sub_total_with_shipping_fee_and_code = $sub_total_with_shipping_fee;
            foreach ($discount_map["amount"] as $discount_item)
                $sub_total_with_shipping_fee_and_code -= $discount_item["value"];
            foreach ($discount_map["percentage"] as $discount_item)
                $sub_total_with_shipping_fee_and_code -= $discount_item["value"];
            $data['subTotalWithShippingFeeAndCode'] = $sub_total_with_shipping_fee_and_code > 0 ? $sub_total_with_shipping_fee_and_code : 0;
            $data['discountNote'] = $discount_map;
        }
        return $ajax_response->setData($data)->toApiResponse();
    }

    private function buildCartResponse()
    {
        $sub_total = Cart::instance('cart')->subTotal(0, '', '');
        $sub_total_with_shipping_fee = (int)$sub_total + $this->shipping_fee;
        return array(
            'cart' => Cart::instance('cart')->content(),
            'subTotal' => $sub_total,
            'subTotalWithShippingFee' => $sub_total_with_shipping_fee,
            'shippingFee' => $this->shipping_fee,
            'total' => Cart::instance('cart')->count()
        );
    }
}
