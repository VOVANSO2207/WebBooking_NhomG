<link rel="stylesheet" href="{{ asset('css/footer.css') }}">
<footer class="footer-f bg-light py-4">
    <div class="container f-">
        <div class="row">
            <!-- Logo Section -->
            <div class="col-lg-3 col-md-12 text-center mb-3">
                <img src="{{ asset('/images/logo-staynest.jpg') }}" alt="" width="200px">
            </div>

            <!-- Introduction Section -->
            <div class="col-lg-3 col-md-4 mb-3 introduction">
                <h5 class="text-muted">GIỚI THIỆU</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Về chúng tôi</a></li>
                    <li class="mb-4"><a href="#">Hình thức thanh toán</a></li>
                    <h5 class="text-muted">LIÊN HỆ</h5>
                    <li><a href="#">Hotline: 087 717 177 78</a></li>
                    <li><a href="#">Email: info@hotelease.com</a></li>
                </ul>
            </div>

            <!-- Hotel Locations Section -->
            <div class="col-lg-3 col-md-4 mb-3">
                <h5 class="text-muted">ĐIỂM KHÁCH SẠN</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Thành Phố Hồ Chí Minh</a></li>
                    <li><a href="#">Đà Lạt</a></li>
                    <li><a href="#">Vũng Tàu</a></li>
                    <li><a href="#">Đà Nẵng</a></li>
                    <li><a href="#">Hà Nội</a></li>
                    <li><a href="#">Cà Mau</a></li>
                </ul>
            </div>

            <!-- Other Links Section -->
            <div class="col-lg-3 col-md-4 mb-3">
                <h5 class="text-muted">KHÁC</h5>
                <ul class="list-unstyled">
                    <li><a href="{{route(name: 'blog')}}">Tin tức</a></li>
                    <li><a href="{{route(name: 'contact')}}">Liên hệ</a></li>
                </ul>
                <h5 class="text-muted mt-3">MẠNG XÃ HỘI</h5>
                <div class="social-links">
                    <a href="#" class="me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="me-2"><i class="fab fa-x"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>