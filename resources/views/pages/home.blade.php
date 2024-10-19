<!-- resources/views/pages/home.blade.php -->
@extends('layouts.app')

@section('title', 'Trang chủ')
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/animation.js') }}"></script>
<script src="{{ asset('js/counter_control.js') }}"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>



<!-- CSS -->
<style>
    /* Reset CSS*/
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html,
    body {
        height: 100%;
    }

    body {
        line-height: 1.5;
        font-family: sans-serif;
    }

    img,
    picture,
    video,
    canvas {
        max-width: 100%;
        display: block;
    }

    input,
    button,
    textarea,
    select {
        font: inherit;
    }

    /* Đặt lại box-sizing cho tất cả phần tử */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    .header-staynest {
        /* background: rgb(29,60,99);
    background: linear-gradient(90deg, rgba(29,60,99,1) 0%, rgba(59,121,201,1) 100%); */
        position: relative;
        /* Đặt vị trí tương đối cho header */
        background-image: url('../images/banner_01.png');
        background-repeat: no-repeat;
        background-size: cover;
        width: 100%;
        height: 100vh;
        /* Chiều cao 100% viewport */
    }

    .banner {
        position: absolute;
        /* Đặt banner ở vị trí tuyệt đối */
        top: 0;
        left: 0;
        width: 100%;
        /* Chiếm toàn bộ chiều rộng */
        height: 100%;
        /* Chiếm toàn bộ chiều cao */
        z-index: 1;
        /* Đặt z-index thấp hơn để bg-in-image nằm trên */
    }

    .bg-in-image {
        position: absolute;
        /* Đặt bg-in-image ở vị trí tuyệt đối */
        background: black;
        opacity: 0.5;
        /* Độ mờ 50% */
        inset: 0;
        /* Lấp đầy toàn bộ phần tử cha */
        z-index: 2;
        /* Đặt z-index cao hơn banner */
    }

    .header-staynest>* {
        /* Các phần tử con bên trong header */
        position: relative;
        /* Đặt vị trí tương đối cho các phần tử con */
        z-index: 3;
        /* Đặt z-index cao hơn bg-in-image để nó nằm trên cùng */
    }

    .logo-staynest {
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
    }

    .name-logo {
        font-weight: 900;
        color: white;
        margin: 0;
        font-size: 51px;
    }

    .top-header {
        border-bottom: 1px solid gray;
    }

    .link-social {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        border: 1px solid rgb(255, 255, 255);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        padding: 0;
        transition: background-color 0.3s;
        text-decoration: none;
        margin-left: 10px;
        background: #f1f1f158;
        backdrop-filter: blur(5px);
        opacity: .7;
    }

    .link-social:hover {
        opacity: 1;
        background-color: rgba(255, 255, 255, 0.821);
    }

    .link-social:nth-child(2) {
        color: black;
    }

    .link-social:nth-child(3) {
        color: red;
    }

    .link-social i {
        font-size: 20px;
    }

    .menu-attribute {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .menu-attribute li a,
    .group-left-header {
        cursor: pointer;
        margin: 13px 15px;
        font-weight: 700;
        color: #fff;
        transition: all 300ms ease;
    }

    .menu-attribute li a:hover {
        color: #3B79C9;

    }

    .group-left-header a {
        color: #fff !important;

    }

    .menu-attribute a,
    .group-left-header a {
        text-decoration: none;
        color: black;
    }

    .menu-attribute li:hover {
        color: #3B79C9;
    }

    .group-left-header a:hover {
        text-decoration: underline;
        color: #3B79C9;
    }

    .group-left-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .name-user {
        flex-grow: 1;
        text-align: center;
        /* Căn giữa chữ */
        white-space: nowrap;
        /* Ngăn chữ xuống dòng */
        overflow: hidden;
        /* Ẩn phần chữ thừa */
        text-overflow: ellipsis;
        /* Hiện ba chấm nếu quá dài */
    }

    .name-user:hover {
        color: #3B79C9;
    }

    .dropdown-menu {
        display: block;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 0;
    }

    .middle-staynest {
        z-index: 2;
    }

    .dropdown-item-staynest {
        color: #505050;
        text-decoration: none;
        font-weight: 500 !important;
    }

    .dropdown-item-staynest:hover {
        background-color: #f1f1f1;
        color: #3B79C9 !important;
    }

    .solgan-staynest p {
        display: flex;
        color: #fff;
        font-weight: 900;
        font-size: 90px;
        text-align: center;
        justify-content: center;
        padding: 15px;
        margin: 50px;
    }

    .input-search-header {
        border-radius: 5px;
        height: 47px;
        width: 100%;
        outline: none;
        border: none;
    }

    /* Drop select location */
    .select2 {
        border-radius: 10px;
    }

    .select2-hidden-accessible {
        border: 0 !important;
        clip: rect(0 0 0 0) !important;
        height: 1px !important;
        margin: -1px !important;
        overflow: hidden !important;
        padding: 0 !important;
        position: absolute !important;
        width: 1px !important;
    }

    .select2-search__field {
        outline: none;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 0;
        padding-right: 0;
        height: auto;
        margin-top: -3px;
    }


    .select2-container--default .select2-selection--single,
    .select2-selection .select2-selection--single {
        border: 1px solid #d2d6de;
        border-radius: 0 !important;
        padding: 10px 16px;
        height: 47px !important;
        border-radius: 10px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px;
        position: absolute;
        top: 9px !important;
        right: 1px;
        width: 20px
    }

    /*  */

    /* .datepicker-staynest {
    height: 47px;
    width: 100%;
    border-radius: 10px;
    border: none;
    text-align: center;
    outline: none;
} */
    .number {
        font-weight: 700;
    }

    .num-people {
        border-radius: 10px;
        width: 100%;
        padding: 0 10px 5px;
        border: 1px solid black;
        background: #fff;
        position: relative;
        cursor: pointer;
    }


    .date-picker-search {
        position: relative;
        background: #fff;
        border-radius: 10px;
        height: 50px;
    }

    .datepicker-staynest:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    .datepicker-staynest {
        position: absolute;
        border: none !important;
        text-align: center;
        background: transparent !important;
        border: none;
        font-weight: 700 !important;
        cursor: pointer;
    }

    /*  */
    .drop-counter {
        z-index: 10;
        position: absolute;
        padding: 15px;
        border-radius: 10px;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
        display: none;
    }

    .item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .counter {
        display: flex;
        align-items: center;
    }

    .counter button {
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        font-size: 20px;
        line-height: 0;
        text-align: center;
        cursor: pointer;
    }

    .counter button:hover {
        background-color: #ddd;
    }

    .counter .value-people {
        width: 30px;
        text-align: center;
        border: none;
        background-color: transparent;
        font-size: 16px;
        pointer-events: none;
    }
</style>
<!-- /CSS -->

<script>
    // Datepicker
    function initializeDateRangePicker() {
        const startDate = moment(); // Ngày hiện tại
        const endDate = moment().add(1, 'days'); // Ngày hiện tại + 7 ngày

        $('input[name="daterange"]').daterangepicker({
            startDate: startDate,
            endDate: endDate,
            minDate: startDate, // Ngày hiện tại là ngày nhỏ nhất
            opens: 'center',
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end) {
            // Cập nhật giá trị của input khi người dùng chọn
            $('input[name="daterange"]').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        });

        // Cập nhật giá trị mặc định cho input
        $('input[name="daterange"]').val(startDate.format('DD/MM/YYYY') + ' - ' + endDate.format('DD/MM/YYYY'));
    }

    $(document).ready(function () {
        $('.select2').select2(); // Khởi tạo Select2 cho các phần tử có class "select2"
    });

    $(document).ready(function () {
        initializeDateRangePicker(); // Gọi hàm khởi tạo
    });
</script>


@section('content')
<div class="banner"></div>
<div class="bg-in-image"></div>
<section class="header-staynest">
    <div class="top-header">
        <a href="#" class="logo-staynest p-3">
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
                        <li><a href="#">TRANG CHỦ</a></li>
                        <li><a href="#">GIỚI THIỆU</a></li>
                        <li><a href="#">PHÒNG KHÁCH SẠN</a></li>
                        <li><a href="#">TIN TỨC</a></li>
                        <li><a href="#">LIÊN HỆ</a></li>
                    </ul>
                </div>
                <div class="profile-header col-md-2">
                    <!-- Nếu chưa đăng nhập -->
                    <div class="group-left-header">
                        <a href="#" class="login">Đăng nhập/</a>
                        <a href="#" class="register">Đăng ký</a>
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
    <section class="middle-staynest container mt-5">
        <div class="search-bar-staynest color-light">
            <form action="{{ route('hotels.search') }}" method="GET" class="row d-flex justify-content-center">
                @csrf
                <div class="col-md-3 search-header">
                    <div class="form-group">
                        <select name="location" class="form-control-staynest select2" style="width: 100%;" tabindex="-1"
                            aria-hidden="true" required>
                            <option value="">Địa điểm cần tìm</option>
                            @if ($cities->isEmpty())
                                <option value="">Chưa có địa điểm hiển thị</option>
                            @else
                                @foreach ($cities as $citie)
                                    <option value="{{ $citie->city_id }}" id="{{ $citie->city_id }}">{{ $citie->city_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="date-picker-search border">
                        <div class="d-flex justify-content-around">
                            <div class="label-date">Ngày đi</div>
                            <div class="label-date">Ngày về</div>
                        </div>
                        <input class="datepicker-staynest form-control p-0 m-0" type="text" name="daterange" readonly />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="num-people border">
                        <label class="small-text">Số người</label>
                        <div class="number">
                            <span id="people-summary">1 người lớn, </span>
                            <span id="room-summary">1 phòng, </span>
                            <span id="children-summary">0 trẻ em</span>
                        </div>
                    </div>
                    <div class="drop-counter mt-1 bg-light">
                        <div class="item">
                            <span>Phòng</span>
                            <div class="counter">
                                <button type="button" class="decrement-room">-</button>
                                <input type="text" class="value-people" id="rooms" name="rooms" value="1" readonly>
                                <button type="button" class="increment-room">+</button>
                            </div>
                        </div>
                        <div class="item">
                            <span>Người lớn</span>
                            <div class="counter">
                                <button type="button" class="decrement-adult">-</button>
                                <input type="text" class="value-people" id="adults" name="adults" value="1" readonly>
                                <button type="button" class="increment-adult">+</button>
                            </div>
                        </div>
                        <div class="item">
                            <span>Trẻ em</span>
                            <div class="counter">
                                <button type="button" class="decrement-children">-</button>
                                <input type="text" class="value-people" id="children" name="children" value="0"
                                    readonly>
                                <button type="button" class="increment-children">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 search-header button-search-header">
                    <button type="submit" class="btn btn-primary" style="width: 100%; height: 47px;">Tìm Khách
                        Sạn</button>
                </div>
            </form>

        </div>
        <div class="solgan-staynest">
            <p>ĐẶT PHÒNG NHANH TẬN HƯỞNG NGAY</p>
        </div>
    </section>
</section>
<section class="top-hotel">

</section>

<!-- Thêm các nội dung khác cho trang chủ ở đây -->
@endsection