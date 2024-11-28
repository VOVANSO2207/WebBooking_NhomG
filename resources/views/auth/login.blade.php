@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('css/login.css')}}">
<!-- <div class="card-header text-center py-3 header">
    <h2 class="mb-0"> <a class="nav-link" href="{{asset('/')}}"> STAYNEST</a> </h2>
</div> -->

<!-- <main class="container login-container">
    <div class="login-card row">
        <div class="col-md-6 col-lg-5">
            <div class="card">

            </div>
        </div>
</main> data-bs-theme="dark"-->
<section class="stay-nest-login-form">
    <div class="stay-nest-container container">
        <div class="stay-nest-box-login">
            <div class="row">
                <div class="stay-nest-group-login-banner col-md-7">
                    <img class="stay-nest-banner-image" src="{{ asset('storage/images/banner_01.png') }}" alt="">
                    <div class="overlay-banner"></div>
                    <div class="stay-nest-btn-back-home">
                        <a href="{{asset('/')}}"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
                    </div>
                    <div class="stay-nest-text-banner">
                        <h1>Xin chào,</h1>
                        <p class="text-banner" id="typewriter">
                            Chúng tôi là StayNest Hãy cùng bạn bè và gia đình, <br>đặt phòng ngay tận hưởng nhanh
                        </p>
                    </div>
                </div>
                <div class="stay-nest-group-form-login col-md-5 pe-5">
                    <form method="POST" action="{{ route('auth.login') }}">
                        @csrf
                        <div class="stay-nest-text-head-login">
                            <h2 class="text">Đăng nhập</h2>
                            <div class="text-head-login">
                                <h5>Tận hưởng kỳ nghỉ của bạn với StayNest !</h5>
                                <p>Hãy đăng nhập và trải nghiệm dịch dụ đặt phòng của StayNest, hoặc đăng ký nếu chưa có
                                    tài
                                    khoản.</p>
                            </div>
                        </div>
                        <div class="animate-border mb-3 mt-1"></div>
                        <!-- <label for="floatingInput">Email hoặc Username</label> -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="login"
                                placeholder="Email hoặc Username"
                                value="{{ old('login', Cookie::get('remember_login')) }}" required>
                            <label for="floatingInput">Email hoặc Username</label>
                            @error('login')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- <label for="floatingPassword">Mật khẩu</label> -->
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control" id="floatingPassword" name="password"
                                placeholder="Mật khẩu">
                            <label for="floatingInput">Mật khẩu</label>
                            <span class="password-toggle-icon" id="togglePassword">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </span>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="stay-nest-group-function-login row">
                            <div class="col-md-6 function-login-1">
                            <div class="stay-nest-remember-login mb-2">
                                <input type="checkbox" id="rememberLogin" name="remember"
                                class="form-check-input stay-nest-check-box-remember p-2"
                                {{ Cookie::has('remember_login') ? 'checked' : '' }}>
                                <span>Ghi nhớ đăng nhập</span>
                            </div>
                            </div>
                            <div class="col-md-6 function-login-2">
                                <div>
                                    <a href="#" class="text-decoration-none">Khôi phục lại mật khẩu?</a>
                                </div>
                            </div>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Tiếp tục đăng nhập với mật
                            khẩu</button>
                    </form>

                    <div class="d-flex justify-content-between mt-3 mb-5">
                        <div>
                            <span>Chưa có tài khoản?</span>
                            <a href="{{ url('register') }}" class="text-decoration-none">Đăng ký tài khoản</a>
                        </div>
                    </div>
                    <span>
                        &copy; <span id="currentYear"></span> Staynest™. All rights reserved.
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.getElementById('currentYear').textContent = new Date().getFullYear();
    // Hàm chuyển đổi hiện/ẩn mật khẩu
    function togglePasswordVisibility(fieldId, iconId) {
        const passwordField = document.getElementById(fieldId);
        const icon = document.getElementById(iconId).querySelector('i');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Thêm sự kiện cho icon hiện/ẩn mật khẩu
    document.getElementById('togglePassword').addEventListener('click', function () {
        togglePasswordVisibility('floatingPassword', 'togglePassword');
    });

    // Hiệu ứng typing
    // const text = "Đăng nhập hoặc tạo một tài khoản"; // Your text here
    // let index = 0;
    // const typingSpeed = 100; // Speed in milliseconds
    // const element = document.querySelector(".typing-effect");

    // function typeWriter() {
    //     if (index < text.length) {
    //         element.textContent += text.charAt(index);
    //         index++;
    //         setTimeout(typeWriter, typingSpeed);
    //     }
    // }

    // window.onload = () => {
    //     typeWriter();
    // };
</script>
@endsection