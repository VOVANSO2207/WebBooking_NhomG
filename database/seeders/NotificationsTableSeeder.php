<?php

namespace Database\Seeders;

use App\Models\Notifications;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Notifications::insert([
            [
                'user_id' => 1,
                'message' => 'Bạn có một đơn hàng mới đang chờ xác nhận.',
                'status' => 'chưa đọc',
            ],
            [
                'user_id' => 2,
                'message' => 'Đơn hàng của bạn đã được gửi đi.',
                'status' => 'chưa đọc',
            ],
            [
                'user_id' => 3,
                'message' => 'Bạn có tin nhắn mới từ hỗ trợ khách hàng.',
                'status' => 'đã đọc',
            ],
            [
                'user_id' => 4,
                'message' => 'Yêu cầu đổi mật khẩu của bạn đã thành công.',
                'status' => 'chưa đọc',
            ],
            [
                'user_id' => 5,
                'message' => 'Cập nhật hệ thống sẽ diễn ra vào lúc 00:00 ngày mai.',
                'status' => 'đã đọc',
            ],
            [
                'user_id' => 6,
                'message' => 'Bạn đã đạt được hạng thành viên VIP.',
                'status' => 'chưa đọc',
            ],
            [
                'user_id' => 7,
                'message' => 'Thông báo khuyến mãi đặc biệt cho khách hàng thân thiết.',
                'status' => 'đã đọc',
            ],
            [
                'user_id' => 8,
                'message' => 'Đơn hàng của bạn đã bị hủy.',
                'status' => 'chưa đọc',
            ],
            [
                'user_id' => 9,
                'message' => 'Sản phẩm trong giỏ hàng của bạn đang giảm giá.',
                'status' => 'đã đọc',
            ],
            [
                'user_id' => 10,
                'message' => 'Phiếu giảm giá của bạn sắp hết hạn.',
                'status' => 'chưa đọc',
            ],
        ]);
    }
}
