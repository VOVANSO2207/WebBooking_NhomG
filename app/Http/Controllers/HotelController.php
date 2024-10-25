<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;

class HotelController extends Controller
{
    //
    public function index()
    {
        // Lấy tất cả các hotels từ cơ sở dữ liệu
        $hotels = Hotel::with('images')->get();

        // Truyền dữ liệu qua view
        return view('search_result', compact('hotels'));
    }

    public function search(Request $request)
    {
        // Lấy các giá trị từ request (GET parameters)
        $location = $request->input('location');
        $daterange = $request->input('daterange');
        $rooms = $request->input('rooms');
        $adults = $request->input('adults');
        $children = $request->input('children');

        // Tách ngày đi và ngày về từ daterange
        $dates = explode(' - ', $daterange);
        $check_in = isset($dates[0]) ? \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[0])) : null;
        $check_out = isset($dates[1]) ? \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[1])) : null;

        // Xây dựng query lọc theo location và các tiêu chí khác (ví dụ: số lượng phòng, người lớn, trẻ em)
        $query = Hotel::query();

        if ($location) {
            $query->where('city_id', $location);
        }

        // Nếu có thêm điều kiện lọc ngày check-in và check-out
        // có thể cần sửa lại nếu có thêm thông tin ngày lưu trữ trong bảng hotels

        // Lọc các tiêu chí khác (nếu có)
        // Ví dụ: số phòng, số người lớn, số trẻ em

        // Thực hiện query
        $hotels = $query->get();

        // Trả dữ liệu về trang search_result
        return view('search_result', compact('hotels', 'location', 'daterange', 'rooms', 'adults', 'children'));
    }
}
