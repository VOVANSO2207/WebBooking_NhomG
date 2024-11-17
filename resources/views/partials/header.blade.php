@extends('layouts.app')


@section('header')
<link rel="stylesheet" href="{{ asset('css/header.css') }}">
<section class="header-staynest m-0">
    <div class="top-header">
        <a href="{{asset('/')}}" class="logo-staynest p-3">
            <img src="{{ asset('/images/logo_staynest_white_color.png') }}" alt="" width="50px">
            <h1 class="name-logo ms-2">StayNest</h1>
        </a>
        <div class="menu-header d-flex justify-content-center text-light m-3">
            <div class="container row align-items-center">
                <div class="social-header col-md-2 text-center">
                    <a href="#" class="link-social"><i class="fa-brands fa-facebook fa-2xl"></i></a>
                    <a href="#" class="link-social"><i class="fa-brands fa-x-twitter fa-2xl"></i></a>
                    <a href="#" class="link-social"><i class="fa-brands fa-youtube fa-2xl"></i></a>
                </div>
                <div class="menu-header col-md-8">
                    <ul class="menu-attribute d-flex justify-content-around m-0">
                        <li><a href="{{asset('/')}}">TRANG CHỦ</a></li>
                        <li><a href="{{asset('introduce')}}">GIỚI THIỆU</a></li>
                        <li><a href="#">PHÒNG KHÁCH SẠN</a></li>
                        <li><a href="{{route('blog')}}">TIN TỨC</a></li>
                        <li><a href="{{route(name: 'contact')}}">LIÊN HỆ</a></li>
                    </ul>
                </div>
                <div class="profile-header col-md-2">
                    <!-- Nếu chưa đăng nhập -->
                    <div class="group-left-header">
                        <a href="{{ route('login') }}" class="login">Đăng nhập/</a>
                        <a href="{{ url('register') }}" class="register ms-2">Đăng ký</a>
                    </div>
                    @if (auth()->check())
                        <div class="loged">
                            <div class="group-left-header d-flex align-items-center justify-content-center">
                                <div class="col-md-2 text-center">
                                    <i class="fa-solid fa-bell fa-xl" id="notificationBell" style="cursor: pointer;"></i>
                                    <!-- Notification Dropdown -->
                                    <div class="notification-dropdown" id="notificationDropdown" style="display: none;">
                                        <h5 class="dropdown-header">Notifications</h5>
                                        <div class="notification-item">You have a new message</div>
                                        <div class="notification-item">Booking confirmed</div>
                                        <div class="notification-item">Special offer just for you!</div>
                                        <div class="notification-item">Your review has been approved</div>
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

                                <div class="col-md-2 text-center" style="width: 100%;height:100%;">
                                    <img src="{{ Auth::check() && Auth::user()->avatar ? asset('images/' . Auth::user()->avatar) : asset('images/user-profile.png') }}"
                                        alt="Avatar" class="img-fluid rounded-circle"
                                        style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">

                                </div>
                            </div>
                            <div class="dropdown-menu" id="userDropdown" style="display: none;">
                                <a class="dropdown-item dropdown-item-staynest" href="{{ route('pages.account') }}">Tài
                                    Khoản</a>
                                <a class="dropdown-item dropdown-item-staynest"
                                    href="{{ route('pages.account') }}?tab=nav-contact">Yêu Thích</a>
                                <a class="dropdown-item dropdown-item-staynest"
                                    href="{{ route('pages.account') }}?tab=nav-profile">Hóa Đơn</a>
                                <a class="dropdown-item dropdown-item-staynest" href="#">Voucher</a>
                                <a href="#" class="dropdown-item dropdown-item-staynest text-danger"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Đăng Xuất
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection