
@extends('layouts.app')

@section('content')
    <div class="payment-result-container">
        <div class="container">
            <div class="payment-card">
                <!-- Header Section -->
                <div class="payment-header">
                    @if ($success)
                        <div class="payment-icon success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h1 class="payment-title">Đặt phòng thành công!</h1>
                        <p class="payment-subtitle">{{ $message }}</p>
                        <p class="payment-subtitle">Cảm ơn bạn đã đặt phòng.
                            @if ($emailSent)
                                <span>Chi tiết đặt phòng đã được gửi qua email của bạn.</span>
                            @else
                                <span>Email gửi thất bại. Vui lòng kiểm tra lại!</span>
                            @endif
                        </p>
                    @else
                        <div class="payment-icon error">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <h1 class="payment-title">Thanh toán không thành công</h1>
                        <p class="payment-subtitle">{{ $message }}</p>
                    @endif
                </div>

                <!-- Transaction Details -->
                <div class="payment-details">
                    <h2 class="details-title">Chi tiết đặt phòng</h2>
                    <div class="details-list">
                        <div class="detail-item">
                            <span class="detail-label">Mã thanh toán:</span>
                            <span class="detail-value">{{ $booking->booking_id}}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Số tiền:</span>
                            <span class="detail-value">{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Phương thức:</span>
                            <span class="detail-value">Thanh toán khi nhận phòng</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Trạng thái:</span>
                            <span class="detail-value {{ $success ? 'text-success' : 'text-danger' }}">
                                {{ $success ? 'Thành công' : 'Thất bại' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="payment-actions">
                    @if ($success)
                        {{-- <a href="{{ route('booking.detail') }}" class="btn btn-primary">
                        Xem chi tiết đặt phòng
                    </a> --}}
                    @else
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            Thử lại
                        </a>
                    @endif
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">
                        Về trang chủ
                    </a>
                </div>
            </div>

            <!-- Additional Information -->
            @if ($success)
                <div class="info-card">
                    <h3 class="info-title">Thông tin quan trọng</h3>
                    <ul class="info-list">
                        <li>Vui lòng kiểm tra email để xem chi tiết đặt phòng của bạn</li>
                        <li>Bạn có thể xem lại thông tin đặt phòng trong phần "Đơn đặt phòng" của tài khoản</li>
                        <li>Nếu cần hỗ trợ, vui lòng liên hệ hotline: 1900 xxxx</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <style>
        .payment-result-container {
            min-height: 100vh;
            background-color: #f8f9fa;
            padding: 40px 0;
        }

        .payment-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .payment-header {
            text-align: center;
            padding: 30px;
            border-bottom: 1px solid #eee;
        }

        .payment-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }

        .payment-icon.success {
            color: #28a745;
        }

        .payment-icon.error {
            color: #dc3545;
        }

        .payment-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .payment-subtitle {
            color: #666;
            margin-bottom: 0;
        }

        .payment-details {
            padding: 30px;
        }

        .details-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .details-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .detail-label {
            color: #666;
        }

        .detail-value {
            font-weight: 500;
            color: #333;
        }

        .payment-actions {
            padding: 20px 30px;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .info-card {
            background: #e8f4ff;
            border: 1px solid #b8daff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
        }

        .info-title {
            color: #004085;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .info-list {
            list-style-type: disc;
            margin-left: 20px;
            color: #004085;
        }

        .info-list li {
            margin-bottom: 10px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .payment-result-container {
                padding: 20px;
            }

            .detail-item {
                flex-direction: column;
                gap: 5px;
            }

            .detail-value {
                text-align: right;
            }

            .payment-actions {
                flex-direction: column;
            }

            .payment-actions .btn {
                width: 100%;
            }
        }
    </style>
@endsection

