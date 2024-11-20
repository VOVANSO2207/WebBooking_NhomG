<h2>Thông báo thanh toán không thành công</h2>

<p>Kính gửi {{ $booking->user->username }},</p>

<p>Chúng tôi rất tiếc phải thông báo rằng giao dịch thanh toán của bạn không thành công.</p>

<p><strong>Chi tiết đơn hàng:</strong></p>
<ul>
    <li>Mã đơn hàng: {{ $booking->booking_id }}</li>
    <li>Số tiền: {{ number_format($booking->total_price) }} VNĐ</li>
    <li>Thời gian: {{ $payment->payment_date }}</li>
</ul>

<p>Vui lòng thử lại hoặc liên hệ với chúng tôi nếu bạn cần hỗ trợ thêm.</p>