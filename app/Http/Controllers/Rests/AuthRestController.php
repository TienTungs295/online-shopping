<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Http\Responses\AjaxResponse;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\CustomerAccount;
use Validator;
use Illuminate\Support\Facades\Hash;


class AuthRestController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        $ajax_response = new AjaxResponse();

        if ($validator->fails()) {
            return $ajax_response->setErrors($validator->errors())->toApiResponse();
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return $ajax_response->setErrors(array('login' => ['Tài khoản hoặc mật khẩu không chính xác!']))->toApiResponse(401);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:200|unique:customer_accounts',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|strings|same:password',
        ]);
        $ajax_response = new AjaxResponse();
        if ($validator->fails()) {
            return $ajax_response->setErrors($validator->errors())->toApiResponse();
        }

        $user = CustomerAccount::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        return $ajax_response->setData($user)->toApiResponse();
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
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|string|min:8',
            'confirm_new_password' => 'required|string|same:new_password',
        ]);
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

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone_number' => 'max:15',
            'address' => 'max:350',
        ]);
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

    public function isAuthenticated(Request $request)
    {
        $ajax_response = new AjaxResponse();
        return $ajax_response->setStatus(2)->toApiResponse();
    }
}
