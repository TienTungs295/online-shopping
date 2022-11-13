<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\BaseCustomController;
use App\Http\Responses\AjaxResponse;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Jobs\SendEmail;
use \stdClass;
use Cart;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class OrderRestController extends BaseCustomController
{
    public function checkOut(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:200',
                'email' => 'required',
                'phone' => 'required|max:15',
                'province' => 'required',
                'district' => 'required',
                'ward' => 'required',
                'address' => 'required',
            ],
            [
                'name.required' => 'Tên khách hàng không được phép bỏ trống',
                'email.required' => 'Email không được phép bỏ trống',
                'name.max' => 'Tên khách hàng không được phép vượt quá 200 ký tự',
                'phone.required' => 'Số điện thoại không được phép bỏ trống',
                'phone.max' => 'Số điện thoại không hợp lệ',
                'province.required' => 'Tỉnh thành không được phép bỏ trống',
                'district.required' => 'Quận huyện không được phép bỏ trống',
                'ward.required' => 'Phường xã không được phép bỏ trống',
                'address.required' => 'Địa chỉ không được phép bỏ trống',
            ]
        );
        $ajax_response = new AjaxResponse();
        if ($validator->fails()) {
            return $ajax_response->setErrors($validator->errors())->toApiResponse();
        }
        $payment_method = $request->post('payment_method');
        if (is_null($payment_method))
            return $ajax_response->setMessage("Vui lòng chọn phương thức thanh toán!")->toApiResponse();

        $this->refreshCart();
        $cartCount = Cart::instance('cart')->count();
        if ($cartCount == 0)
            return $ajax_response->setMessage("Hiện không có sản phẩm nào trong giỏ hàng!")->toApiResponse();

        $name = trim($request->post('name'));
        $email = trim($request->post('email'));
        $phone = trim($request->post('phone'));
        $province = $request->post('province');
        $district = $request->post('district');
        $ward_name = $request->post('ward_name');
        $province_name = $request->post('province_name');
        $district_name = $request->post('district_name');
        $ward = $request->post('ward');
        $address = trim($request->post('address'));

        $cart = Cart::instance('cart')->content();
        $order_products = [];
        $product_ids = [];
        foreach ($cart as $item) {
            $order_product = new OrderProduct();
            $order_product->qty = $item->qty;
            $order_product->price = $item->price;
            $order_product->product_id = $item->id;
            $order_product->product_name = $item->name;
            array_push($order_products, $order_product);
            array_push($product_ids, $item->id);
        }

        $exist_out_of_stock_product_count = Product::whereIn('id', $product_ids)->where(function ($query) {
            $query->orWhere('stock_status', 0);
            $query->orWhere(function ($query) {
                $query->where('stock_status', null)
                    ->where('quantity', 0)
                    ->where('allow_checkout_when_out_of_stock', 0);
            });
        })->count();
        if ($exist_out_of_stock_product_count > 0)
            return $ajax_response->setMessage("Một số sản phẩm đã hết hàng, vui lòng cập nhật lại giỏ hàng!")->toApiResponse();

        // Order Address
        $order_address = new OrderAddress();
        $order_address->name = $name;
        $order_address->phone = $phone;
        $order_address->email = $email;
        $order_address->province = $province;
        $order_address->province_name = $province_name;
        $order_address->district = $district;
        $order_address->district_name = $district_name;
        $order_address->ward = $ward;
        $order_address->ward_name = $ward_name;
        $order_address->address = $address;

        // Order
        $order = new Order();
        if (is_null(session()->get(self::$CODE))) {
            $data = $this->buildCartResponse();
        } else {
            $data = $this->doApplyCoupon(session()->get(self::$CODE));
            $order->discount_value = $data["discountValue"];
            $order->coupon_code = $data["activeDiscountCode"];
        }

        $order->sub_total = $data["subTotal"];
        $order->sub_total_final = $data["subTotalFinal"];
        $order->description = $request->post('description');
        $order->payment_method = $payment_method;
        $order->shipping_fee = $data["shippingFee"];

//        if ($product->with_storehouse_management == 1 && $product->quantity > 0) {
//            $product->quantity = $product->quantity - 1;
//            $product->update();
//        }

        DB::beginTransaction();
        try {
            $order->save();
            $order->address()->save($order_address);
            $order->orderProducts()->saveMany($order_products);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        try {
            foreach ($order_products as $order_product) {
                $product_db = Product::find($order_product->product_id);
                if ($product_db->with_storehouse_management == 1 && $product_db->quantity > 0) {
                    $quantity = $product_db->quantity - $order_product->quantity;
                    $product_db->quantity = $quantity < 0 ? 0 : $quantity;
                }
            }
        } catch (\Exception $e) {

        }

        Cart::instance('cart')->destroy();
        session()->forget(self::$CODE);

        $order_information = new stdClass();
        $order_information->name = $order_address->name;
        $order_information->phone = $order_address->phone;
        $order_information->email = $order_address->email;
        $order_information->province = $order_address->province;
        $order_information->province_name = $order_address->province_name;
        $order_information->district = $order_address->district;
        $order_information->district_name = $order_address->district_name;
        $order_information->ward = $order_address->ward;
        $order_information->ward_name = $order_address->ward_name;
        $order_information->address = $order_address->address;
        $order_information->payment_method = $order->payment_method;

        //send mail
        $data = [
            'cart' => $order_products,
            'order_information' => $order_information,
            'order' => $order,
        ];
        SendEmail::dispatch($data, $order_address->email);
        return $ajax_response->setData($order_information)->setMessage("Đặt hàng thành công!")->toApiResponse();
    }

    public function sendMail(Request $request)
    {
        $message = [
            'type' => 'Create task',
            'task' => "tasklet",
            'content' => 'has been created!',
        ];
        SendEmail::dispatch($message, "tientungs295@gmail.com");
    }
}
