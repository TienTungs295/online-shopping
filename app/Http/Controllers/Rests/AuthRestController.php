<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Http\Responses\AjaxResponse;
use App\Jobs\SendMailResetPassword;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Models\CustomerAccount;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isEmpty;


class AuthRestController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email không được phép bỏ trống',
                'password.required' => 'Mật khẩu không được phép bỏ trống'
            ]);
        $ajax_response = new AjaxResponse();

        if ($validator->fails()) {
            return $ajax_response->setErrors($validator->errors())->toApiResponse();
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return $ajax_response->setErrors(array('login' => ['Tài khoản hoặc mật khẩu không chính xác!']))->toApiResponse();
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a CustomerAccount.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:200',
                'email' => 'required|string|email|max:200|unique:customer_accounts',
                'password' => 'required|string|min:8|max:50',
                'confirm_password' => 'required|string|same:password',
            ],
            [
                'name.required' => 'Tên người dùng không được phép bỏ trống',
                'name.max' => 'Tên người dùng không được phép vượt quá 200 ký tự',
                'email.required' => 'Email không được phép bỏ trống',
                'email.email' => 'Email không hợp lệ',
                'email.max' => 'Email không được phép vượt quá 200 ký tự',
                'email.unique' => 'Tài khoản đã tồn tại',
                'password.required' => 'Mật khẩu không được phép bỏ trống',
                'password.min' => 'Mật khẩu phải có tối thiểu 8 ký tự',
                'password.max' => 'Mật khẩu không đươc phép vượt quá 50 ký tự',
                'confirm_password.required' => 'Mật khẩu xác nhận không được phép bỏ trống',
                'confirm_password.same' => 'Mật khẩu xác nhận không chính xác'
            ]
        );
        $ajax_response = new AjaxResponse();
        if ($validator->fails()) {
            return $ajax_response->setErrors($validator->errors())->toApiResponse();
        }

        $user = CustomerAccount::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        return $ajax_response->setData($user)->setMessage("Đăng ký tài khoản thành công")->toApiResponse();
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        $ajax_response = new AjaxResponse();
        return $ajax_response->setStatus(2)->toApiResponse();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated CustomerAccount.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        $ajax_response = new AjaxResponse();
        return $ajax_response->setData(auth()->user())->toApiResponse();
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        $ajax_response = new AjaxResponse();
        return $ajax_response->setData([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ])->toApiResponse();
    }

    public function changePassWord(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'new_password' => 'required|string|min:8|max:50',
                'confirm_new_password' => 'required|string|same:new_password',
            ],
            [
                'new_password.required' => 'Mật khẩu không được phép bỏ trống',
                'new_password.min' => 'Mật khẩu phải có tối thiểu 8 ký tự',
                'new_password.max' => 'Mật khẩu không đươc phép vượt quá 50 ký tự',
                'confirm_new_password.required' => 'Mật khẩu xác nhận không được phép bỏ trống',
                'confirm_new_password.same' => 'Mật khẩu xác nhận không chính xác'
            ]
        );
        $ajax_response = new AjaxResponse();
        if (!Hash::check($request->post('old_password'), auth()->user()->password))
            return $ajax_response->setErrors(array('old_password' => ['Mật khẩu hiện tại không chính xác']))->toApiResponse();

        if ($validator->fails())
            return $ajax_response->setErrors($validator->errors())->toApiResponse();

        try {
            $customer_account = CustomerAccount::findOrFail(auth()->user()->id);
        } catch (ModelNotFoundException $e) {
            return $ajax_response->setMessage("Tài khoản không tồn tại hoặc đã bị xóa")->toApiResponse();
        }
        $customer_account->password = bcrypt($request->post('new_password'));
        $customer_account->update();
        return $ajax_response->setStatus(2)->setMessage("Cập nhật tài khoản thành công")->toApiResponse();
    }

    public function changePassWordWithToken(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $customer_account = CustomerAccount::where('email', $request->post("email"))->first();
        if (is_null($customer_account))
            return $ajax_response->setErrors(array("email" => "Email không tồn tại"))->toApiResponse();

        if ($customer_account->token != $request->post('token'))
            return $ajax_response->setErrors(array('token' => ['Token không hợp lệ']))->toApiResponse();

        if (!empty($customer_account->token_gen_at) && (time() - $customer_account->token_gen_at->timestamp > 5 * 60))
            return $ajax_response->setErrors(array('token' => ['Token đã hết hạn']))->toApiResponse();

        $validator = Validator::make($request->all(),
            [
                'new_password' => 'required|string|min:8|max:50',
                'confirm_new_password' => 'required|string|same:new_password',
            ],
            [
                'new_password.required' => 'Mật khẩu không được phép bỏ trống',
                'new_password.min' => 'Mật khẩu phải có tối thiểu 8 ký tự',
                'new_password.max' => 'Mật khẩu không đươc phép vượt quá 50 ký tự',
                'confirm_new_password.required' => 'Mật khẩu xác nhận không được phép bỏ trống',
                'confirm_new_password.same' => 'Mật khẩu xác nhận không chính xác'
            ]
        );
        if ($validator->fails())
            return $ajax_response->setErrors($validator->errors())->toApiResponse();

        $customer_account->token = "";
        $customer_account->token_gen_at = null;
        $customer_account->password = bcrypt($request->post('new_password'));
        $customer_account->update();
        return $ajax_response->setStatus(2)->setMessage("Cập nhật mật khẩu thành công")->toApiResponse();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:200',
                'phone_number' => 'max:15',
                'address' => 'max:350',
            ],
            [
                'name.required' => 'Tên người dùng không được phép bỏ trống',
                'name.max' => 'Tên người dùng không được phép vượt quá 200 ký tự',
                'phone_number.max' => 'Số điện thoại không được phép vượt quá 15 ký tự',
                'address.max' => 'Địa chỉ không được phép vượt quá 350 ký tự',
            ]
        );
        $ajax_response = new AjaxResponse();
        if ($validator->fails()) {
            return $ajax_response->setErrors($validator->errors())->toApiResponse();
        }
        try {
            $customer_account = CustomerAccount::findOrFail($request->post('id'));
        } catch (ModelNotFoundException $e) {
            return $ajax_response->setMessage("Tài khoản không tồn tại hoặc đã bị xóa")->toApiResponse();
        }
        $customer_account->name = $request->post('name');
        $customer_account->phone_number = $request->post('phone_number');
        $customer_account->address = $request->post('address');
        $customer_account->update();
        return $ajax_response->setData($customer_account)->setMessage("Cập nhật tài khoản thành công")->toApiResponse();
    }


    public function validateToken(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $customer_account = CustomerAccount::where('token', $request->input('token'))->first();
        if (is_null($customer_account))
            return $ajax_response->setMessage("Token không hợp lệ")->toApiResponse();
        if (!empty($customer_account->token_gen_at) && (time() - $customer_account->token_gen_at->timestamp > 5 * 60))
            return $ajax_response->setMessage("Token đã hết hạn")->toApiResponse();
        return $ajax_response->setData(2)->toApiResponse();
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email',
            ],
            [
                'email.required' => 'Email không được phép bỏ trống',
                'email.email' => 'Email không hợp lệ'
            ]
        );

        $ajax_response = new AjaxResponse();
        if ($validator->fails()) {
            return $ajax_response->setErrors($validator->errors())->toApiResponse();
        }

        $customer_account = CustomerAccount::where('email', $request->post('email'))->first();
        if (is_null($customer_account)) {
            return $ajax_response->setErrors(array('email' => ['Email không tồn tại']))->toApiResponse();
        }

        $token = Str::random(60);

        $customer_account->token = $token;
        $customer_account->token_gen_at = Carbon::now();
        $customer_account->update();
        $forgot_password_url = url('doi-mat-khau/' . $token);
        SendMailResetPassword::dispatch($customer_account, $forgot_password_url);
        return $ajax_response->setData(array("email" => $customer_account->email))->toApiResponse();
    }

    public function isAuthenticated(Request $request)
    {
        $ajax_response = new AjaxResponse();
        return $ajax_response->setStatus(2)->toApiResponse();
    }
}
