<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Exception;
class AuthController extends Controller
{

    public function register(Request $request)
    {
        try {
            // Gọi phương thức registerUser từ model để đăng ký người dùng
            $user = User::registerUser($request->all());

            // Đăng ký thành công, chuyển hướng đến trang đăng nhập
            return redirect()->route('login')->with('success', 'Đăng ký thành công! Bạn có thể đăng nhập.');
        } catch (Exception $e) {
            // Trả về lỗi nếu có
            return back()->withErrors(['error' => 'Đăng ký thất bại: ' . $e->getMessage()])->withInput();
        }
    }
    public function login(Request $request)
    {
        // Validate dữ liệu
        $credentials = $request->only('login', 'password');
        $remember = $request->has('remember'); // Kiểm tra checkbox "Ghi nhớ đăng nhập"

        try {
            // Gọi hàm authenticate từ model để tìm và xác thực người dùng
            $user = User::authenticate($credentials);

            // Đăng nhập người dùng với tùy chọn "Ghi nhớ đăng nhập"
            Auth::login($user, $remember); // Thêm $remember để kích hoạt chức năng nhớ

            // Tạo session token mới
            $request->session()->regenerate();

            // Lưu thông tin đăng nhập vào cookie nếu chọn "Ghi nhớ đăng nhập"
            if ($remember) {
                Cookie::queue('remember_login', $credentials['login'], 43200); // Lưu trong 30 ngày
            } else {
                Cookie::queue(Cookie::forget('remember_login')); // Xóa cookie nếu không chọn
            }

            // Thiết lập thông báo vào session
            session([
                'notifications' => [
                    ['content' => 'Stay Nest xin chào bạn!'],
                ]
            ]);

            // Điều hướng người dùng dựa trên vai trò
            return match ($user->role_id) {
                1 => redirect()->route('admin.index'),
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

        // Xóa cookie ghi nhớ đăng nhập
        // Cookie::queue(Cookie::forget('remember_login'));

        return redirect('/login')->with('success', 'Đăng xuất thành công');
    }

}
