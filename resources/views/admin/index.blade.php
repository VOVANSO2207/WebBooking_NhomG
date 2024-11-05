@extends('admin.layouts.master')

@section('admin-container')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-md-8">
                            <div class="welcome-message">
                                <h1>CHÀO MỪNG BẠN ĐẾN TRANG QUẢN TRỊ STAYNEST</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/images/img-blog.jpg')}}" class="rounded" />
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1" style="font-size: 20px">BLOG</span>
                                <small class="text-success fw-semibold" style="font-size: 30px">{{$postCount}}</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/images/img-hotel.jpg')}}" class="rounded" />
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1" style="font-size: 20px">HOTEL</span>
                                <small class="text-success fw-semibold" style="font-size: 30px">{{$hotelCount}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ lượt truy cập -->
            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                <div class="content-wrapper">
                    <div class="container-fluid">
                        <!-- Biểu đồ lượt truy cập -->
                        <div class="card mb-4">
                            <div class="card-header" style="color: #fff;font-size: 20px;">
                                Biểu đồ lượt truy cập theo tháng
                            </div>
                            <div class="card-body">
                                <div id="visitsChart" style="height: 300px;"></div>
                            </div>
                        </div>
                        <!-- Nút phân trang theo năm cho lượt truy cập -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div>
                                    @foreach ($years as $year)
                                        <a style="background: #3B79C9" href="{{ route('admin.index', ['year' => $year]) }}"
                                            class="btn btn-primary @if ($selectedYear == $year) active @endif">{{ $year }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Biểu đồ lượt truy cập -->

            <!-- Biểu đồ doanh thu -->
            <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div
                                        class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">Tổng Lượt Truy Cập Web</h5>
                                            <span class="badge bg-label-warning rounded-pill">{{$totalVisitors}}</span>
                                        </div>
                                    </div>
                                    <div id="profileReportChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
   
        </div>

        <!-- Biểu đồ doanh thu -->
        <div class="card mb-4">
            <div class="card-header" style="color: #fff;font-size: 20px;">
                Biểu đồ doanh thu theo tháng
            </div>
            <div class="card-body">
                <div id="revenueChart" style="height: 300px;"></div> 
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div>
                    @foreach ($revenueYears as $year)
                        <a style="background: #3B79C9" href="{{ route('admin.index', ['year' => $year]) }}"
                            class="btn btn-primary @if ($selectedYear == $year) active @endif">{{ $year }}</a>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(function () {
        drawChart();
        drawRevenueChart();
    });

    function drawChart() {
        var data = google.visualization.arrayToDataTable(@json($data));

        var options = {
            title: 'Biểu đồ lượt truy cập theo tháng',
            legend: { position: 'bottom' },
            chartArea: { width: '80%', height: '70%' },
            isStacked: true,
            vAxis: { minValue: 0 },
            areaOpacity: 0.7,
            colors: ['#3B79C9']
        };

        var chart = new google.visualization.AreaChart(document.getElementById('visitsChart'));
        chart.draw(data, options);
    }

    function drawRevenueChart() {
        var revenueData = google.visualization.arrayToDataTable(@json($revenueData));

        var options = {
            title: 'Biểu đồ doanh thu theo tháng',
            legend: { position: 'bottom' },
            chartArea: { width: '80%', height: '70%' },
            isStacked: true,
            vAxis: { minValue: 0 },
            areaOpacity: 0.7,
            colors: ['#3B79C9']
        };

        var chart = new google.visualization.AreaChart(document.getElementById('revenueChart'));
        chart.draw(revenueData, options);
    }
</script>

</div>
@endsection