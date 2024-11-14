@extends('layouts.app')
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/animation.js') }}"></script>
<script src="{{ asset('js/counter_control.js') }}"></script>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->
@section('search-bar')
<section class="middle-staynest d-flex justify-content-center">
    <div class="search-bar-staynest color-light container">
        <form action="{{ route('hotels.search') }}" method="GET" class="row">
            @csrf
            <div class="col-md-3 search-header">
                <div class="form-group">
                    <select name="location" class="form-control-staynest select2 p-3" style="width: 100%;" tabindex="-1"
                        aria-hidden="true" required>
                        @if ($cities->isEmpty())
                            <option value="">Chưa có địa điểm hiển thị</option>
                        @else
                            @foreach ($cities as $citie)
                                <option value="{{ $citie->city_id }}"
                                    {{ session('location') == $citie->city_id ? 'selected' : '' }}>
                                    {{ $citie->city_name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="date-picker-search border">
                    <i class="fa-regular fa-calendar-days ps-2"></i>
                    <input class="datepicker-staynest form-control p-0 ms-2" type="text" name="daterange"
                        value="{{ session('daterange', '') }}" readonly />
                </div>
            </div>
            <div class="col-md-4">
                <div class="num-people border">
                    <!-- <label class="small-text">Số người</label> -->
                    <div class="number">
                        <span id="people-summary">{{ session('adults', 1) }} người lớn, </span>
                        <span id="room-summary">{{ session('rooms', 1) }} phòng, </span>
                        <span id="children-summary">{{ session('children', 0) }} trẻ em</span>
                    </div>
                </div>
                <div class="drop-counter mt-1 bg-light">
                    <div class="item">
                        <span>Người lớn</span>
                        <div class="counter">
                            <button type="button" class="decrement-adult">-</button>
                            <input type="text" class="value-people" id="adults" name="adults" value="{{ session('adults', 1) }}" readonly>
                            <button type="button" class="increment-adult">+</button>
                        </div>
                    </div>

                    <div class="item">
                        <span>Phòng</span>
                        <div class="counter">
                            <button type="button" class="decrement-room">-</button>
                            <input type="text" class="value-people" id="rooms" name="rooms" value="{{ session('rooms', 1) }}" readonly>
                            <button type="button" class="increment-room">+</button>
                        </div>
                    </div>
                   
                    <div class="item">
                        <span>Trẻ em</span>
                        <div class="counter">
                            <button type="button" class="decrement-children">-</button>
                            <input type="text" class="value-people" id="children" name="children" value="{{ session('children', 0) }}" readonly>
                            <button type="button" class="increment-children">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 search-header button-search-header">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding:10px;">Tìm Khách
                    Sạn</button>
            </div>
        </form>
    </div>
</section>
@endsection
<!-- <script>
     // Datepicker
     // Gọi hàm initializeDateRangePicker sau khi trang đã được tải
     function initializeDateRangePicker() {
        // Lấy giá trị daterange từ session nếu có
        const sessionDateRange = "{{ session('daterange') }}";

        let startDate, endDate;

        // Nếu sessionDateRange có giá trị (người dùng đã tìm kiếm trước đó)
        if (sessionDateRange) {
            // Tách start date và end date từ session
            [startDate, endDate] = sessionDateRange.split(' - ');
        } else {
            // Nếu không có, sử dụng ngày mặc định
            startDate = moment().format('DD/MM/YYYY');
            endDate = moment().add(1, 'days').format('DD/MM/YYYY');
        }

         // In ra các giá trị đã lấy từ session để kiểm tra
        console.log("Session Date Range:", sessionDateRange);
        console.log("Start Date:", startDate);
        console.log("End Date:", endDate);

        // Khởi tạo daterangepicker với giá trị startDate và endDate
        $('input[name="daterange"]').daterangepicker({
            startDate: moment(startDate, 'DD/MM/YYYY'),
            endDate: moment(endDate, 'DD/MM/YYYY'),
            minDate: moment(), // Ngày hiện tại không thể nhỏ hơn ngày đi
            opens: 'center',
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        // Cập nhật lại giá trị cho input daterange sau khi datepicker được khởi tạo
        $('input[name="daterange"]').val(startDate + ' - ' + endDate);
    }

    $(document).ready(function () {
        $('.select2').select2(); // Khởi tạo Select2 cho các phần tử select2
        initializeDateRangePicker(); // Khởi tạo Datepicker
    });
</script> -->