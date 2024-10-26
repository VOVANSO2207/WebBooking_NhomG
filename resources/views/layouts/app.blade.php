<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    {{-- <link rel="stylesheet" href="{{asset('css/search_result.css')}}"> --}}
    @yield('css')
    {{-- <link rel="stylesheet" href="{{asset('css/login.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('css/register.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Gắn Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!--  -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/animation.js') }}"></script>
    <script src="{{ asset('js/counter_control.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

</head>

<body>
   
    
    @yield('header')

    <!-- content page home -->
    <div class="content">
        @yield('content')
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
      @yield('js')
     {{-- <script src="{{asset('js/search_result.js')}}"></script> --}}
</body>

</html>