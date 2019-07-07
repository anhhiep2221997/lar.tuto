<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class logincontroller extends Controller
{
    //
    use AuthenticatesUsers;
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * phương thức này trả về view dùng để đăng nhập cho admin
     */
    public function login(){
        return view('admin.auth.login');

    }

    /**
     * phương thức này  dùng để đăng nhập cho admin
     * lấy thông tin từ form và method là post
     */
    public function loginAdmin(Request $request){
        // validate dữ liệu
        $this->validate($request,array(
            'email'=>'require|email',
            'password'=>'require|min:6'
        ));
        //đăng nhập
        if (Auth::guard('admin')->attempt(
         ['email'=>$request->email,'password'=>$request->passqword],$request->remember
        )){
            //nếu đăng nhập thành công sẽ chuyển hướng về viewdashboard của admin
            return redirect()->intended(route('admin.dashboard'));
        }
        //nếu ddawng nhập thất bại quay trở về form đăng nhập
        return redirect()->back()->withInput($request->only('email','remember'));
    }
    /**
     * phương thức này dùng để đăng xuất
     */
    public function logout(){
        Auth::guard('admin')->logout();

        return redirect()->route('admin.auth.login');

    }
}
