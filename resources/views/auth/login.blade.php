@extends('layouts.app')

@section('content')
<div class="card-header text-center py-3 header">
    <h2 class="mb-0">STAYNEST</h2>
</div>

<main class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('auth.login') }}">
                        @csrf <!-- Bảo vệ CSRF -->

                        <h4 class="typing-effect"></h4>

                        <label for="floatingInput">Email hoặc Username</label>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="login" placeholder="Email hoặc Username" value="{{ old('login') }}" required>
                            @error('login')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <label for="floatingPassword">Mật khẩu</label>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Mật khẩu" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button class="w-100 btn btn-lg btn-primary" type="submit">Tiếp tục đăng nhập với mật khẩu</button>
                    </form>

                    <div class="d-flex justify-content-between mt-3">
                        <div>
                            <span>Chưa có tài khoản?</span>
                            <a href="{{ url('register') }}" class="text-decoration-none">Đăng ký tài khoản</a>
                        </div>
                        <div>
                            <a href="#" class="text-decoration-none">Khôi phục lại mật khẩu?</a>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <span class="flex-grow-1">
                            <hr>
                        </span>
                        <p class="mx-2 mb-0">Hoặc</p>
                        <span class="flex-grow-1">
                            <hr>
                        </span>
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
    const text = "Đăng nhập hoặc tạo một tài khoản"; // Your text here
    let index = 0;
    const typingSpeed = 100; // Speed in milliseconds
    const element = document.querySelector(".typing-effect");

    function typeWriter() {
        if (index < text.length) {
            element.textContent += text.charAt(index);
            index++;
            setTimeout(typeWriter, typingSpeed);
        }
    }

    window.onload = () => {
        typeWriter();
    };
</script>

@endsection
