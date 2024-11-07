<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        // Kiểm tra người dùng đã đăng nhập và token có trong session
        if (Auth::check() && Session::has('session_token')) {
            return $next($request);
        }

        Auth::logout();
        Session::flush();

        return redirect()->route('login')->withErrors(['session' => 'Session expired, please login again.']);
    }
}


