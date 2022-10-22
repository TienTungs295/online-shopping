<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Http\Responses\AjaxResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\CustomerAccount;
use Validator;

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
            return $ajax_response->setErrors(array('login' => 'Tài khoản hoặc mật khẩu không chính xác!'))->toApiResponse(401);
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
            'confirm_password' => 'required|string|same:password|min:8',
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
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|confirmed|min:6',
        ]);
        $ajax_response = new AjaxResponse();
        if ($validator->fails()) {
            return $ajax_response->setErrors($validator->errors())->toApiResponse();
        }
        $userId = auth()->user()->id;
        $user = CustomerAccount::where('id', $userId)->update(
            ['password' => bcrypt($request->new_password)]
        );
        return $ajax_response->setStatus(2)->toApiResponse();
    }

    public function isAuthenticated(Request $request)
    {
        $ajax_response = new AjaxResponse();
        return $ajax_response->setStatus(2)->toApiResponse();
    }
}
