@extends('layouts.app')
<!--  -->
@section('header')
    @include('partials.header')
@endsection

<link rel="stylesheet" href="{{ asset('css/account.css') }}">

@section('content')
    <section class="content-account mb-5">
        <div class="account-title">
            <div class="container">
                <p class="m-0 link-title">Trang chủ > Tài khoản</p>
                <span class="title-account">Tài khoản</span>
            </div>
        </div>
        <div class="tabbar-account">
            <nav class="link-tab">
                <div class="nav nav-tabs mb-3 container d-flex" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">Quản lý tài
                        khoản</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                        type="button" role="tab" aria-controls="nav-profile" aria-selected="false" tabindex="-1">Hóa
                        đơn
                        phòng</button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                        type="button" role="tab" aria-controls="nav-contact" aria-selected="false" tabindex="-1">Khách
                        sạn
                        yêu thích</button>
                </div>
            </nav>
            <div class="tab-content container" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                    tabindex="0">
                    <div class="border info-account row">
                        <form id="userForm" method="post" action="{{ route('profile.update') }}"
                            enctype="multipart/form-data" class="row">
                            @csrf
                            @method('PUT')
                            <div class="image-user col-auto" style="position: relative;">
                                <img id="avatarPreview"
                                    src="{{ Auth::check() && Auth::user()->avatar ? asset('storage/images/' . Auth::user()->avatar) : asset('images/user-profile.png') }}"
                                    alt="avatar-user"
                                    style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover; transition: transform 0.3s ease; border:5px solid #ccc">

                                <!-- Upload Avatar Button (Icon styled) -->
                                <input type="file" id="avatarUpload" name="avatar" accept="image/*"
                                    style="display: none;" onchange="previewAvatar(event)" />
                                <label for="avatarUpload" class="btn-upload-avatar"
                                    style="position: absolute; bottom: 40%; left: 80%; transform: translateX(-50%); 
                                  display: flex; justify-content: center; align-items: center; 
                                 width: 30px; height: 30px; border-radius: 50%; 
                                    cursor: pointer; background: #b5b5ba; font-size: 18px;opacity:0;">
                                    +
                                </label>
                            </div>

                            <div class="col-md view-info-user">
                                <!-- EDIT USER - USER -->

                                <div class="form-group text-left">
                                    <div class="label">
                                        <label for="nameUser">Họ tên</label>
                                    </div>
                                    <span class="d-content"
                                        id="displayName">{{ Auth::check() ? Auth::user()->username : 'Guest' }}</span>
                                    <input type="text" class="form-control" id="nameUser" name="username"
                                        placeholder="Nguyễn Văn A" style="display: none;">
                                </div>
                                <div class="form-group text-left">
                                    <div class="label">
                                        <label for="emailUser">Email</label>
                                    </div>
                                    <span class="d-content" id="displayEmail">
                                        {{ Auth::check() ? Auth::user()->email : 'email@example.com' }}</span>
                                    <input type="email" class="form-control" id="emailUser" name="email"
                                        placeholder="email@example.com" style="display: none;">

                                </div>
                                <div class="form-group text-left">
                                    <div class="label">
                                        <label for="phoneUser">Số điện thoại</label>
                                    </div>
                                    <span class="d-content"
                                        id="displayPhone">{{ Auth::check() ? Auth::user()->phone_number : '0123456789' }}</span>
                                    <input type="text" class="form-control" id="phoneUser" name="phone_number"
                                        placeholder="0123456789" style="display: none;">
                                </div>
                                <div class="form-group text-left">
                                    <div class="label">
                                        <label for="Password">Mật khẩu</label>
                                    </div>
                                    <span class="d-content" id="displayPassword">
                                        {{ Auth::check() ? '**********' : '0123456789A@' }}
                                    </span>
                                    <input type="text" class="form-control" id="Password"
                                        placeholder="nhập mật khẩu" style="display: none;">
                                </div>
                                <button type="button" class="btn btn-primary btn-block" id="editInfoBtn"
                                    style="display: block; width: 320px; margin-top: 10px;">Chỉnh sửa thông tin</button>
                                <div class="action-button d-flex gap-3">
                                    <button type="submit" class="btn btn-primary btn-block mt-3" id="saveInfoBtn"
                                    style="display: none;">Lưu Thông Tin</button>
                                <button type="button" class="btn btn-secondary btn-block mt-3" id="cancelInfoBtn"
                                    style="display: none;">Hủy</button>
                                </div>
                               
                        </form>
                        <form action="{{ route('change.password') }}" method="post">
                            @csrf
                            @method('PUT')


                            <div class="form-group text-left">
                                <div class="label">
                                    <label for="newPassword">Mật khẩu mới</label>
                                </div>
                                <span class="d-content" id="displayNewPassword"></span>
                                <input type="password" class="form-control" name="newPassword" id="newPassword"
                                    placeholder="" style="display: none;" value="">
                            </div>
                            <div class="form-group text-left">
                                <div class="label">
                                    <label for="confirmPasswordInput">Nhập lại mật khẩu</label>
                                </div>
                                <span class="d-content" id="displayConfirmPassword"></span>
                                <input type="password" class="form-control" name="newPassword_confirmation"
                                    id="confirmPasswordInput" style="display: none;" value="">
                                <div class="invalid-feedback" id="confirmPasswordError" style="display: none;">
                                    Mật khẩu xác nhận không khớp
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-block mt-3" id="editPasswordBtn">Đổi
                                mật khẩu</button>
                                <div class="action-password d-flex gap-3">
                                    <button type="submit" class="btn btn-primary btn-block mt-3" id="savePasswordBtn"
                                    style="display: none;">Lưu Mật khẩu</button>
                                 <button type="button" class="btn btn-secondary btn-block mt-3" id="cancelNewPass"
                                    style="display: none;">Hủy</button>
                                </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="tab-pane fade bill-room" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                tabindex="0">
                <div class="row">
                    <!-- Invoice Card 1 -->
                    <div class="col-md-6">
                        <div class="invoice-card">
                            <div class="header-bar m-0">
                                <h5>StayNest</h5>
                            </div>
                            <div class="p-3">
                                <h6>Hotel name</h6>
                                <p class="m-0">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Address: 164 Lê Thánh Tôn, Phường Bến Thành, Quận 1, TP. Hồ Chí Minh
                                </p>
                                <p>⭐⭐⭐⭐⭐</p>

                                <!-- Booking Information -->
                                <div class="booking-info">
                                    <h6>Thông tin người đặt</h6>
                                    <div class="content">
                                        <p> <b>Tên:</b> [Name]</p>
                                        <p><b>Email:</b> [Email]</p>
                                        <p><b>Phone:</b> [SDT]</p>
                                    </div>
                                </div>

                                <!-- Date Information -->
                                <div class="availability-container">
                                    <div class="row g-2 align-items-center group-view-date">
                                        <div class="col">
                                            <div class="date-box">
                                                <div class="date-header">Nhận phòng</div>
                                                <div class="date-main">Thứ 4, 2 thg 10 2024</div>
                                                <div class="date-sub">Từ 14:00</div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="date-divider">—</div>
                                        </div>
                                        <div class="col">
                                            <div class="date-box">
                                                <div class="date-header">Trả phòng</div>
                                                <div class="date-main">Thứ 4, 2 thg 10 2024</div>
                                                <div class="date-sub">Trước 12:00</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Room Details -->
                                <div class="room-details m-0">
                                    <div class="content-room-details m-0">
                                        <div class="room-type">
                                            <h6>Loại phòng</h6>
                                            <p> x1 Đơn x2 Đôi</p>
                                        </div>
                                        <div class="quantity-rooms">
                                            <h6>Số lượng phòng</h6>
                                            <p> 3 phòng</p>
                                        </div>
                                        <div class="quantity-nights">
                                            <h6>Số đêm</h6>
                                            <p> 3 Đêm</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="price m-0">
                                        <h4>Giá phòng</h4>
                                        <div class="content-price row">
                                            <div class="col-md-6">
                                                <p>x1 Đơn</p>
                                                <p>x1 Đôi</p>
                                            </div>
                                            <div class="col-md-6 price-details">
                                                <p>1,750,000đ</p>
                                                <p>4,750,000đ</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="price-item">
                                            <div class="item-1">
                                                <span>GIẢM GIÁ KHUYẾN MÃI:</span>
                                                <span class="discount-code ms-2">GIAMGIACHOTOINHA</span>
                                            </div>
                                            <span class="discount-amount">-55.908 VND</span>
                                        </div>
                                        <hr>
                                        <div class="total-price d-flex justify-content-between">
                                            <p>Tổng giá</p>
                                            <p>4,036,805đ</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="cancel-booking m-0">
                                    <a href="#" class="text-danger">Hủy đặt phòng</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Card 2 (Duplicate for layout purposes) -->
                    <div class="col-md-6">
                        <div class="invoice-card">
                            <div class="header-bar m-0">
                                <h5>StayNest</h5>
                            </div>
                            <div class="p-3">
                                <h6>Hotel name</h6>
                                <p class="m-0">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Address: 164 Lê Thánh Tôn, Phường Bến Thành, Quận 1, TP. Hồ Chí Minh
                                </p>
                                <p>⭐⭐⭐⭐⭐</p>

                                <!-- Booking Information -->
                                <div class="booking-info">
                                    <h6>Thông tin người đặt</h6>
                                    <div class="content">
                                        <p> <b>Tên:</b> [Name]</p>
                                        <p><b>Email:</b> [Email]</p>
                                        <p><b>Phone:</b> [SDT]</p>
                                    </div>
                                </div>

                                <!-- Date Information -->
                                <div class="availability-container">
                                    <div class="row g-2 align-items-center group-view-date">
                                        <div class="col">
                                            <div class="date-box">
                                                <div class="date-header">Nhận phòng</div>
                                                <div class="date-main">Thứ 4, 2 thg 10 2024</div>
                                                <div class="date-sub">Từ 14:00</div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="date-divider">—</div>
                                        </div>
                                        <div class="col">
                                            <div class="date-box">
                                                <div class="date-header">Trả phòng</div>
                                                <div class="date-main">Thứ 4, 2 thg 10 2024</div>
                                                <div class="date-sub">Trước 12:00</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Room Details -->
                                <div class="room-details m-0">
                                    <div class="content-room-details m-0">
                                        <div class="room-type">
                                            <h6>Loại phòng</h6>
                                            <p> x1 Đơn x2 Đôi</p>
                                        </div>
                                        <div class="quantity-rooms">
                                            <h6>Số lượng phòng</h6>
                                            <p> 3 phòng</p>
                                        </div>
                                        <div class="quantity-nights">
                                            <h6>Số đêm</h6>
                                            <p> 3 Đêm</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="price m-0">
                                        <h4>Giá phòng</h4>
                                        <div class="content-price row">
                                            <div class="col-md-6">
                                                <p>x1 Đơn</p>
                                                <p>x1 Đôi</p>
                                            </div>
                                            <div class="col-md-6 price-details">
                                                <p>1,750,000đ</p>
                                                <p>4,750,000đ</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="price-item">
                                            <div class="item-1">
                                                <span>GIẢM GIÁ KHUYẾN MÃI:</span>
                                                <span class="discount-code ms-2">GIAMGIACHOTOINHA</span>
                                            </div>
                                            <span class="discount-amount">-55.908 VND</span>
                                        </div>
                                        <hr>
                                        <div class="total-price d-flex justify-content-between">
                                            <p>Tổng giá</p>
                                            <p>4,036,805đ</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="cancel-booking m-0">
                                    <a href="#" class="text-danger">Hủy đặt phòng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PHÂN TRANG -->
                <div class="review-pagination d-flex justify-content-end pe-3">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link">
                                < </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"> > </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade hotel-like" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab"
                tabindex="0">
                <!--  -->
                @foreach ($favorites as $favorite)
                    <div class="card-like-hotel border row mt-4">
                        <div class="col-md-5 detail-infor-room-left">
                            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                                navigation="true" space-between="30" loop="true">
                                @foreach ($favorite->hotel->images as $image)
                                    <swiper-slide>
                                        <img src="{{ asset('storage/images/' . $image->image_url) }}" alt="Hotel Image" />
                                    </swiper-slide>
                                @endforeach
                            </swiper-container>
                        </div>
                        <div class="col-md-7 detail-infor-right">
                            <div class="detail-room-sale">
                                @if ($favorite->hotel->rooms->isNotEmpty())
                                    {{ $favorite->hotel->rooms->first()->discount_percent }}%
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card-room-location m-0">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>{{ $favorite->hotel->location }}, {{ $favorite->hotel->city->city_name }}
                                        </span>
                                    </div>
                                    <div class="card-room-hotel-name m-0">
                                        <i class="fa-solid fa-hotel"></i>
                                        <a href="#" class="hotel-link">{{ $favorite->hotel->hotel_name }}</a>
                                    </div>
                                    <div class="group-room-price mt-2">
                                        <p>
                                            {{ strlen($favorite->hotel->description) > 100 ? substr($favorite->hotel->description, 0, 100) . '...' : $favorite->hotel->description }}
                                        </p>
                                        {{-- <ul class="p-0">
                                        <li>
                                            <span class="card-room-price-old">1.057.666 đ</span>
                                        </li>
                                        <li>
                                            <span class="card-room-price-new">933.157 đ</span>
                                        </li>
                                    </ul> --}}
                                    </div>
                                    <div class="card-room-rating m-0">
                                        @for ($i = 0; $i < 5; $i++)
                                            <span>{{ $i < $favorite->hotel->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-room-status">
                                        <div class="don">ĐƠN</div>
                                        <div class="doi">ĐÔI</div>
                                    </div>
                                    <div class="card-room-btn-book">
                                        <a href="{{ route('pages.hotel_detail', ['hotel_id' => $favorite->hotel->hotel_id]) }}"
                                            class="btn-book-now">đặt ngay</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!--  -->
                <!-- PHÂN TRANG -->
                <div class="review-pagination mt-5 d-flex justify-content-end">
                    <ul class="pagination">
                        {!! $favorites->appends(['tab' => 'nav-contact'])->links('pagination::bootstrap-4') !!}
                    </ul>
                </div>

            </div>
            <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab"
                tabindex="0">
                <p>This is some placeholder content the <strong>Disabled tab's</strong> associated content.</p>
            </div>
        </div>
    </section>
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11;">
        @if (session('success'))
            <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
                aria-atomic="true" id="successToast">
                <div class="d-flex">
                    <div class="toast-body">
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
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                @foreach ($errors->all() as $error)
                    <div class="toast align-items-center text-bg-danger border-0 mb-2" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ $error }}
                            </div>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastElements = document.querySelectorAll('.toast');
            toastElements.forEach(function(toastElement) {
                var toastInstance = new bootstrap.Toast(toastElement);
                toastInstance.show();
            });
        });
        // Chuyển Tab khi click từ home 
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab');

            if (activeTab) {
                // Find the tab button and content by ID
                const tabButton = document.getElementById(`${activeTab}-tab`);
                const tabContent = document.getElementById(activeTab);

                if (tabButton && tabContent) {
                    // Remove the 'active' class from the currently active tab
                    document.querySelectorAll('.nav-link').forEach(tab => tab.classList.remove('active'));
                    document.querySelectorAll('.tab-pane').forEach(content => content.classList.remove('show',
                        'active'));

                    // Add the 'active' class to the target tab
                    tabButton.classList.add('active');
                    tabContent.classList.add('show', 'active');
                }
            }
        });

        const infoFields = [{
                display: 'displayName',
                input: 'nameUser'
            },
            {
                display: 'displayEmail',
                input: 'emailUser'
            },
            {
                display: 'displayPhone',
                input: 'phoneUser'
            }
        ];

        const passwordFields = [{
                display: 'displayConfirmPassword',
                input: 'confirmPasswordInput'
            },
            {
                display: 'displayNewPassword',
                input: 'newPassword'
            }
        ];
        
      

        const editInfoBtn = document.getElementById('editInfoBtn');
        const saveInfoBtn = document.getElementById('saveInfoBtn');
        const editPasswordBtn = document.getElementById('editPasswordBtn');
        const savePasswordBtn = document.getElementById('savePasswordBtn');



        const cancelNewPass = document.getElementById('cancelNewPass');
        cancelNewPass.onclick = function() {
            // Revert fields to their original state
            passwordFields.forEach(field => {
                document.getElementById(field.display).style.display = 'block';
                const input = document.getElementById(field.input);
                input.style.display = 'none';
            });

            editPasswordBtn.style.display = 'block';
            savePasswordBtn.style.display = 'none';
            cancelNewPass.style.display = 'none'; // Hide cancel button
            document.querySelector('label[for="confirmPasswordInput"]').style.display = 'none';
            document.querySelector('label[for="newPassword"]').style.display = 'none';
            // Mark the info editing flag as false
            isEditingPassword = false;
        };
        const cancelInfoBtn = document.getElementById('cancelInfoBtn');
        cancelInfoBtn.onclick = function() {
            // Revert fields to their original state
            infoFields.forEach(field => {
                document.getElementById(field.display).style.display = 'block';
                const input = document.getElementById(field.input);
                input.style.display = 'none';
                document.querySelector('.btn-upload-avatar').style.bottom = '42%';
            });

            editInfoBtn.style.display = 'block';
            saveInfoBtn.style.display = 'none';
            cancelInfoBtn.style.display = 'none'; // Hide cancel button

            // Mark the info editing flag as false
            isEditingInfo = false;
        };
        // Track editing state
        let isEditingInfo = false;
        let isEditingPassword = false;

        // Initially hide the confirm password field and its label
        document.getElementById('displayConfirmPassword').style.display = 'none';
        document.getElementById('confirmPasswordInput').style.display = 'none';
        document.querySelector('label[for="confirmPasswordInput"]').style.display = 'none';

        document.getElementById('displayNewPassword').style.display = 'none';
        document.getElementById('newPassword').style.display = 'none';
        document.querySelector('label[for="newPassword"]').style.display = 'none';
        // Handle editing user information
        editInfoBtn.onclick = function() {
            // Prevent editing password if user is editing info
            if (isEditingPassword) {
                alert('Bạn không thể chỉnh sửa thông tin và đổi mật khẩu cùng lúc!');
                return;
            }

            // Mark the info editing flag as true
            isEditingInfo = true;

            // Hide password fields and show info fields
            infoFields.forEach(field => {
                document.getElementById(field.display).style.display = 'none';
                const input = document.getElementById(field.input);
                input.style.display = 'block';
                input.value = document.getElementById(field.display).textContent;
                document.querySelector('.btn-upload-avatar').style.bottom = '50%';
                document.querySelector('.btn-upload-avatar').style.opacity = '1';
            });

            editInfoBtn.style.display = 'none';
            saveInfoBtn.style.display = 'block';
            cancelInfoBtn.style.display = 'block';
        };

        // Save edited user information
        saveInfoBtn.onclick = function() {
            infoFields.forEach(field => {
                const input = document.getElementById(field.input);
                document.getElementById(field.display).textContent = input.value;
                document.getElementById(field.display).style.display = 'block';
                document.querySelector('.btn-upload-avatar').style.bottom = '40%';
                input.style.display = 'none';
            });

            editInfoBtn.style.display = 'block';
            saveInfoBtn.style.display = 'none';
            cancelNewPass.style.display= 'none';
            // Mark the info editing flag as false
            isEditingInfo = false;
        };

        // Handle changing the password
        editPasswordBtn.onclick = function() {
            // Prevent editing info if user is editing password
            if (isEditingInfo) {
                alert('Bạn không thể chỉnh sửa thông tin và đổi mật khẩu cùng lúc!');
                return;
            }

            // Mark the password editing flag as true
            isEditingPassword = true;
            document.getElementById('Password').readOnly = true;
            // Show both password and confirm password fields when editing password
            passwordFields.forEach(field => {
                document.getElementById(field.display).style.display = 'none';
                const input = document.getElementById(field.input);
                input.style.display = 'block';
                input.value = document.getElementById(field.display).textContent;
                document.querySelector('.btn-upload-avatar').style.opacity = '0';
            });

            // Show the confirm password field and its label
            document.getElementById('confirmPasswordInput').style.display = 'block';
            document.querySelector('label[for="confirmPasswordInput"]').style.display = 'block';


            document.getElementById('newPassword').style.display = 'block';
            document.querySelector('label[for="newPassword"]').style.display = 'block';
            editPasswordBtn.style.display = 'none';
            savePasswordBtn.style.display = 'block';
            cancelNewPass.style.display = 'block';
        };

        // Save new password
        savePasswordBtn.onclick = function() {
            passwordFields.forEach(field => {
                const input = document.getElementById(field.input);
                document.getElementById(field.display).textContent = input.value;
                document.getElementById(field.display).style.display = 'block';
                document.querySelector('.btn-upload-avatar').style.opacity = '1';
                input.style.display = 'none';
            });

            // Hide the confirm password field and its label again
            document.getElementById('displayConfirmPassword').style.display = 'none';
            document.getElementById('confirmPasswordInput').style.display = 'none';
            document.querySelector('label[for="confirmPasswordInput"]').style.display = 'none';

            document.getElementById('displayNewPassword').style.display = 'none';
            document.getElementById('newPassword').style.display = 'none';
            document.querySelector('label[for="newPassword"]').style.display = 'none';
            editPasswordBtn.style.display = 'block';
            savePasswordBtn.style.display = 'none';
            cancelNewPass.style.display= 'none';
            // Mark the password editing flag as false
            isEditingPassword = false;
        };

        function previewAvatar(event) {
            const file = event.target.files[0]; // Get the selected file
            const reader = new FileReader();

            reader.onload = function(e) {
                const avatarPreview = document.getElementById('avatarPreview');
                avatarPreview.src = e.target.result; // Set the preview image
            }

            if (file) {
                reader.readAsDataURL(file); // Read the file as data URL
            }
        }
    </script>
@endsection
@section('footer')
    @include('partials.footer')
@endsection

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
