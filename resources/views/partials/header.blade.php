@extends('layouts.app')


@section('header')
<link rel="stylesheet" href="{{ asset('css/header.css') }}">
<section class="header-staynest m-0">
    <a href="{{asset('/')}}" class="d-flex align-items-center justify-content-center logo-staynest">
        <img src="{{ asset('/images/logo_staynest_white_color.png') }}" alt="Logo" width="50px">
        <h2 class="ms-2 mb-0 text-light">StayNest</h2>
    </a>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <!-- Toggler Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible Content -->
            <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
                <!-- Social Links -->
                <ul class="navbar-nav mb-2 mt-2 mb-lg-0 social-header">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-brands fa-facebook fa-lg"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-brands fa-x-twitter fa-lg"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-brands fa-youtube fa-lg"></i></a>
                    </li>
                </ul>

                <!-- Navigation Links -->
                <ul class="navbar-nav mb-2 mb-lg-0 menu-attribute">
                    <li class="nav-item"><a class="nav-link" href="{{asset('/')}}">TRANG CHỦ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{asset('introduce')}}">GIỚI THIỆU</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('hotels.index')}}">PHÒNG KHÁCH SẠN</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('blog')}}">TIN TỨC</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">LIÊN HỆ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">Ý TƯỞNG</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">SÁNG TẠO</a></li>
                </ul>

                <!-- Profile Section -->
                <div class="profile-header col-md-2">
                    @if (auth()->check())
                        <div class="loged">
                            <div class="group-left-header d-flex align-items-center justify-content-center">
                                <div class="col-md-2 text-center">
                                    <button class="button-notifi" id="notificationBell-header">
                                        <i class="fa-solid fa-bell fa-xl"></i>
                                    </button>

                                    <!-- Notification Dropdown -->
                                    <div class="notification-dropdown mt-4" id="notificationDropdown-header"
                                        style="display: none;">
                                        <h5 class="dropdown-header p-3">Thông báo</h5>
                                        @foreach(session('notifications', []) as $key => $notification)
                                            <div class="notification-item d-flex justify-content-between align-items-center">
                                                <span>{{ $notification['content'] }}</span>
                                                <button class="btn-danger btn-delete-notification"
                                                    data-key="{{ $key }}">&#10005;</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-md-8 text-center ms-3 me-2">
                                    <p class="name-user m-0 p-0" id="userIcon">
                                        <span style="display: inline-block; transform: rotate(90deg);">&gt;</span>
                                        <abbr title="{{ Auth::check() ? Auth::user()->username : 'Guest' }}"
                                            style="text-decoration: none;">
                                            {{ Auth::check() ? Auth::user()->username : 'Guest' }}
                                        </abbr>
                                    </p>
                                </div>

                                <div class="col-md-2 text-center" style="width: 100%; height:100%;">
                                    <a href="{{ route('pages.account') }}">
                                        <img class="image-user"
                                            src="{{ Auth::check() && Auth::user()->avatar ? asset('storage/images/' . Auth::user()->avatar) : asset('images/user-profile.png') }}"
                                            alt="Avatar" class="img-fluid rounded-circle"
                                            style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                    </a>
                                </div>
                            </div>
                            <div class="dropdown-menu" id="userDropdown" style="display: none;">
                                <a class="dropdown-item dropdown-item-staynest" href="{{ route('pages.account') }}">
                                    Tài Khoản
                                </a>
                                <a class="dropdown-item dropdown-item-staynest"
                                    href="{{ route('pages.account') }}?tab=nav-contact">
                                    Yêu Thích
                                </a>
                                <a class="dropdown-item dropdown-item-staynest"
                                    href="{{ route('pages.account') }}?tab=nav-profile">
                                    Hóa Đơn
                                </a>
                                <a class="dropdown-item dropdown-item-staynest" href="{{route('viewVoucherUser')}}">
                                    Voucher
                                </a>
                                <a href="#" class="dropdown-item dropdown-item-staynest text-danger"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Đăng Xuất
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Nếu chưa đăng nhập -->
                        <div class="group-left-header">
                            <a href="{{ route('login') }}" class="login">Đăng nhập/</a>
                            <a href="{{ url('register') }}" class="register ms-2">Đăng ký</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bell = document.getElementById('notificationBell-header');
        const dropdown = document.getElementById('notificationDropdown-header');

        if (bell && dropdown) {
            bell.addEventListener('click', function () {
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                    dropdown.style.display = 'none';
                } else {
                    dropdown.style.display = 'block';
                    dropdown.classList.add('show');
                }
            });

            document.addEventListener('click', function (event) {
                if (!bell.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.remove('show');
                    dropdown.style.display = 'none';
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-delete-notification')) {
                const key = e.target.getAttribute('data-key'); // Lấy key của thông báo

                // Gửi yêu cầu xóa thông báo
                fetch(`/notifications/${key}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            // Xóa thông báo khỏi giao diện
                            e.target.closest('.notification-item').remove();
                        }
                    })
                    .catch((error) => console.error('Error deleting notification:', error));
            }
        });

    });

</script>
@endsection