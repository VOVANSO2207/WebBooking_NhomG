@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!--  -->
@section('header')
    @include('partials.header')
@endsection
@section('search')
    @include('partials.search_layout')
@endsection
<!--  -->
<link rel="stylesheet" href="{{ asset('css/payment.css') }}">

@section('content')
    <section class="payment mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="title-pay">
                    <h4 class="m-0">Đặt phòng của bạn</h4>
                    <span class="hotel-warning">Hãy đảm bảo tất cả thông tin chi tiết trên trang này đã chính xác trước
                        khi tiến hành
                        thanh toán.</span>
                </div>
                <div class="col-md-8">
                    <form action="{{ route('payment.vnpay') }}" method="POST">
                        @csrf
                        <!-- THÔNG TIN KHÁCH SẠN -->
                        <div class="hotel-card border p-4">
                            <div class="row hotel-row">
                                <div class="col-md-3 hotel-image">
                                    {{-- Lấy hình ảnh đầu tiên của khách sạn --}}
                                    <img src="{{ asset('images/' . $hotel->images->first()->image_url) }}"
                                        alt="Hình ảnh khách sạn">
                                </div>
                                <div class="col-md-9 hotel-details">
                                    <h2 class="hotel-name m-0">{{ $hotel->hotel_name }}</h2>
                                    <div class="hotel-rating">
                                        @php
                                            $fullStars = floor($hotel->rating); // Lấy phần nguyên
                                            $hasHalfStar = $hotel->rating - $fullStars >= 0.5; // Kiểm tra có nửa sao không
                                            $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0); // Số sao trống còn lại
                                        @endphp

                                        {{-- Hiển thị sao đầy --}}
                                        @for ($i = 1; $i <= $fullStars; $i++)
                                            <span style="color: gold;">★</span>
                                        @endfor

                                        {{-- Hiển thị nửa sao nếu có --}}
                                        @if ($hasHalfStar)
                                            <span style="position: relative; display: inline-block;">
                                                <span style="color: lightgray;">★</span>
                                                <span
                                                    style="position: absolute; left: 0; overflow: hidden; width: 50%; color: gold;">★</span>
                                            </span>
                                        @endif

                                        {{-- Hiển thị sao trống còn lại --}}
                                        @for ($i = 1; $i <= $emptyStars; $i++)
                                            <span style="color: lightgray;">★</span>
                                        @endfor
                                    </div>
                                    <span class="hotel-addresscation">
                                        <i class="fa-solid fa-location-dot fa-xxl me-2"></i>
                                        {{ $hotel->location }} ,
                                        {{ $hotel->city->city_name }}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="check-details row">
                                <div class="check-in col-md-4">
                                    <p class="label m-0">Nhận phòng</p>
                                    <p class="info">14:00, {{ $checkInFormatted }}</p>
                                </div>
                                <div class="check-out col-md-4">
                                    <p class="label m-0">Trả phòng</p>
                                    <p class="info">12:00, {{ $checkOutFormatted }}</p>
                                </div>
                                <div class="night-count col-md-2">
                                    <p class="label m-0">Số đêm</p>
                                    <p class="info">{{ $nightText }}</p>
                                </div>
                                <div class="room-info col-md-2">
                                    <p class="label m-0">Số phòng</p>
                                    <p class="info">x1 {{ $room->name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- THÔNG TIN NGƯỜI ĐẶT -->
                        <div class="contact-form p-4 mt-5">
                            <h3 class="mb-4">Thông tin liên hệ</h3>

                            <div class="mb-3">
                                <label for="full-name" class="form-label m-0">Họ và tên</label>
                                <input type="text" name="full_name" id="full-name" class="form-control"
                                value="{{ Auth::check() ? Auth::user()->username : 'Guest' }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label m-0">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                    value="{{ Auth::check() ? Auth::user()->email : 'email@example.com' }}">                                
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label m-0">Số điện thoại</label>
                                    <input type="tel" name="phone" id="phone" class="form-control"
                                    value="{{ Auth::check() ? Auth::user()->phone_number : '0123456789' }}">
                                </div>
                            </div>
                        </div>

                        <!-- YÊU CẦU KHÁC -->
                        <div class="request-container">
                            <div class="request-title">Bạn có yêu cầu nào không?</div>
                            <div class="request-description">
                                Khi nhận phòng, khách sạn sẽ thông báo liệu yêu cầu này có được đáp ứng hay không. Một số
                                yêu
                                cầu cần trả thêm phí để sử dụng nhưng bạn hoàn toàn có thể hủy yêu cầu sau đó.
                            </div>

                            <div class="row g-3">
                                <!-- CHECK BOX -->
                                <div class="col-6 col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="nonSmokingRoom">
                                        <label class="form-check-label checkbox-label" for="nonSmokingRoom">Phòng không hút
                                            thuốc</label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="singleBed">
                                        <label class="form-check-label checkbox-label" for="singleBed">Giường đơn</label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="highFloor">
                                        <label class="form-check-label checkbox-label" for="highFloor">Tầng lầu</label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="doubleBed">
                                        <label class="form-check-label checkbox-label" for="doubleBed">Giường đôi</label>
                                    </div>
                                </div>
                                <!-- KHÁC -->
                                <div class="col-12">
                                    <label for="otherRequests" class="form-label m-0">Khác</label>
                                    <textarea id="otherRequests" class="other-input" maxlength="100" placeholder="Nhập yêu cầu khác tại đây..."></textarea>
                                    <div class="char-limit">0/100</div>
                                </div>
                            </div>
                        </div>

                        <div class="voucher-container">
                            <div class="group-voucherCode d-flex align-items-center voucher-1">
                                <div class="voucher-icon me-2"><i class="fa-solid fa-ticket"></i></div>
                                <div class="title me-2">Nhập mã giảm giá</div>
                                <input id="voucherCode" class="voucher-input" placeholder="Mời bạn nhập mã giảm giá"
                                    type="text">
                                <button type="button" class="ms-2">SỬ DỤNG</button>
                            </div>
                        </div>
                        {{-- Chọn phương thức thanh toán --}}
                        <div class="payment-methods">
                            <div class="payment-title">Phương thức thanh toán</div>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="vnpay">
                                <div class="payment-icon">
                                    <i class="fa-solid fa-credit-card"></i>
                                </div>
                                <div class="payment-label">Thanh toán qua VNPAY</div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="momo">
                                <div class="payment-icon">
                                    <i class="fa-solid fa-wallet"></i>
                                </div>
                                <div class="payment-label">Ví MoMo</div>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cod">
                                <div class="payment-icon">
                                    <i class="fa-solid fa-money-bill"></i>
                                </div>
                                <div class="payment-label">Thanh toán khi nhận phòng (COD)</div>
                            </label>
                        </div>
                        <div class="detail-price">
                            <div class="title">Chi tiết giá</div>
                            <div class="group-info-price">
                                <div class="row price-room">
                                    <div class="col-md-6 left">
                                        <p class="m-0">Thuế và phí dịch vụ khách sạn</p>
                                        <p class="m-0">Giá phòng</p>
                                        <p>(x1) {{ $room->name }} - ({{ $nightText }})</p>
                                    </div>
                                    <div class="col-md-6 right">
                                        <div class="sale">8%</div>
                                        <div class="price-old">{{ number_format($originalPrice, 0, ',', '.') }} VND</div>
                                        <div class="price-new">{{ number_format($discountedPrice, 0, ',', '.') }} VND
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="price-item">
                                    <div class="item-1">
                                        <span>Mã giảm giá</span>
                                        <span class="discount-code ms-2"></span>
                                    </div>
                                    <span class="discount-amount"></span>
                                </div>
                                <hr>
                                {{-- {{dd($room)}} --}}
                                <div class="total-detail-price">
                                    <span class="title-total-price">Tổng tiền thanh toán</span>
                                    <span class="total-price">{{ number_format($totalAmount, 0, ',', '.') }} VND</span>
                                </div>
                                <span class="tax-included">Đã bao gồm thuế, phí, VAT</span>
                                <input type="hidden" name="total_amount" id="total_amount"
                                    value="{{ $totalAmount }}">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="room_id" value="{{ $room->room_id }}">
                                <input type="hidden" name="check_in" value="{{ $checkInFormatted }}">
                                <input type="hidden" name="check_out" value="{{ $checkOutFormatted }}">
                                <input type="hidden" name="total_price" value="{{ $totalAmount }}">
                                <input type="hidden" name="promotion_id" id="promotion_id" value="">
                                {{-- <input type="hidden" name="promotion_id" value="{{ $promotion_id }}">f --}}
                                <div class="button-pay">
                                    <button type="submit" id="btnPay" class="btn-pay">Thanh toán</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 ">
                    <div class="room-info-card border">
                        <h3 class="room-info-title">Thông tin phòng</h3>
                        <div class="room-image">
                            <div class="slider">
                                <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
                                <div class="slides">
                                    @foreach ($room->room_images as $index => $image)
                                        <div class="slide {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/images/' . $image->image_url) }}"
                                                alt="Image {{ $index + 1 }}">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="next" onclick="changeSlide(1)">&#10095;</button>
                            </div>

                        </div>
                        <div class="availability-container">
                            <div class="row g-2 align-items-center group-view-date">
                                <div class="col">
                                    <div class="date-box">
                                        <div class="date-header">Nhận phòng</div>
                                        <div class="date-main">{{ $checkInFormatted }}</div>
                                        <div class="date-sub">Từ 14:00</div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="date-divider">—</div>
                                </div>
                                <div class="col">
                                    <div class="date-box">
                                        <div class="date-header">Trả phòng</div>
                                        <div class="date-main">{{ $checkOutFormatted }}</div>
                                        <div class="date-sub">Trước 12:00</div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <hr class="m-0">
                        <div class="room-info-extra d-flex gap-4"
                            style="padding: 15px 20px; margin:0;justify-content: space-between">
                            <div class="room-capacity">
                                <i class="fas fa-user-friends"></i>
                                <strong>Sức chứa:</strong> {{ $room->capacity }} người
                            </div>
                            <div class="room-type">
                                <i class="fas fa-bed"></i>
                                <strong>Loại phòng:</strong> {{ $room->roomType->name }}
                                <!-- Giả sử quan hệ với bảng room_types -->
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="rooom-info-amenity">
                            <div class="row">
                                @foreach ($room->amenities as $amenity)
                                    <div class="col-6 col-md-4 amenity-item">
                                        <i class="fas fa-check-circle amenity-icon"></i> {{ $amenity->amenity_name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="room-info-description">
                            <h5 class="section-title">Giới thiệu</h5>
                            <p class="room-description">{!! $room->description !!}
                                tầm nhìn ra đại dương đẹp nhất tại thành phố Vũng Tàu. Khách sạn cung cấp 250 phòng độc đáo
                                với khái niệm giường ngủ ibis mới và WIFI <span><a href="#"
                                        class="detail-btn-load-more">Xem
                                        thêm</a></span>
                                miễn phí, phục vụ cả khách du lịch giải trí và công tác.ibis Styles Vung Tau là khách sạn
                                quốc tế tiết kiệm với thiết kế

                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 11;">
                @if (session('success'))
                    <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
                        aria-atomic="true" id="successToast">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
                        aria-atomic="true" id="errorToast">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                            </div>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            </div>
    </section>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toastElements = document.querySelectorAll('.toast');
        toastElements.forEach(function(toastElement) {
            var toastInstance = new bootstrap.Toast(toastElement);
            toastInstance.show();
        });
    });
    // Frontend JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        const voucherButton = document.querySelector('.group-voucherCode button');
        const voucherInput = document.querySelector('#voucherCode');
        const totalPriceElement = document.querySelector('.total-price');
        const discountCodeElement = document.querySelector('.discount-code');
        const discountAmountElement = document.querySelector('.discount-amount');
        const priceItemElement = document.querySelector('.price-item');
        let usedVoucherCodes = [];
        let hasUsedVoucher = false;
        voucherButton.addEventListener('click', async function() {
            const promotionCode = voucherInput.value.trim();
            if (usedVoucherCodes.includes(promotionCode)) {
                showErrorMessage('Mã giảm giá này đã được sử dụng!');
                return;
            }
            if (hasUsedVoucher) {
                showErrorMessage('Bạn chỉ được sử dụng một mã giảm giá!');
                return;
            }
            if (!promotionCode) {
                alert('Vui lòng nhập mã giảm giá!');
                return;
            }

            try {
                const response = await fetch('/api/apply-promotion', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        promotion_code: promotionCode,
                        original_amount: getOriginalAmount()
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Lưu mã voucher đã sử dụng
                    usedVoucherCodes.push(promotionCode);
                    hasUsedVoucher = true;
                    // Vô hiệu hóa nút và input
                    // voucherButton.disabled = true;
                    // voucherInput.disabled = true;
                    updatePriceDisplay(data);
                    showSuccessMessage(
                        `Áp dụng mã giảm giá thành công! Giảm ${data.discount_percentage}%`);
                } else {
                    showErrorMessage(data.message || 'Mã giảm giá không hợp lệ!');
                }
            } catch (error) {
                showErrorMessage('Đã có lỗi xảy ra. Vui lòng thử lại sau!');
                console.error(error);
            }
        });

        function updatePriceDisplay(data) {
            // Update discount code display
            discountCodeElement.textContent = data.promotion_code;

            // Update discount amount
            const formattedDiscount = new Intl.NumberFormat('vi-VN').format(data.calculated_discount);
            discountAmountElement.textContent = `-${formattedDiscount} VND`;

            // Update total price
            const formattedTotal = new Intl.NumberFormat('vi-VN').format(data.new_total);
            totalPriceElement.textContent = `${formattedTotal} VND`;

            // Show discount row
            priceItemElement.style.display = 'flex';

            // Add hidden inputs for form submission
            const form = document.querySelector('form');

            // Add promotion code to form
            let promotionInput = form.querySelector('input[name="promotion_code"]');
            if (!promotionInput) {
                promotionInput = document.createElement('input');
                promotionInput.type = 'hidden';
                promotionInput.name = 'promotion_code';
                form.appendChild(promotionInput);
            }
            promotionInput.value = data.promotion_code;
            const promotionIdInput = document.querySelector('#promotion_id');
            if (promotionIdInput) {
                promotionIdInput.value = data.promotion_id;
            }

            // Add discount amount to form
            let discountInput = form.querySelector('input[name="discount_amount"]');
            if (!discountInput) {
                discountInput = document.createElement('input');
                discountInput.type = 'hidden';
                discountInput.name = 'discount_amount';
                form.appendChild(discountInput);
            }
            discountInput.value = data.calculated_discount;
            // Cập nhật giá trị input hidden total_amount
            const totalAmountInput = document.querySelector('#total_amount');
            if (totalAmountInput) {
                totalAmountInput.value = data.new_total;
            }
        }

        function getOriginalAmount() {
            const priceText = document.querySelector('.total-price').textContent;
            return parseInt(priceText.replace(/[^\d]/g, ''));
        }

        function showSuccessMessage(message) {
            alert(message);
        }

        function showErrorMessage(message) {
            alert(message);
        }
    });

    function slideShowImage() {
        let currentSlide = 0;

        function showSlide(index) {
            const slides = document.querySelectorAll('.slide');
            if (index >= slides.length) {
                currentSlide = 0;
            } else if (index < 0) {
                currentSlide = slides.length - 1;
            } else {
                currentSlide = index;
            }

            const slideWidth = slides[currentSlide].clientWidth;
            const slidesContainer = document.querySelector('.slides');
            slidesContainer.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
        }

        window.changeSlide = function(direction) {
            showSlide(currentSlide + direction);
        };

        showSlide(currentSlide);
    }

    function setupCharacterCounter() {
        const textarea = document.getElementById('otherRequests');
        const charLimit = document.querySelector('.char-limit');
        textarea.addEventListener('input', () => {
            charLimit.textContent = `${textarea.value.length}/100`;
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        setupCharacterCounter();
        slideShowImage();
    });
</script>
@section('footer')
    @include('partials.footer')
@endsection
