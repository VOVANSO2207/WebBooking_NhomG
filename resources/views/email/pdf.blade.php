<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; }
        .header { text-align: center; margin-bottom: 20px; }
        .booking-info { margin: 20px 0; }
        .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .total { margin-top: 20px; text-align: right; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <h1>Hóa đơn đặt phòng</h1>
            <p>Mã đặt phòng: #{{ $booking->booking_id }}</p>
        </div>

        <div class="booking-info">
            <h3>Thông tin khách hàng</h3>
            <p>Tên: {{ $user->usernamename }}</p>
            <p>Email: {{ $user->email }}</p>
            <p>Điện thoại: {{ $user->phone_number }}</p>
        </div>

        <table class="table">
            <tr>
                <th>Tên phòng</th>
                <th>Ngày nhận</th>
                <th>Ngày trả</th>
                <th>Số đêm</th>
                <th>Giá/đêm</th>
            </tr>
            <tr>
                <td>{{ $room->name }}</td>
                <td>{{ $booking->check_in_date }}</td>
                <td>{{ $booking->check_out_date }}</td>
                <td>{{ $booking->nights }}</td>
                <td>{{ number_format($room->price) }} VNĐ</td>
            </tr>
        </table>

        <div class="total">
            {{-- <p><strong>Tạm tính:</strong> {{ number_format($booking->subtotal) }} VNĐ</p>
            @if($promotion)
                <p><strong>Khuyến mãi:</strong> {{ $promotion->discount }}%</p>
            @endif --}}
            <p><strong>Tổng cộng:</strong> {{ number_format($booking->total_amount) }} VNĐ</p>
            <p><strong>Trạng thái:</strong> Đã thanh toán</p>
            <p><strong>Phương thức:</strong> VNPAY</p>
            <p><strong>Mã giao dịch:</strong> {{ $payment->vnp_transaction_no }}</p>
        </div>
    </div>
</body>
</html>