<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đặt Phòng</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.5;
            color: #1e293b;
            background-color: #f8fafc;
        }

        .container {
            max-width: 680px;
            margin: 2rem auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 25%, transparent 25%, transparent 50%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.1) 75%, transparent 75%, transparent);
            background-size: 4px 4px;
            opacity: 0.1;
        }

        .header h1 {
            color: white;
            font-size: 1.875rem;
            font-weight: 700;
            margin: 0;
            position: relative;
            letter-spacing: -0.025em;
        }

        .booking-status {
            display: inline-block;
            background-color: #22c55e;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 1rem;
            position: relative;
        }

        .content {
            padding: 2rem;
        }

        .section {
            margin-bottom: 2rem;
            background-color: white;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .section-title {
            color: #334155;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .info-item {
            background-color: #f8fafc;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .info-label {
            color: #475569;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: #1e293b;
            font-weight: 600;
            font-size: 1rem;
        }

        .price-summary {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin: 2rem 0;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .price-row:last-child {
            border: none;
            padding-top: 1rem;
            margin-top: 0.5rem;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .important-notes {
            background-color: #fff7ed;
            border-left: 4px solid #f59e0b;
            padding: 1.5rem;
            border-radius: 8px;
        }

        .important-notes h4 {
            color: #334155;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .important-notes ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .important-notes li {
            position: relative;
            padding-left: 1.5rem;
            color: #475569;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
        }

        .important-notes li:before {
            content: '•';
            position: absolute;
            left: 0;
            color: #f59e0b;
        }

        .amenities-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            list-style: none;
            padding: 1rem;
        }

        .amenity-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            background-color: #f8fafc;
            border-radius: 8px;
            font-size: 0.875rem;
            color: #475569;
        }

        .amenity-item:before {
            content: '✓';
            color: #2563eb;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            padding: 2rem;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .hotel-logo {
            width: 120px;
            height: 40px;
            background-color: #e2e8f0;
            margin: 0 auto 1.5rem;
            border-radius: 4px;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            background-color: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 0.875rem;
            color: #475569;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .social-links {
            margin-top: 1.5rem;
        }

        .social-link {
            display: inline-block;
            width: 32px;
            height: 32px;
            margin: 0 0.5rem;
            background-color: #f1f5f9;
            border-radius: 9999px;
            color: #64748b;
            line-height: 32px;
            text-decoration: none;
        }

        .disclaimer {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 1.5rem;
        }

        @media (max-width: 640px) {
            .container {
                margin: 0;
                border-radius: 0;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .amenities-list {
                grid-template-columns: 1fr;
            }

            .contact-info {
                flex-direction: column;
            }

            .header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Xác Nhận Đặt Phòng</h1>
            <div class="booking-status">✓ Đã Xác Nhận</div>
        </div>
        
        <div class="content">
            <div class="section">
                <h2 class="section-title">Thông Tin Đặt Phòng</h2>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Mã Đặt Phòng</div>
                        <div class="info-value">#{{ $booking->booking_id }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Họ Tên Khách Hàng</div>
                        <div class="info-value">{{ $user->username }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Ngày Nhận Phòng</div>
                        <div class="info-value">{{ date('d/m/Y', strtotime($booking->check_in)) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Ngày Trả Phòng</div>
                        <div class="info-value">{{ date('d/m/Y', strtotime($booking->check_out)) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tên Phòng</div>
                        <div class="info-value">{{ $booking->room->name ?? 'Standard Room' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Số Đêm</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out) }} đêm</div>
                    </div>
                </div>

                <div class="price-summary">
                    <div class="price-row">
                        <span>Giá phòng</span>
                        <span>{{ number_format($booking->room_price) }} VNĐ</span>
                    </div>
                    {{-- {{dd($booking)}} --}}
                    @if($booking->promotion_id)
                    <div class="price-row">
                        <span>Giảm giá</span>
                        <span>-{{ number_format($booking->discount) }} VNĐ</span>
                    </div>
                    @endif
                    <div class="price-row">
                        <span>Tổng thanh toán : </span>
                        <span>{{ number_format($booking->total_price) }} VNĐ</span>
                    </div>
                </div>

                <div class="important-notes">
                    <h4>Lưu ý quan trọng</h4>
                    <ul>
                        <li>Vui lòng mang theo CMND/CCCD khi nhận phòng</li>
                        <li>Thời gian nhận phòng: sau 14:00</li>
                        <li>Thời gian trả phòng: trước 12:00</li>
                        <li>Vui lòng xuất trình email xác nhận này khi check-in</li>
                    </ul>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">Tiện Nghi Phòng</h2>
                <ul class="amenities-list">
                    <li class="amenity-item">WiFi miễn phí</li>
                    <li class="amenity-item">Điều hòa nhiệt độ</li>
                    <li class="amenity-item">TV màn hình phẳng</li>
                    <li class="amenity-item">Mini bar</li>
                    <li class="amenity-item">Phòng tắm riêng</li>
                    <li class="amenity-item">Két sắt cá nhân</li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <div class="hotel-logo"></div>
            
            <p style="color: #334155; font-weight: 500; margin-bottom: 1rem;">
                Cảm ơn quý khách đã lựa chọn khách sạn chúng tôi!
            </p>
            <p style="color: #475569; font-size: 0.875rem; margin-bottom: 1.5rem;">
                Nếu quý khách có bất kỳ yêu cầu đặc biệt nào, vui lòng liên hệ với chúng tôi trước thời gian check-in.
            </p>
            
            <div class="contact-info">
                <div class="contact-item">
                    📞 {{ config('hotel.phone', '1900-xxxx') }}
                </div>
                <div class="contact-item">
                    ✉️ {{ config('hotel.email', 'support@hotel.com') }}
                </div>
                <div class="contact-item">
                    📍 {{ config('hotel.address', '123 Hotel Street') }}
                </div>
            </div>

            <div class="social-links">
                <a href="#" class="social-link">f</a>
                <a href="#" class="social-link">in</a>
                <a href="#" class="social-link">t</a>
            </div>

            <p class="disclaimer">
                Email này được gửi tự động, vui lòng không trả lời email này.
            </p>
        </div>
    </div>
</body>
</html>