<!-- resources/views/pages/home.blade.php -->
@extends('layouts.app')

@section('title', 'Trang chủ')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->

<!-- <script>
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
        }, function(start, end) {
            // Cập nhật giá trị của input khi người dùng chọn
            $('input[name="daterange"]').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        });

        // Cập nhật giá trị mặc định cho input
        $('input[name="daterange"]').val(startDate.format('DD/MM/YYYY') + ' - ' + endDate.format('DD/MM/YYYY'));
    }

    $(document).ready(function() {
        $('.select2').select2(); // Khởi tạo Select2 cho các phần tử có class "select2"
    });

    $(document).ready(function() {
        initializeDateRangePicker(); // Gọi hàm khởi tạo
    });
</script> -->

@section('content')
    <div class="banner-home"></div>
    <section class="header-staynest-home">
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
                            <li><a href="{{ route('blog') }}">TIN TỨC</a></li>
                            <li><a href="{{ route(name: 'contact') }}">LIÊN HỆ</a></li>
                        </ul>
                    </div>
                    <div class="profile-header col-md-2">
                        <!-- Nếu chưa đăng nhập -->
                        <!-- <div class="group-left-header">
                                                                                    <a href="#" class="login">Đăng nhập/</a>
                                                                                    <a href="#" class="register">Đăng ký</a>
                                                                                </div> -->
                        <!-- Nếu đã đăng nhập -->
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
                                    @if (Auth::check())
                                        <img src="{{ Auth::user()->avatar ? asset('storage/images/' . Auth::user()->avatar) : asset('storage/images/user-profile.png') }}"
                                            alt="Avatar" class="img-fluid rounded-circle"
                                            style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                    @else
                                        <img src="{{ asset('images/user-profile.png') }}" alt="Default User Profile"
                                            style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                    @endif
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
                                @if (Auth::check())
                                    <a href="#" class="dropdown-item dropdown-item-staynest text-danger"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Đăng Xuất
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="dropdown-item dropdown-item-staynest">
                                        Đăng Nhập
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="middle-staynest-home mt-5">
            <div class="search-bar-staynest-home color-light container">
                <form action="{{ route('hotels.search') }}" method="GET" class="row d-flex justify-content-center">
                    @csrf
                    <div class="col-md-3 search-header">
                        <div class="form-group">
                            <select name="location" class="form-control-staynest select2" style="width: 100%;"
                                tabindex="-1" aria-hidden="true" required>
                                @if ($cities->isEmpty())
                                    <option value="">Chưa có địa điểm hiển thị</option>
                                @else
                                    @foreach ($cities as $citie)
                                        <option value="{{ $citie->city_id }}" id="{{ $citie->city_id }}">
                                            {{ $citie->city_name }}
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
                            <input class="datepicker-staynest form-control p-0 m-0" type="text" name="daterange"
                                readonly />
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
                                    <input type="text" class="value-people" id="rooms" name="rooms"
                                        value="1" readonly>
                                    <button type="button" class="increment-room">+</button>
                                </div>
                            </div>
                            <div class="item">
                                <span>Người lớn</span>
                                <div class="counter">
                                    <button type="button" class="decrement-adult">-</button>
                                    <input type="text" class="value-people" id="adults" name="adults"
                                        value="1" readonly>
                                    <button type="button" class="increment-adult">+</button>
                                </div>
                            </div>
                            <div class="item">
                                <span>Trẻ em</span>
                                <div class="counter">
                                    <button type="button" class="decrement-children">-</button>
                                    <input type="text" class="value-people" id="children" name="children"
                                        value="0" readonly>
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
            <div class="slogan-staynest container">
                <p>ĐẶT PHÒNG NHANH TẬN HƯỞNG NGAY</p>
                <p class="header-text-muted">Khám phá du lịch với dịch vụ đặt phòng nhanh chóng và tiện lợi. Hãy bắt đầu
                    hành trình
                    của bạn ngay hôm
                    nay!</p>
            </div>
            <div class="button-book d-flex justify-content-center">
                <a href="#" class="header-btn-book-now">ĐẶT NGAY</a>
            </div>
        </div>
    </section>

    <section class="famous-hotel">
        <div class="container">
            <div class="title mt-5 mb-2">Khách Sạn Nổi Tiếng</div>
            <div class="carousel-container">
                <div class="carousel-wrapper">
                    @foreach ($hotels as $hotel)
                        @if ($hotel->rating >= 4.0)
                            <div class="card the-top-khach-san">
                                @foreach ($hotel->images as $index => $image)
                                    @if ($index === 0)
                                        <img class="image-hotel-1" src="{{ asset('images/' . $image->image_url) }}"
                                            alt="{{ $image->image_url }}" />
                                    @endif
                                @endforeach

                                <div class="shape">
                                    <p class="country m-0">VIET NAM</p>
                                    <p class="location m-0">{{ $hotel->location }} - <span
                                            class="name-hotel">{{ $hotel->hotel_name }}</span></p>
                                    <p class="price-old m-0">VNĐ {{ number_format($hotel->price_old, 0, ',', '.') }} VNĐ
                                    </p>
                                    <div class="row price-top">
                                        <div class="col-md-7">
                                            <span class="price-new">VNĐ
                                                {{ number_format($hotel->price_new, 0, ',', '.') }} VNĐ
                                                <span>/ Khách</span> </span>
                                        </div>
                                        <div class="col-md-5">
                                            <a href="{{ route('pages.hotel_detail', ['hotel_id' => $hotel->hotel_id]) }}"
                                                class="btn-book-now">ĐẶT NGAY</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="rating-top">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $hotel->rating)
                                            <span>★</span>
                                        @else
                                            <span>☆</span>
                                        @endif
                                    @endfor
                                </div>
                                <!-- <div class="sale"><span>-</span>50%</div> -->
                            </div>
                        @endif
                    @endforeach
                </div>
                <button class="prev-btn"><i class="fa-solid fa-arrow-right"></i></button>
                <button class="next-btn"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </section>

    <section class="popular-destination pb-5">
        <div class="container">
            <div class="title mb-2">Điểm đến thịnh hành</div>
            <div class="row">
                <div class="col-md-6">
                    <a href="#" class="link-popular-destination">
                        <img class="image-destitation-1"
                            src="https://image.vietnamnews.vn/uploadvnnews/Article/2023/9/28/308010_4651436783396218_vna_potal_thanh_pho_ho_chi_minh_la_1_trong_10_diem_den_tuyet_voi_nhat_o_chau_a_6666855.jpg"
                            alt="image">
                        <p class="name-location-1">HỒ CHÍ MINH</p>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="link-popular-destination">
                        <img class="image-destitation-1"
                            src="https://letsflytravel.vn/assets/source/2_5_2024_Up/nha-trang-city-tour/nha-trang-letsflytravel.jpg"
                            alt="image">
                        <p class="name-location-1">ĐÀ NẴNG</p>
                </div>
                </a>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <a href="#" class="link-popular-destination">
                        <img class="image-destitation-1"
                            src="https://static.vinwonders.com/production/gioi-thieu-ve-da-lat-1.jpg" alt="image">
                        <p class="name-location-1">ĐÀ LẠT</p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="link-popular-destination">
                        <img class="image-destitation-1"
                            src="https://th.bing.com/th/id/R.05b072e1b9b939addf7c3f25637efa5e?rik=3F5fed7sbYHisQ&pid=ImgRaw&r=0"
                            alt="image">
                        <p class="name-location-1">CÀ MAU</p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="link-popular-destination">
                        <img class="image-destitation-1"
                            src="https://vcdn1-dulich.vnecdn.net/2022/06/03/cauvang-1654247842-9403-1654247849.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=Swd6JjpStebEzT6WARcoOA"
                            alt="image">
                        <p class="name-location-1">ĐÀ NẴNG</p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="our-offers pb-5">
        <div class="container">
            <div class="title mb-2">Ưu đãi của chúng tôi</div>

            <div class="Popular_filters">
                <!-- Bộ lọc Thành phố -->
                <div class="option">
                    <div class="city-filters d-flex flex-wrap">
                        @if ($cities->isEmpty())
                            <span>Chưa có thành phố để hiển thị</span>
                        @else
                            @foreach ($cities as $city)
                                <div class="city-option mb-3">
                                    <button class="btn btn-outline-primary btn-lg city-btn" data-city-id="{{ $city->city_id }}">{{ $city->city_name }}</button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="carousel-container">
                <div class="carousel-wrapper carousel-wrapper2">
                    @foreach ($hotels as $hotel)
                        <div class="card">
                            <a href="#" class="group-offers">
                                <div class="shape-in">
                                    @if ($hotel->images->isNotEmpty())
                                        <img class="image-hotel-2"
                                            src="{{ asset('storage/images/' . $hotel->images->first()->image_url) }}"
                                            alt="">
                                    @else
                                        <img class="image-hotel-2" src="{{ asset('/images/defaullt-image.png') }}"
                                            alt="">
                                    @endif

                                    <div class="group-info-hotel">
                                        <p class="info-hotel-name m-0">{{ $hotel->hotel_name }}</p>

                                        <p class="info-hotel-location m-0">{{ $hotel->location }},
                                            {{ $hotel->city->city_name }}</p>
                                        <p class="info-hotel-reviews m-0"><i class="fa-regular fa-comment"></i>
                                            {{ $hotel->reviews->count() }} Đánh giá
                                        </p>

                                        <p class="info-hotel-price-old mb-0 mt-5 pt-5">
                                        {{ number_format($hotel->average_price_sale, 0, ',', '.') }} VND</p>
                                        <div class="row group-heart-price">
                                            <div class="col-md-6">
                                                <a href="#" class="heart-icon" data-hotel-id="{{ $hotel->hotel_id }}">
                                                    <i class="fa-regular fa-heart @if($hotel->is_favorite) fa-solid red @endif"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-6 text-right"><span
                                                    class="info-hotel-price-new"> {{ number_format($hotel->average_price, 0, ',', '.') }} VND</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sale-hotel">{{ number_format($hotel->average_discount_percent) }} %</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <button class="prev-btn"><i class="fa-solid fa-arrow-right"></i></button>
                <button class="next-btn"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </section>
    <!-- Back to Top Button -->
    <button id="backToTopBtn" class="back-to-top" title="Back to Top">↑</button>

    <script>
        // Carousel functionality
        document.querySelectorAll('.carousel-wrapper').forEach((carousel) => {
            const cards = carousel.querySelectorAll('.card');
            const nextBtn = carousel.closest('.carousel-container').querySelector('.next-btn');
            const prevBtn = carousel.closest('.carousel-container').querySelector('.prev-btn');
            let index = 0;
            const visibleCards = 4; // Number of cards visible at a time

            function updateCarousel() {
                if (cards.length === 0) return; // Prevent errors if no cards

                const cardWidth = cards[0].clientWidth;
                carousel.style.transform = `translateX(${-index * cardWidth}px)`;

                // Toggle visibility of buttons based on position
                prevBtn && prevBtn.classList.toggle('hidden', index === 0);
                nextBtn && nextBtn.classList.toggle('hidden', index >= cards.length - visibleCards);
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    if (index < cards.length - visibleCards) {
                        index++;
                        updateCarousel();
                    }
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    if (index > 0) {
                        index--;
                        updateCarousel();
                    }
                });
            }

            window.addEventListener('resize', updateCarousel);
            updateCarousel(); // Initial call
        });

        // Xử Lý Nút Back to top 
        const backToTopBtn = document.getElementById("backToTopBtn");
        if (backToTopBtn) {
            window.addEventListener("scroll", () => {
                backToTopBtn.classList.toggle("visible", window.scrollY > 300);
            });

            backToTopBtn.addEventListener("click", () => {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            });
        }
        document.getElementById('notificationBell').addEventListener('click', function() {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        });

        // Optional: Close the dropdown if clicking outside of it
        document.addEventListener('click', function(event) {
            const bell = document.getElementById('notificationBell');
            const dropdown = document.getElementById('notificationDropdown');
            if (!bell.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });
        $(document).ready(function() {
    $('.heart-icon').on('click', function(event) {
        event.preventDefault(); 
        const heart = $(this).find('i');
        const hotelId = $(this).data('hotel-id'); 

        // Kiểm tra trạng thái yêu thích để xác định phương thức
        const isFavorite = heart.hasClass('fa-solid'); 

        // Gửi yêu cầu AJAX để thêm hoặc xóa khách sạn khỏi danh sách yêu thích
        $.ajax({
            url: '/favorites',
            method: isFavorite ? 'DELETE' : 'POST', 
            data: {
                hotel_id: hotelId,
                _token: '{{ csrf_token() }}' 
            },
            success: function(response) {
                // Cập nhật lại trạng thái của biểu tượng trái tim
                if (isFavorite) {
                    // Nếu khách sạn đã yêu thích, xóa khỏi yêu thích và đổi lại màu tim
                    heart.removeClass('fa-solid red').addClass('fa-regular');
                } else {
                    // Nếu chưa yêu thích, thêm vào yêu thích và đổi màu tim
                    heart.removeClass('fa-regular').addClass('fa-solid red');
                }
                alert(response.message); 
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message || 'Đã xảy ra lỗi.'); 
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.city-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                fetch('{{ route('hotels.all') }}')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        updateHotelList(data.hotels);
                    })
                    .catch(error => console.error('Error:', error));
                return;
            }

            document.querySelectorAll('.city-btn').forEach(function(btn) {
                btn.classList.remove('selected');
            });

            this.classList.add('selected');

            var cityId = this.getAttribute('data-city-id');

            if (cityId) {
                let url = '{{ route('hotels.filter') }}?city_id=' + cityId;

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        updateHotelList(data.hotels);
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                console.error('City ID is not defined.');
            }
        });
    });
});

