<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\BaseCustomController;
use App\Http\Responses\AjaxResponse;
use App\Models\CustomerInfo;
use Illuminate\Http\Request;
use Validator;

class CustomerInfoRestController extends BaseCustomController
{
    public function store(Request $request)
    {
        $ajax_response = new AjaxResponse();
        if ($request->post("showMessage")) {
            $email = $request->post("email");
            if (is_null($email))
                return $ajax_response->setMessage("Email không được phép bỏ trống")->toApiResponse();
            if (!$this->valid_email($email))
                return $ajax_response->setMessage("Email không hợp lệ")->toApiResponse();
            if (strlen($email) > 200)
                return $ajax_response->setMessage("Email không được phép vượt quá 200 ký tự")->toApiResponse();
        }
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|string|email|max:200',
            ],
            [
                'email.required' => 'Email không được phép bỏ trống',
                'email.email' => 'Email không hợp lệ',
                'email.max' => 'Email không được phép vượt quá 200 ký tự',
            ]);
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
