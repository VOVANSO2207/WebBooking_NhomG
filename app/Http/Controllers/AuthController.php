<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
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
    
            // Thiết lập thông báo vào session
            session(['notifications' => [
                ['content' => 'Stay Nest xin chào bạn!'],
            ]]);

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

        return redirect('/')->with('success', 'Đăng xuất thành công');
    }

    
    
}
