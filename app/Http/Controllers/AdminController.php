<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteVisit;
use App\Models\Posts;
use App\Models\Hotel;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $this->trackWebsiteVisit(date('Y-m-d'));


        return $this->showVisitsChart($request);
    }

    public function showVisitsChart(Request $request)
    {
        $selectedYear = $request->input('year', date('Y'));

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
            $data[] = [$visit->year . '-' . $visit->month, (int) $visit->total];
        }
        $totalVisitors = $visits->sum('total');
        $postCount = Posts::count();

        $hotelCount = Hotel::count();
        $years = WebsiteVisit::selectRaw('DATE_FORMAT(visit_date, "%Y") as year')
            ->groupBy('year')
            ->pluck('year')
            ->toArray();

        return view('admin.index', compact('data', 'years', 'selectedYear', 'totalVisitors', 'postCount', 'hotelCount'));
    }

    private function trackWebsiteVisit($visitDate)
    {
        $websiteVisit = WebsiteVisit::where('visit_date', $visitDate)->first();

        if ($websiteVisit) {
            $websiteVisit->increment('count');
        } else {
            WebsiteVisit::create(['visit_date' => $visitDate, 'count' => 1]);
        }
    }
}
