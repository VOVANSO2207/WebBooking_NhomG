@extends('layouts.app')
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
@section('search-bar')
<section class="middle-staynest d-flex justify-content-center">
    <div class="search-bar-staynest color-light container">
        <form action="{{ route('hotels.search') }}" method="GET" class="row">
            @csrf
            <div class="col-md-3 search-header">
                <div class="form-group">
                    <select name="location" class="form-control-staynest select2" style="width: 100%;" tabindex="-1"
                        aria-hidden="true" required>
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
                            <input type="text" class="value-people" id="children" name="children" value="0" readonly>
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
</section>
@endsection
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