<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->input('q');
        if ($q != "") {
            $users = User::where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            })->orderBy('id', 'DESC')
                ->paginate(25);
            $users->appends(['q' => $q]);
        } else {
            $users = User::orderBy('id', 'DESC')->paginate(25);
        }
        return View('backend.user.index', compact("users", "q"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ((auth()->user()->role & 2) == 0) {
            return abort('403');
        }
        return view('backend.user.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ((auth()->user()->role & 2) == 0) {
            return redirect()->back()->with('error', 'Bạn không đủ quyền thực hiện chức năng này');
        }

        $request->validate(
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|min:8|max:255',
                'password_confirm' => 'required|min:8|max:255|same:password',
                'role' => 'required',
            ],
            [
                'name.required' => 'Tên nhân viên không được phép bỏ trống',
                'name.max' => 'Tên nhân viên không được vượt quá 255 ký tự',
                'email.required' => 'Email không được phép bỏ trống',
                'email.email' => 'Email không hợp lệ',
                'email.max' => 'Email không được vượt quá 255 ký tự',
                'password.required' => 'Mật khẩu không được phép bỏ trống',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
                'password.max' => 'Mật khẩu không được vượt quá 255 ký tự',
                'password_confirm.required' => 'Mật khẩu xác nhận không được phép bỏ trống',
                'password_confirm.min' => 'Mật khẩu xác nhận phải có ít nhất 8 ký tự',
                'password_confirm.max' => 'Mật khẩu xác nhận không được vượt quá 255 ký tự',
                'password_confirm.same' => 'Mật khẩu xác nhận không chính xác',
                'role.required' => 'Vai trò nhân viên không được phép bỏ trống',
            ]);

        $count_name_exist = User::where('name', $request->name)->count();
        if ($count_name_exist >= 1) {
            return redirect()->back()->with('error', 'Tên nhân viên đã tồn tại');
        }

        $count_email_exist = User::where('email', $request->email)->count();
        if ($count_email_exist >= 1) {
            return redirect()->back()->with('error', 'Email đã tồn tại');
        }
        if ($request->input('password') != $request->input('password_confirm')) {
            return redirect()->back()->with('error', 'Mật khẩu xác nhận không chính xác');
        }

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('role');
        $user->save();

        return redirect()->route("userView")->with('success', 'Thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if ((auth()->user()->role & 2) == 0) {
            return abort('403');
        }

        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $user->password_confirm = $user->password;
        return view('backend.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ((auth()->user()->role & 2) == 0) {
            return redirect()->back()->with('error', 'Bạn không đủ quyền thực hiện chức năng này');
        }

        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route("userView")->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $request->validate(
            [
                'name' => 'required|max:255',
                'role' => 'required',
            ],
            [
                'name.required' => 'Tên nhân viên không được phép bỏ trống',
                'name.max' => 'Tên nhân viên không được vượt quá 255 ký tự',
                'role.required' => 'Vai trò nhân viên không được phép bỏ trống',
            ]);

        $count_name_exist = User::where('name', $request->name)->where('id', '<>', $id)->count();
        if ($count_name_exist >= 1) {
            return redirect()->back()->with('error', 'Tên nhân viên đã tồn tại');
        }
        $password = $request->input("password");
        $password_confirm = $request->input("password_confirm");
        if (!is_null($password)) {
            if (strlen($password) < 8)
                return redirect()->back()->with('error', 'Mật khẩu phải có ít nhất 8 ký tự');
            if (strlen($password) > 255)
                return redirect()->back()->with('error', 'Mật khẩu không được vượt quá 255 ký tự');
            if (is_null($password_confirm)) {
                return redirect()->back()->with('error', 'Mật khẩu xác nhận không được phép bỏ trống');
            }
            if ($password != $password_confirm) {
                return redirect()->back()->with('error', 'Mật khẩu xác nhận không chính xác');
            }

            $user->password = bcrypt($request->input('password'));
        }

        $user->name = $request->input('name');
        if ($user->role != 7 && auth()->user()->id != $user->id) {
            $user->role = $request->input('role');
        }
        $user->update();
        return redirect()->route("userView")->with('success', 'Thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }
        if ((auth()->user()->role & 2) == 0 || $user->id == auth()->user()->id || $user->role == 7) {
            return redirect()->back()->with('error', 'Bạn không đủ quyền thực hiện chức năng này');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Thành công');
    }
}
