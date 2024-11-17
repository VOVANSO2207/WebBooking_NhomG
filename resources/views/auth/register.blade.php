@extends('layouts.app')

@section('content')
    <div class="card-header text-center py-3 header">
        <h2 class="mb-0 text-light">STAYNEST</h2>
    </div>

    <main class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card">

                    <div class="card-body p-4">
                        <form id="registerForm" method="POST" action="{{ route('register') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            @csrf
                            <div class="terminal-loader mb-2">
                                <h2 class="text">Đăng ký một tài khoản</h2>
                            </div>
                            <!-- <h4 class="typing-effect"></h4> -->
                            <label for="username">Tên đăng nhập</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ old('username') }}" required>
                                <span class="text-danger" id="usernameError"></span>
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="email">Email</label>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}" required>
                                <span class="text-danger" id="emailError"></span>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="phone">Số điện thoại</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="phone" name="phone_number"
                                    value="{{ old('phone_number') }}">
                                <span class="text-danger" id="phoneError"></span>
                            </div>
                            
                            <label for="password">Mật khẩu</label>
                            <div class="position-relative">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <span class="password-toggle-icon" id="togglePassword">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </span>

                            </div>
                            <span class="text-danger password" id="passwordError"></span>

                            <label for="password_confirmation">Nhập lại mật khẩu</label>
                            <div class="position-relative">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                                <span class="password-toggle-icon" id="togglePasswordConfirm">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </span>

                            </div>
                            <span class="text-danger confirmpass" id="passwordConfirmError"></span>
                            <button class="w-100 btn btn-lg btn-primary" type="submit">Đăng ký tài khoản</button>
                        </form>

                        <div class="d-flex justify-content-between mt-3">
                            <div>
                                <span>Đã có tài khoản?</span>
                                <a href="{{ url('login') }}" class="text-decoration-none">Đăng nhập ngay</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center text-muted">
                        Website by team © Staynest™
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script>
        // Hàm kiểm tra tính hợp lệ của form
        function validateForm() {
            let isValid = true;

            // Kiểm tra tên đăng nhập
            const username = document.getElementById('username').value;
            const usernameError = document.getElementById('usernameError');
            if (username.length === 0) {
                usernameError.textContent = "Vui lòng nhập tên đăng nhập.";
                isValid = false;
            } else if (username.length < 5 || username.length > 25) {
                usernameError.textContent = "Tên đăng nhập phải từ 5-25 ký tự.";
                isValid = false;
            } else {
                usernameError.textContent = "";
            }

            // Kiểm tra email
            const email = document.getElementById('email').value;
            const emailError = document.getElementById('emailError');
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                emailError.textContent = "Vui lòng nhập địa chỉ email hợp lệ.";
                isValid = false;
            } else {
                emailError.textContent = "";
            }

            // Kiểm tra số điện thoại
            const phone = document.getElementById('phone').value;
            const phoneError = document.getElementById('phoneError');
            const phonePattern = /^0[0-9]{9}$/;
            if (phone !== "" && !phonePattern.test(phone)) {
                phoneError.textContent = "Số điện thoại không hợp lệ. Ví dụ: 0123456789.";
                isValid = false;
            } else {
                phoneError.textContent = "";
            }

            // Kiểm tra mật khẩu
            const password = document.getElementById('password').value;
            const passwordError = document.getElementById('passwordError');
            if (password.length < 8) {
                passwordError.textContent = "Mật khẩu phải dài ít nhất 8 ký tự.";
                isValid = false;
            } else {
                passwordError.textContent = "";
            }

            // Kiểm tra xác nhận mật khẩu
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const passwordConfirmError = document.getElementById('passwordConfirmError');
            if (password !== passwordConfirmation) {
                passwordConfirmError.textContent = "Vui lòng xác nhận lại mật khẩu.";
                isValid = false;
            } else {
                passwordConfirmError.textContent = "";
            }

            return isValid;
        }

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

        // Thêm sự kiện cho form khi submit
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            if (!validateForm()) {
                event.preventDefault();
            }
        });

        // Thêm sự kiện cho icon hiện/ẩn mật khẩu
        document.getElementById('togglePassword').addEventListener('click', function() {
            togglePasswordVisibility('password', 'togglePassword');
        });

        document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
            togglePasswordVisibility('password_confirmation', 'togglePasswordConfirm');
        });

        // Hiệu ứng typing cho tiêu đề
        // const text = "Đăng ký một tài khoản"; // Văn bản cần hiệu ứng typing
        // let index = 0;
        // const typingSpeed = 100; // Tốc độ typing (ms)
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
