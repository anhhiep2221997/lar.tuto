<?php
namespace App\Http\Controllers\Auth\Seller;
use App\Model\SellerModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class SellerController extends Controller
{
    /**
     * Xây dựng phương thức khởi tạo cho class này
     */
    public function __construct()
    {
        $this->middleware('auth:seller')->only('index');
    }
    public function index(){
        return view('seller.dashboard');
    }
    /**
     * Phương thức trả về view dùng để đăng ký tài khoản seller
     * @return Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view('seller.auth.register');
    }
    public function store(Request $request){
        //validate dữ liệu được gửi từ form đăng ký
        $this->validate($request, array(
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ));
        // khởi tạo Model để lưu seller mới
        $sellerModel = new SellerModel();
        $sellerModel->name = $request->name;
        $sellerModel->email = $request->email;
        $sellerModel->password = bcrypt($request->password);
        $sellerModel->save();
        return redirect()->route('seller.auth.login');
    }
}