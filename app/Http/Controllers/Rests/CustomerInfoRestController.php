<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Http\Responses\AjaxResponse;
use App\Models\CustomerInfo;
use Illuminate\Http\Request;
use Validator;

class CustomerInfoRestController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:200',
                'email' => 'required|string|email|max:200',
                'phone_number' => 'max:15',
            ],
            [
                'name.required' => 'Tên người dùng không được phép bỏ trống',
                'name.max' => 'Tên người dùng không được phép vượt quá 200 ký tự',
                'email.required' => 'Email không được phép bỏ trống',
                'email.email' => 'Email không hợp lệ',
                'email.max' => 'Email không được phép vượt quá 200 ký tự',
                'phone_number.max' => 'Số điện thoại không được phép vượt quá 15 ký tự',
            ]);
        $ajax_response = new AjaxResponse();
        if ($validator->fails()) {
            return $ajax_response->setErrors($validator->errors())->toApiResponse();
        }
        $customer_info = new CustomerInfo();
        $customer_info->name = $request->post("name");
        $customer_info->email = $request->post("email");
        $customer_info->phone_number = $request->post("phone_number");
        $customer_info->save();
        return $ajax_response->setMessage("Thành công")->setStatus(2)->toApiResponse();
    }
}
