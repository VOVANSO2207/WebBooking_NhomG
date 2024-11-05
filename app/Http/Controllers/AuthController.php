<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
        $credentials = $request->only('login', 'password');
    
        try {
            // Gọi hàm authenticate từ model để tìm và xác thực người dùng
            $user = User::authenticate($credentials);
    
            // Đăng nhập người dùng
            Auth::login($user);
            $request->session()->regenerate();
    
            // Tạo một session token mới
            $sessionToken = bin2hex(random_bytes(32));
            
            // Lưu session token vào Laravel session
            $request->session()->put('session_token', $sessionToken);
    
            // Điều hướng người dùng dựa trên vai trò
            return match ($user->role_id) {
                1 => redirect()->route('admin'),
                2 => redirect('/'),
                default => redirect()->route('error'),
            };
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput(); // Trả về lỗi nếu có
        }
    }
    
    public function logout(Request $request)
    {
        $request->session()->forget('session_token');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Đăng xuất thành công');
    }
    
}
