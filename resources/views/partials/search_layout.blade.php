@extends('layouts.app')

@section('search-bar')
<section class="middle-staynest d-flex justify-content-center">
    <div class="search-bar-staynest color-light container">
        <div class="title-search-label row">
            <div class="col-md-3">Địa điểm</div>
            <div class="col-md-3">Số đêm</div>
            <div class="col-md-4">Số người, số phòng</div>
        </div>
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
                    <input class="datepicker-staynest form-control ms-2" type="text" name="daterange"
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
                            <input type="text" class="value-people" id="adults" name="adults"
                                value="{{ session('adults', 1) }}" readonly>
                            <button type="button" class="increment-adult">+</button>
                        </div>
                    </div>

                    <div class="item">
                        <span>Phòng</span>
                        <div class="counter">
                            <button type="button" class="decrement-room">-</button>
                            <input type="text" class="value-people" id="rooms" name="rooms"
                                value="{{ session('rooms', 1) }}" readonly>
                            <button type="button" class="increment-room">+</button>
                        </div>
                    </div>

                    <div class="item">
                        <span>Trẻ em</span>
                        <div class="counter">
                            <button type="button" class="decrement-children">-</button>
                            <input type="text" class="value-people" id="children" name="children"
                                value="{{ session('children', 0) }}" readonly>
                            <button type="button" class="increment-children">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 button-search-header">
                <button type="submit">
                    Tìm Khách Sạn
                    <i class="fa-solid fa-magnifying-glass ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/animation.js') }}"></script>
<script src="{{ asset('js/counter_control.js') }}"></script>