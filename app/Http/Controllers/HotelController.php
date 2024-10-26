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

    public function viewHotel()
    {
        $hotels = Hotel::getAllHotels();
        return view('admin.hotel', compact('hotels'));
    }

    public function create()
    {
        return view('admin.hotel_add');
    }

    public function getHotelDetail($hotel_id)
    {
        $hotel = Hotel::findHotelById($hotel_id);

        if (!$hotel) {
            return response()->json(['error' => 'Khách sạn không tồn tại'], 404);
        }

        return response()->json([
            'hotel_name' => $hotel->hotel_name,
            'location' => $hotel->location,
            'city_id' => $hotel->city_id,
            'description' => $hotel->description,
            'rating' => $hotel->rating,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'hotel_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city_id' => 'required|integer',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        Hotel::createHotel($request->all());

        return redirect()->route('admin.viewhotel')->with('success', 'Thêm khách sạn thành công.');
    }

    public function deleteHotel($hotel_id)
    {
        $hotel = Hotel::find($hotel_id);
        if ($hotel) {
            $hotel->delete();
            return response()->json(['success' => true, 'message' => 'Khách sạn đã được xóa.']);
        }

        return response()->json(['success' => false, 'message' => 'Khách sạn không tồn tại.'], 404);
    }

    public function searchAdminHotel(Request $request)
    {
        $keyword = $request->get('search');
        $results = Hotel::searchHotel($keyword)->paginate(5);

        return view('admin.search_results_hotel', compact('results'));
    }

    public function editHotel($hotel_id)
    {
        $hotel = Hotel::findOrFail($hotel_id);
        return view('admin.hotel_edit', compact('hotel'));
    }

    public function update(Request $request, $hotel_id)
    {
        $request->validate([
            'hotel_name' => 'required|string|max:255|:hotels,hotel_name,' . $hotel_id . ',hotel_id',
            'location' => 'required|string|max:255',
            'city_id' => 'required|integer',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $hotel = Hotel::find($hotel_id);
        if (!$hotel) {
            return redirect()->route('admin.viewhotel')->with('error', 'Khách sạn không tồn tại.');
        }

        $hotel->update($request->all());

        return redirect()->route('admin.viewhotel')->with('success', 'Cập nhật khách sạn thành công.');
    }

}
