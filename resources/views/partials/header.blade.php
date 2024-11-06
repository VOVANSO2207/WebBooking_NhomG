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
                        <li><a href="#">GIỚI THIỆU</a></li>
                        <li><a href="#">PHÒNG KHÁCH SẠN</a></li>
                        <li><a href="{{route('blog')}}">TIN TỨC</a></li>
                        <li><a href="{{route(name: 'contact')}}">LIÊN HỆ</a></li>
                    </ul>
                </div>
                <div class="profile-header col-md-2">
                    <!-- Nếu chưa đăng nhập -->
                    <div class="group-left-header">
                        <a href="/login" class="login">Đăng nhập/</a>
                        <a href="/register" class="register">Đăng ký</a>
                    </div>
                    <!-- Nếu đã đăng nhập -->
                    <!-- <div class="loged">
                        <div class="group-left-header d-flex align-items-center justify-content-center">
                            <div class="col-md-2 text-center">
                                <i class="fa-solid fa-bell fa-xl"></i>
                            </div>
                            <div class="col-md-8 text-center ms-3 me-2">
                                <p class="name-user m-0 p-0" id="userIcon">
                                    <span style="display: inline-block; transform: rotate(90deg);">&gt;</span>
                                    <abbr title="Nguyen Hoang Son" style="text-decoration: none;">Nguyen Hoang
                                        Son</abbr>
                                </p>
                            </div>
                            <div class="col-md-2 text-center">
                                <i class="fa-solid fa-user fa-xl"></i>
                            </div>
                        </div>
                        <div class="dropdown-menu" id="userDropdown" style="display: none;">
                            <a class="dropdown-item dropdown-item-staynest" href="#">Tài Khoản</a>
                            <a class="dropdown-item dropdown-item-staynest" href="#">Yêu Thích</a>
                            <a class="dropdown-item dropdown-item-staynest" href="#">Hóa Đơn</a>
                            <a class="dropdown-item dropdown-item-staynest" href="#">Voucher</a>
                            <a class="dropdown-item dropdown-item-staynest text-danger" href="#">Đăng Xuất</a>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection