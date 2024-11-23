<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Xác nhận đặt phòng #{{ $booking->booking_id }}</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            padding: 20px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }
        .details { 
            margin: 20px 0; 
        }
        .section {
            margin-bottom: 20px;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .note {
            font-size: 12px;
            margin-top: 40px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>XÁC NHẬN ĐẶT PHÒNG</h1>
        <h2>Mã đặt phòng: #{{ $booking->booking_id }}</h2>
    </div>

    <div class="section">
        <h3>THÔNG TIN KHÁCH HÀNG</h3>
        <p>Họ tên: {{ $user->username }}</p>
        <p>Email: {{ $user->email }}</p>
        <p>Điện thoại: {{ $user->phone ?? 'N/A' }}</p>
    </div>

    <div class="section">
        <h3>CHI TIẾT ĐẶT PHÒNG</h3>
        <p>Tên phòng: {{ $room->room_name }}</p>
        <p>Ngày nhận phòng: {{ date('d/m/Y', strtotime($booking->check_in)) }}</p>
        <p>Ngày trả phòng: {{ date('d/m/Y', strtotime($booking->check_out)) }}</p>
    </div>

    <div class="section">
        <h3>THÔNG TIN THANH TOÁN</h3>
        <p>Phương thức: VNPay</p>
        <p>Thời gian: {{ $payment->payment_date }}</p>
        <p>Mã giao dịch: {{ $payment->vnp_transaction_no ?? 'N/A' }}</p>
        <p>Ngân hàng: {{ $payment->vnp_bank_code ?? 'N/A' }}</p>
        
        @if($promotion)
        {{-- <p>Mã khuyến mãi: {{ $promotion->promotion_code }}</p> --}}
        @endif
    </div>

    <div class="total">
        Tổng tiền: {{ number_format($booking->total_price) }} VNĐ
    </div>

    <div class="note">
        Lưu ý: Đây là xác nhận đặt phòng chính thức. Vui lòng mang theo khi nhận phòng.
    </div>
</body>
</html>