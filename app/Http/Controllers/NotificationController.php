<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function deleteNotification($key)
    {
        // Lấy danh sách thông báo từ session
        $notifications = session('notifications', []);

        // Xóa thông báo nếu tồn tại
        if (isset($notifications[$key])) {
            unset($notifications[$key]);
            session(['notifications' => $notifications]); // Cập nhật session
        }

        return response()->json(['success' => true, 'message' => 'Thông báo đã được xóa']);
    }
}
