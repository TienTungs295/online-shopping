<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Http\Responses\AjaxResponse;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Jobs\SendEmail;
use \stdClass;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class OrderRestController extends Controller
{
    public function checkOut(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $cartCount = Cart::instance('cart')->count();
        if ($cartCount == 0)
            return $ajax_response->setMessage("Hiện không có sản phẩm nào trong giỏ hàng!")->toApiResponse();

        $name = trim($request->post('name'));
        $phone = trim($request->post('phone'));
        $province = $request->post('province');
        $district = $request->post('district');
        $ward = $request->post('ward');
        $provinceName = $request->post('provinceName');
        $districtName = $request->post('districtName');
        $wardName = $request->post('wardName');
        $address = trim($request->post('address'));
        $payment_method = $request->post('payment_method');
        $shipping_fee = $request->post('shipping_fee');
        if (empty($name))
            return $ajax_response->setMessage("Vui lòng nhập Họ và tên!")->toApiResponse();

        if (empty($phone))
            return $ajax_response->setMessage("Vui lòng nhập Số điện thoại!")->toApiResponse();

        if (empty($province))
            return $ajax_response->setMessage("Vui lòng chọn Tỉnh thành!")->toApiResponse();

        if (empty($district))
            return $ajax_response->setMessage("Vui lòng chọn Quận huyện!")->toApiResponse();

        if (empty($ward))
            return $ajax_response->setMessage("Vui lòng chọn Phường xã!")->toApiResponse();

        if (empty($address))
            return $ajax_response->setMessage("Vui lòng nhập Địa chỉ chi tiết!")->toApiResponse();

        if (is_null($payment_method))
            return $ajax_response->setMessage("Vui lòng chọn phương thức thanh toán!")->toApiResponse();

        // Order Address
        $order_address = new OrderAddress();
        $order_address->name = $name;
        $order_address->phone = $phone;
        $order_address->email = $request->post('email');
        $order_address->province = $province;
        $order_address->provinceName = $provinceName;
        $order_address->district = $district;
        $order_address->districtName = $districtName;
        $order_address->ward = $ward;
        $order_address->wardName = $wardName;
        $order_address->address = $address;

        $cart = Cart::instance('cart')->content();
        $order_products = [];
        foreach ($cart as $item) {
            $order_product = new OrderProduct();
            $order_product->qty = $item->qty;
            $order_product->price = $item->price;
            $order_product->product_id = $item->id;
            $order_product->product_name = $item->name;
            array_push($order_products, $order_product);
        }

        // Order
        $order = $request->post('order');
        $order = new Order();
        $order->description = $request->post('description');
        $order->sub_total = $request->post('subTotal');
        $order->amount = $request->post('subTotal');
        $order->payment_method = $payment_method;
        if (isset($shipping_fee)) $order->shipping_fee = $shipping_fee;

        DB::beginTransaction();
        try {
            $order->save();
            $order->address()->save($order_address);
            $order->orderProducts()->saveMany($order_products);
            DB::commit();

            $message = [
                'type' => 'Create task',
                'task' => "tasklet",
                'content' => 'has been created!',
            ];
            SendEmail::dispatch($message, $order_address->email)->delay(now()->addMinute(1));
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        Cart::instance('cart')->destroy();

        $order_infomation = new stdClass();
        $order_infomation->name = $order_address->name;
        $order_infomation->phone = $order_address->phone;
        $order_infomation->email = $order_address->email;
        $order_infomation->province = $order_address->province;
        $order_infomation->provinceName = $order_address->provinceName;
        $order_infomation->district = $order_address->district;
        $order_infomation->districtName = $order_address->districtName;
        $order_infomation->ward = $order_address->ward;
        $order_infomation->wardName = $order_address->wardName;
        $order_infomation->address = $order_address->address;
        $order_infomation->payment_method = $order->payment_method;

        return $ajax_response->setData($order_infomation)->setMessage("Đặt hàng thành công!")->toApiResponse();
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
