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
                'email' => 'required|string|email|max:200',
            ],
            [
                'email.required' => 'Email không được phép bỏ trống',
                'email.email' => 'Email không hợp lệ',
                'email.max' => 'Email không được phép vượt quá 200 ký tự',
            ]);
        $ajax_response = new AjaxResponse();
        if ($validator->fails()) {
            return $ajax_response->setErrors($validator->errors())->toApiResponse();
        }
        $exist = CustomerInfo::where('email', $request->post("email"))->count();
        if ($exist > 0) return $ajax_response->setMessage("Thành công")->setStatus(2)->toApiResponse();
        $customer_info = new CustomerInfo();
        $customer_info->email = $request->post("email");
        $customer_info->save();
        return $ajax_response->setMessage("Thành công")->setStatus(2)->toApiResponse();
    }
}