function updateHotelList(hotels) {
    console.log('Hotels data received:', hotels);
    const hotelContainer = document.querySelector('.carousel-wrapper2');
    hotelContainer.innerHTML = '';

    if (hotels.length === 0) {
        hotelContainer.innerHTML = '<p>Không có khách sạn nào được tìm thấy.</p>';
        return;
    }

    hotels.forEach(hotel => {
        const hotelCard = document.createElement('div');
        hotelCard.classList.add('card');
        hotelCard.innerHTML = `
            <a href="#" class="group-offers">
                <div class="shape-in">
                    <img class="image-hotel-2" src="${hotel.image_url}" alt="">
                    <div class="group-info-hotel">
                        <p class="info-hotel-name m-0">${hotel.hotel_name}</p>
                        <p class="info-hotel-location m-0">${hotel.location}, ${hotel.city}</p>
                        <p class="info-hotel-reviews m-0"><i class="fa-regular fa-comment"></i>${hotel.reviews} Đánh giá</p>
                        <p class="info-hotel-price-old mb-0 mt-5 pt-5">${hotel.old_price} VND</p>
                        <div class="row group-heart-price">
                            <div class="col-md-6">
                                <a href="#" class="heart-icon" data-hotel-id="${hotel.hotel_id}">
                                    <i class="fa-regular fa-heart ${hotel.is_favorite ? 'fa-solid red' : ''}"></i>
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <span class="info-hotel-price-new">${hotel.new_price} VND</span>
                            </div>
                        </div>
                    </div>
                    <div class="sale-hotel">${hotel.discount_percent} %</div>
                </div>
            </a>
        `;
        hotelContainer.appendChild(hotelCard);
    });
}

    </script>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

{{-- Link File JS --}}
@section('js')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection