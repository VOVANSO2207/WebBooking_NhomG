@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staynest - Đăng nhập</title>

    <style>
        body {
            background-color: #f0f2f5;
        }

        .login-container {
            max-width: 100%;
            padding: 15px;
        }

        .header {
            background: rgb(23, 85, 164);
            background: linear-gradient(93deg, rgba(23, 85, 164, 1) 42%, rgba(24, 157, 216, 1) 87%);
            color: white;
            width: 100%;
        }

        .btn-primary {
            background-color: #4267B2;
            border-color: #4267B2;
        }

        .btn-primary:hover {
            background-color: #365899;
            border-color: #365899;
        }

        .social-btn {
            border: 1px solid #ddd;
        }

        .social-btn:hover {
            border: 1px solid #ddd;
        }

        .icon-facebook,
        .icon-goole {
            width: 20px;
            height: 20px;
            object-fit: cover;
        }

        .typing-effect {
            font-size: 24px;
            /* font-family: 'Time', Courier, monospace; */
            white-space: nowrap;
            border-right: 2px solid;
            width: 100%;
            overflow: hidden;
        }
    </style>
</head>

<body>
    <div class="card-header text-center py-3 header">
        <h2 class="mb-0">STAYNEST</h2>
    </div>

    <main class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card">

                    <div class="card-body p-4">
                        <form method="">
                        <h4 class="typing-effect"></h4>

                            <label for="username">Tên đăng nhập</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="username"
                                    value="" required>
                            </div>
                            <label for="email">Email</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="email"
                                   value="" required>
                            </div>
                            <label for="phone">Số điện thoại</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="phone"
                                    value="" required>
                            </div>
                           
                            <label for="passwords">Mật khẩu</label>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="passwords"
                                  value="" required>
                            </div>
                            <label for="floatingInput">Nhập lại mật khẩu</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="floatingInput"
                                    value="" required>
                            </div>
                            <button class="w-100 btn btn-lg btn-primary" type="submit">Đăng ký tài khoản</button>
                        </form>

                        <div class="d-flex justify-content-between mt-3">
                            <div>
                                <span>Đã có tài khoản?</span>
                                <a href="{{url('login')}}" class="text-decoration-none">Đăng nhập ngay</a>
                            </div>
                         
                        </div>

                        <!-- Inline separator -->
                        <div class="d-flex align-items-center justify-content-between mt-3">
                            <span class="flex-grow-1">
                                <hr>
                            </span>
                            <p class="mx-2 mb-0">Hoặc</p>
                            <span class="flex-grow-1">
                                <hr>
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button class="btn social-btn flex-grow-1 me-2">
                                <img src="{{asset('images/facebook.png')}}" alt="Facebook icon"
                                    class="me-2 icon-facebook">
                                Đăng nhập với tài khoản facebook
                            </button>
                            <button class="btn social-btn flex-grow-1 ms-2">
                                <img src="{{asset('images/google.png')}}" alt="Google icon" class="me-2 icon-goole">
                                Đăng nhập với tài khoản google
                            </button>
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
        const text = "Đăng ký một tài khoản"; // Your text here
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
</body>

</html>

    @endsection