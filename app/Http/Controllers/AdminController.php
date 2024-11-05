<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteVisit;
use App\Models\Posts;
use App\Models\Hotel;
use App\Models\Booking; // Đảm bảo bạn đã import Booking model

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Tăng lượt truy cập cho tất cả các trang mà không cần kiểm tra URL
        $visitDate = date('Y-m-d');
        $websiteVisit = WebsiteVisit::where('visit_date', $visitDate)->first();

        if ($websiteVisit) {
            $websiteVisit->increment('count');
        } else {
            WebsiteVisit::create(['visit_date' => $visitDate, 'count' => 1]);
        }

        // Xử lý dữ liệu thống kê
        $selectedYear = $request->input('year', date('Y'));

        // Lấy dữ liệu lượt truy cập
        $visits = WebsiteVisit::selectRaw('DATE_FORMAT(visit_date, "%Y") as year, DATE_FORMAT(visit_date, "%m") as month, SUM(count) as total')
            ->whereYear('visit_date', $selectedYear)
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'asc')
            ->get();

        $data = [
            ['Tháng', 'Lượt truy cập'],
        ];
        foreach ($visits as $visit) {
            $data[] = [$visit->year . '-' . $visit->month, (int)$visit->total];
        }

        $totalVisitors = $visits->sum('total');
        $postCount = Posts::count();
        $hotelCount = Hotel::count();
        $years = WebsiteVisit::selectRaw('DATE_FORMAT(visit_date, "%Y") as year')
            ->groupBy('year')
            ->pluck('year')
            ->toArray();

        // Lấy dữ liệu doanh thu theo tháng
        $revenueData = $this->getRevenueData($selectedYear);

        // Lấy danh sách các năm có dữ liệu doanh thu từ bảng Booking
        $revenueYears = Booking::selectRaw('YEAR(check_in) as year')
        ->where('status', 'confirmed')
        ->groupBy('year')
        ->pluck('year')
        ->toArray();

        // Trả về view với dữ liệu tổng hợp
        return view('admin.index', compact('data', 'years', 'selectedYear', 'totalVisitors', 'postCount', 'hotelCount', 'revenueData', 'revenueYears'));
    }

    private function getRevenueData($year)
    {
        $revenue = Booking::selectRaw('DATE_FORMAT(check_in, "%Y") as year, DATE_FORMAT(check_in, "%m") as month, SUM(total_price) as total')
            ->whereYear('check_in', $year)
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'asc')
            ->get();

        $data = [
            ['Tháng', 'Doanh thu'],
        ];
        foreach ($revenue as $rev) {
            $data[] = [$rev->year . '-' . $rev->month, (float)$rev->total];
        }

        return $data;
    }
}
