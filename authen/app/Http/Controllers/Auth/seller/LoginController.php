<?php

namespace App\Http\Controllers\Auth\Seller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    //
    use AuthenticatesUsers;
    public function __construct()
    {
        $this->middleware('guest:seller')->except('logout');
    }
    public function login(){
        return view('seller.auth.login');

    }
    public function loginSeller(Request $request){
        // validate dữ liệu
        $this->validate($request,array(
            'email'=>'require|email',
            'password'=>'require|min:6'
        ));
        //đăng nhập
        if (Auth::guard('seller')->attempt(
            ['email'=>$request->email,'password'=>$request->passqword],$request->remember
        )){
            //nếu đăng nhập thành công sẽ chuyển hướng về viewdashboard của admin
            return redirect()->intended(route('seller.dashboard'));
        }
        //nếu ddawng nhập thất bại quay trở về form đăng nhập
        return redirect()->back()->withInput($request->only('email','remember'));
    }
    /**
     * phương thức này dùng để đăng xuất
     */
    public function logout(){
        Auth::guard('seller')->logout();

        return redirect()->route('seller.auth.login');

    }
}
