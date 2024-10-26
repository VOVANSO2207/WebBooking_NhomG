<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'username' => 'required|string|max:25|unique:users,username',
            'email' => 'required|string|email|max:255|min:5|regex:/^[^@.]+@[A-Za-z0-9-]+\.[A-Za-z0-9-]+$/|unique:users,email',
            'phone_number' => 'required|string|regex:/^0[0-9]{9}$/',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập.',
            'username.max' => 'Tên đăng nhập không được vượt quá 25 ký tự.',
            'username.unique' => 'Tên đăng nhập đã tồn tại, vui lòng chọn tên khác.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.max' => 'Địa chỉ email không được dài quá 255 ký tự.',
            'email.min' => 'Địa chỉ email phải từ 5 ký tự trở lên.',
            'email.regex' => 'Địa chỉ email không đúng định dạng.',
            'email.unique' => 'Địa chỉ email này đã được sử dụng, vui lòng chọn email khác.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'phone_number.regex' => 'Số điện thoại hợp lệ là ký tự số bắt đầu bằng 0 và có 10 chữ số.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Vui lòng xác nhận lại mật khẩu.',
        ]);
       
        // Đăng ký người dùng mới
        $user = User::register($request->all());
        $user->save();
        return redirect()->route('login')->with('success', 'Đăng ký thành công! Bạn có thể đăng nhập.');
    }
    public function login(Request $request)
    {
        // Validate dữ liệu
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
    
        // Thử đăng nhập bằng username hoặc email
        try {
            // Tìm người dùng theo login (email hoặc username)
            $user = User::login($credentials); // Gọi hàm login từ model
            
            // Nếu người dùng tồn tại và mật khẩu chính xác
            $request->session()->regenerate(); // Tái tạo session ID để ngăn chặn session fixation
            
            Auth::login($user); // Đăng nhập người dùng
    
            // Kiểm tra vai trò và điều hướng đến trang tương ứng
            switch ($user->role_id) {
                case 1: // Giả sử role_id 1 là admin
                    return redirect()->route('admin');
                case 2: // Giả sử role_id 2 là user
                    return redirect()->route('home'); 
                default: // Các quyền khác
                    return redirect()->route('error'); 
            }
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput(); // Trả về lỗi nếu có
        }
    }
    
   
}



