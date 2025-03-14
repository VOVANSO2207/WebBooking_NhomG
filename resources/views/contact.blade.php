@extends('layouts.app')

<link rel="stylesheet" href="{{asset('css/blog.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('header')
@include('partials.header') 
@endsection
@section('content')

<div class="contact-container">
    <!-- Header -->
    <div class="contact-header">
        <h1>Liên Hệ Với Chúng Tôi</h1>
        <p>Chúng tôi rất vui lòng được hỗ trợ bạn. Vui lòng điền thông tin bên dưới.</p>
    </div>

    <!-- Thông tin liên hệ -->
    <div class="contact-info">
        <div class="info-item">
            <div class="info-icon"><i class="fas fa-envelope"></i></div>
            <h2>Email</h2>
            <p>support@example.com</p>
        </div>
        <div class="info-item">
            <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
            <h2>Điện Thoại</h2>
            <p>(+84) 123-456-789</p>
        </div>
        <div class="info-item">
            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
            <h2>Địa Chỉ</h2>
            <p>123 Đường Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh</p>
        </div>
    </div>

    <!-- Nội dung chính: bản đồ và form liên hệ -->
    <div class="contact-body">
        <!-- Form Liên Hệ -->
        <div class="form-wrapper">
            <div class="form-header">
                <h2>Gửi Thông Tin</h2>
                <p>Để lại thông tin của bạn và chúng tôi sẽ liên hệ lại trong thời gian sớm nhất</p>
            </div>
            <form class="contact-form" action="{{ route('contact') }}" method="post"
                onsubmit="return validateForm() && validateCaptcha()">
                @csrf <!-- Thêm CSRF token -->

                <div class="form-group">
                    <label for="name">Họ và Tên</label>
                    <input type="text" name="name" id="name" placeholder="Nhập họ và tên của bạn">
                    <span id="name-error" class="error-message">Họ và Tên không được để trống.</span>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Nhập địa chỉ email của bạn">
                    <span id="email-error" class="error-message">Email không hợp lệ.</span>
                </div>

                <div class="form-group">
                    <label for="body">Nội Dung Tin Nhắn</label>
                    <textarea name="body" id="body" rows="5" placeholder="Nhập nội dung tin nhắn của bạn"></textarea>
                    <span id="body-error" class="error-message">Nội Dung Tin Nhắn không được để trống.</span>
                </div>

                <!-- Captcha -->
                <div class="form-group captcha-container">
                    <label for="captcha-input">Mã xác nhận</label>
                    <div class="captcha-wrapper">
                        <canvas id="captcha-canvas" width="150" height="50"></canvas>
                        <button type="button" class="captcha-refresh" onclick="generateCaptcha()">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                    <input type="text" id="captcha-input" placeholder="Nhập mã xác nhận">
                    <span id="captcha-error" class="error-message">Mã captcha không đúng. Vui lòng thử lại.</span>
                </div>

                <button type="submit" class="submit-button">
                    <i class="fas fa-paper-plane"></i>
                    Gửi Tin Nhắn
                </button>
            </form>
        </div>

        <!-- Google Maps -->
        <div class="map-container">
            <div class="map-overlay">
                <h3>Vị Trí Của Chúng Tôi</h3>
                <p>Ghé thăm văn phòng của chúng tôi</p>
            </div>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.017245063024!2d106.69527061533587!3d10.77440999232417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752fcc7664b13f%3A0x2e70d7b9a2b4f615!2zTmfDtSAzLCBOZ3V54buFbiBI4buNYyAgUXXhuq1uIDEsIFRow6BuaCBwaOG7kSBI4buNYyBDaMOidSwgVMOibiBI4buNYyBDaMOidQ!5e0!3m2!1sen!2s!4v1635931256424!5m2!1sen!2s"
                allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

    <!-- Social media sharing -->
    <div class="social-connect">
        <h3>Kết nối với chúng tôi</h3>
        <div class="social-icons">
            <a href="#" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-icon twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-icon instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-icon linkedin"><i class="fab fa-linkedin-in"></i></a>
        </div>
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
        ctx.fillStyle = "#f5f7fa";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Add noise to captcha background
        for (let i = 0; i < 100; i++) {
            ctx.fillStyle = `rgba(${Math.random() * 200}, ${Math.random() * 200}, ${Math.random() * 200}, 0.2)`;
            ctx.fillRect(Math.random() * canvas.width, Math.random() * canvas.height, 2, 2);
        }
        
        drawCaptcha();
    }

    function drawCaptcha() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = '#f5f7fa';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Add noise to captcha background
        for (let i = 0; i < 100; i++) {
            ctx.fillStyle = `rgba(${Math.random() * 200}, ${Math.random() * 200}, ${Math.random() * 200}, 0.2)`;
            ctx.fillRect(Math.random() * canvas.width, Math.random() * canvas.height, 2, 2);
        }
        
        // Add lines for additional security
        ctx.strokeStyle = '#4da6ff';
        ctx.lineWidth = 1;
        for (let i = 0; i < 5; i++) {
            ctx.beginPath();
            ctx.moveTo(0, Math.random() * canvas.height);
            ctx.lineTo(canvas.width, Math.random() * canvas.height);
            ctx.stroke();
        }
        
        // Draw the characters
        for (let i = 0; i < captchaText.length; i++) {
            const rotationAngle = (Math.random() - 0.5) * 0.3;
            ctx.save();
            ctx.translate(10 + i * 30, 30 + positions[i]);
            ctx.rotate(rotationAngle);
            ctx.font = "bold 24px Arial";
            ctx.fillStyle = '#3498db';
            ctx.fillText(captchaText[i], 0, 0);
            ctx.restore();
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
        const errorElements = document.querySelectorAll('.error-message');
        
        // Hide all error messages first
        errorElements.forEach(element => {
            element.style.display = 'none';
        });

        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const body = document.getElementById('body').value.trim();

        if (name === '') {
            document.getElementById('name-error').innerText = 'Họ và Tên không được để trống.';
            document.getElementById('name-error').style.display = 'block';
            valid = false;
        } else if (name.length > 100) {
            document.getElementById('name-error').innerText = 'Họ và Tên không được quá 100 ký tự.';
            document.getElementById('name-error').style.display = 'block';
            valid = false;
        }

        if (email === '') {
            document.getElementById('email-error').innerText = 'Email không được để trống.';
            document.getElementById('email-error').style.display = 'block';
            valid = false;
        } else {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                document.getElementById('email-error').innerText = 'Email không hợp lệ.';
                document.getElementById('email-error').style.display = 'block';
                valid = false;
            }
        }

        if (body === '') {
            document.getElementById('body-error').innerText = 'Nội Dung Tin Nhắn không được để trống.';
            document.getElementById('body-error').style.display = 'block';
            valid = false;
        } else if (body.length > 1000) {
            document.getElementById('body-error').innerText = 'Nội Dung Tin Nhắn không được quá 1000 ký tự.';
            document.getElementById('body-error').style.display = 'block';
            valid = false;
        }

        const specialCharPattern = /[!@#$%^&*(){}|<>?":;[\]\/\\`~_+=-]/;
        if (specialCharPattern.test(name)) {
            document.getElementById('name-error').innerText = 'Họ và Tên không được chứa ký tự đặc biệt.';
            document.getElementById('name-error').style.display = 'block';
            valid = false;
        }

        if (specialCharPattern.test(body)) {
            document.getElementById('body-error').innerText = 'Nội Dung Tin Nhắn không được chứa ký tự đặc biệt.';
            document.getElementById('body-error').style.display = 'block';
            valid = false;
        }

        return valid;
    }

    function validateCaptcha() {
        const userInput = document.getElementById('captcha-input').value.trim();
        document.getElementById('captcha-error').style.display = 'none';

        if (userInput !== captchaText) {
            document.getElementById('captcha-error').innerText = 'Mã captcha không đúng. Vui lòng thử lại.';
            document.getElementById('captcha-error').style.display = 'block';
            generateCaptcha();
            return false;
        }
        return true;
    }
</script>
@endsection

@section('footer')
@include('partials.footer') 
@endsection