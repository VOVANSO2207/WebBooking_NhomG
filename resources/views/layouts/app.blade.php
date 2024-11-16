<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayNest</title>
    <link rel="icon" type="image/" href="{{asset('images/logo-staynest.jpg')}}">
    {{--
    <link rel="stylesheet" href="{{asset('css/search_result.css')}}"> --}}
    @yield('css')
    {{--
    <link rel="stylesheet" href="{{asset('css/login.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Gắn Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!--  -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/animation.js') }}"></script>
    <script src="{{ asset('js/counter_control.js') }}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- Google Fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: "Roboto Condensed", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
        }

        /* Back to Top Button Styling */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #007bff, #5bc0de);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 20px;
            cursor: pointer;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease, visibility 0.4s ease, transform 0.3s ease;
            transform: scale(1.1);
        }

        .back-to-top.visible {
            opacity: 1;
            pointer-events: auto;
            transform: scale(1);
        }

        .back-to-top:hover {
            background: linear-gradient(135deg, #0056b3, #2ca8d1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
            transform: scale(1.1);
        }
    </style>
</head>

<body>


    @yield('header')
    @yield('search-bar')

    <!-- content page home -->
    <div class="content">
        @yield('content')
        <!-- Back to Top Button -->

        <button id="backToTopBtn" class="back-to-top" title="Back to Top">↑</button>

        @yield('view-search')

    </div>

    <!-- footer -->
    @yield('footer')
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
    </script>
    @yield('js')
    {{--
    <script src="{{asset('js/search_result.js')}}"></script> --}}
</body>

</html>
