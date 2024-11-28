@extends('layouts.app')

<link rel="stylesheet" href="{{asset('css/blog.css')}}">

@section('header')
@include('partials.header') 
@endsection
@section('content')

<div class="contact-container mt-5 mb-5">
    <!-- Header -->
    <div class="contact-header">
        <h1>Liên Hệ Với Chúng Tôi</h1>
        <p>Chúng tôi rất vui lòng được hỗ trợ bạn. Vui lòng điền thông tin bên dưới.</p>
    </div>

    <!-- Thông tin liên hệ -->
    <div class="contact-info">
        <div class="info-item">
            <h2>Địa Chỉ</h2>
            <p>123 Đường Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh</p>
        </div>
        <div class="info-item">
            <h2>Email</h2>
            <p>support@example.com</p>
        </div>
        <div class="info-item">
            <h2>Điện Thoại</h2>
            <p>(+84) 123-456-789</p>
        </div>
    </div>

    <!-- Nội dung chính: bản đồ và form liên hệ -->
    <div class="contact-body">

        <!-- Google Maps -->
        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.017245063024!2d106.69527061533587!3d10.77440999232417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752fcc7664b13f%3A0x2e70d7b9a2b4f615!2zTmfDtSAzLCBOZ3V54buFbiBI4buNYyAgUXXhuq1uIDEsIFRow6BuaCBwaOG7kSBI4buNYyBDaMOidSwgVMOibiBI4buNYyBDaMOidQ!5e0!3m2!1sen!2s!4v1635931256424!5m2!1sen!2s"
                allowfullscreen="" loading="lazy"></iframe>
        </div>

        <!-- Form Liên Hệ -->
        <form class="contact-form" action="{{ route('contact') }}" method="post"
            onsubmit="return validateForm() && validateCaptcha()">
            @csrf <!-- Thêm CSRF token -->

            <input type="text" name="name" id="name" placeholder="Họ và Tên">
            <span id="name-error" style="color: red; display: none;">Họ và Tên không được để trống.</span>

            <input type="email" name="email" id="email" placeholder="Email">
            <span id="email-error" style="color: red; display: none;">Email không hợp lệ.</span>

            <textarea name="body" id="body" rows="5" placeholder="Nội Dung Tin Nhắn"></textarea>
            <span id="body-error" style="color: red; display: none;">Nội Dung Tin Nhắn không được để trống.</span>

            <!-- Captcha -->
            <div style="display: flex; align-items: center;">
                <canvas id="captcha-canvas" width="150" height="50" style="border: 1px solid #ccc;"></canvas>
                <button type="button" onclick="generateCaptcha()"
                    style="margin-left: 10px; background-color: #3498db; color: white; border: none; border-radius: 5px; padding: 10px;">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
            <input type="text" id="captcha-input" placeholder="Nhập mã captcha">
            <span id="captcha-error" style="color: red; display: none;">Mã captcha không đúng. Vui lòng thử
                lại.</span>

            <button type="submit">Gửi Tin Nhắn</button>
        </form>
    </div>
</div>

<script>
    const canvas = document.getElementById('captcha-canvas');
    const ctx = canvas.getContext('2d');
    let captchaText = '';
    let positions = [];

    function generateCaptcha() {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        captchaText = '';
        positions = [];
        for (let i = 0; i < 5; i++) {
            captchaText += characters.charAt(Math.floor(Math.random() * characters.length));
            positions.push(Math.random() * 10);
        }


        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = "black";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.font = "24px Arial";
        drawCaptcha();
    }

    function drawCaptcha() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = '#3498db';
        for (let i = 0; i < captchaText.length; i++) {
            ctx.fillText(captchaText[i], 10 + i * 30, 25 + positions[i]);
        }
    }

    function animateCaptcha() {
        for (let i = 0; i < positions.length; i++) {
            positions[i] = Math.sin(Date.now() / 500 + i) * 5;
        }
        drawCaptcha();
        requestAnimationFrame(animateCaptcha);
    }

    window.onload = function () {
        generateCaptcha();
        animateCaptcha();
    };

    function validateForm() {
        let valid = true;

        document.getElementById('name-error').style.display = 'none';
        document.getElementById('email-error').style.display = 'none';
        document.getElementById('body-error').style.display = 'none';

        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const body = document.getElementById('body').value.trim();

        if (name === '') {
            document.getElementById('name-error').innerText = 'Họ và Tên không được để trống.';
            document.getElementById('name-error').style.display = 'inline';
            valid = false;
        }
        if (name.length > 100) {
            document.getElementById('name-error').innerText = 'Họ và Tên không được quá 100 ký tự.';
            document.getElementById('name-error').style.display = 'inline';
            valid = false;
        }
        if (body.length > 1000) {
            document.getElementById('body-error').innerText = 'Nội Dung Tin Nhắn không được quá 1000 ký tự.';
            document.getElementById('body-error').style.display = 'inline';
            valid = false;
        }

        if (email === '') {
            document.getElementById('email-error').innerText = 'Email không được để trống.';
            document.getElementById('email-error').style.display = 'inline';
            valid = false;
        } else {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                document.getElementById('email-error').innerText = 'Email không hợp lệ.';
                document.getElementById('email-error').style.display = 'inline';
                valid = false;
            }
        }

        if (body === '') {
            document.getElementById('body-error').innerText = 'Nội Dung Tin Nhắn không được để trống.';
            document.getElementById('body-error').style.display = 'inline';
            valid = false;
        }

        const specialCharPattern = /[!@#$%^&*(){}|<>?":;[\]\/\\`~_+=-]/;
        if (specialCharPattern.test(name)) {
            document.getElementById('name-error').innerText = 'Họ và Tên không được chứa ký tự đặc biệt.';
            document.getElementById('name-error').style.display = 'inline';
            valid = false;
        }

        if (specialCharPattern.test(body)) {
            document.getElementById('body-error').innerText = 'Nội Dung Tin Nhắn không được chứa ký tự đặc biệt.';
            document.getElementById('body-error').style.display = 'inline';
            valid = false;
        }

        return valid;
    }

    function validateCaptcha() {
        const userInput = document.getElementById('captcha-input').value.trim();

        if (userInput !== captchaText) {
            document.getElementById('captcha-error').innerText = 'Mã captcha không đúng. Vui lòng thử lại.';
            document.getElementById('captcha-error').style.display = 'inline';
            generateCaptcha();
            return false;
        }
        document.getElementById('captcha-error').style.display = 'none';
        return true;
    }
</script>
@endsection

@section('footer')
@include('partials.footer') 
@endsection