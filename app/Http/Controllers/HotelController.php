<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Cities;
use App\Models\HotelImages;
use App\Models\HotelAmenities;
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
        $hotels = Hotel::with(['images', 'city'])->paginate(5);
        return view('admin.hotel', compact('hotels'));
    }

    public function create()
    {
        // Lấy tất cả các thành phố từ bảng cities
        $cities = Cities::all(); // Giả sử bạn đã khai báo model Cities
    
        // Lấy tất cả các tiện nghi từ bảng hotel_amenities
        $hotelAmenities = HotelAmenities::all(); // Giả sử bạn đã khai báo model HotelAmenity
    
        // Truyền cả $cities và $hotelAmenities vào view
        return view('admin.hotel_add', compact('cities', 'hotelAmenities'));
    }    

    public function getHotelDetail($hotel_id)
    {
        $hotel = Hotel::findHotelById($hotel_id);

        if (!$hotel) {
            return response()->json(['error' => 'Khách sạn không tồn tại'], 404);
        }

        // Lấy URL hình ảnh
        $images = $hotel->images->map(function ($image) {
            if (file_exists(public_path('images/' . $image->image_url))) {
                return asset('images/' . $image->image_url);
            } elseif (file_exists(public_path('storage/images/' . $image->image_url))) {
                return asset('storage/images/' . $image->image_url);
            } else {
                return asset('images/img-upload.jpg'); // Hình ảnh mặc định
            }
        });

        $amenities = $hotel->amenities->map(function ($amenity) {
            return [
                'name' => $amenity->amenity_name,
                'description' => $amenity->description,
            ];
        });

        return response()->json([
            'hotel_name' => $hotel->hotel_name,
            'location' => $hotel->location,
            'city_id' => $hotel->city->city_name ?? 'N/A',
            'description' => $hotel->description,
            'rating' => $hotel->rating,
            'images' => $images, // Danh sách URL hình ảnh
            'amenities' => $amenities,
        ]);
    }

    public function store(Request $request) 
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'hotel_name' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'location' => 'required|string|max:255',
            'city_id' => 'required|integer',
            'description' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'amenities' => 'nullable|array',
            'amenities.*' => 'integer|exists:hotel_amenities,amenity_id',
        ], [
            // Các thông báo lỗi
        ]);

        // Tạo khách sạn mới
        $hotel = Hotel::create([
            'hotel_name' => $request->hotel_name,
            'location' => $request->location,
            'city_id' => $request->city_id,
            'description' => $request->description,
            'rating' => $request->rating,
        ]);

        // Lưu ảnh vào bảng hotel_images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);

                HotelImages::create([
                    'hotel_id' => $hotel->hotel_id,
                    'image_url' => $imageName,
                ]);
            }
        }

       // Lưu tiện nghi khách sạn
        if ($request->has('amenities')) {
            foreach ($request->amenities as $amenityId) {
                // Tìm tiện nghi dựa trên amenity_id
                $amenity = HotelAmenities::find($amenityId);

                // Kiểm tra nếu tiện nghi tồn tại
                if ($amenity) {
                    // Tạo bản ghi mới với description chính xác
                    HotelAmenities::create([
                        'hotel_id' => $hotel->hotel_id,
                        'amenity_id' => $amenityId,
                        'amenity_name' => $amenity->amenity_name,
                        'description' => $amenity->description, // Lấy description từ chính bản ghi tiện nghi
                    ]);
                }
            }
        }

        

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
        $hotels = Hotel::searchHotel($keyword)->paginate(5);

        return view('admin.search_results_hotel', compact('hotels'));
    }

    public function editHotel($hotel_id)
    {
        $hotel = Hotel::findOrFail($hotel_id);
        $cities = Cities::all(); // Lấy tất cả thành phố để sử dụng trong dropdown
        return view('admin.hotel_edit', compact('hotel', 'cities'));
    }

    public function update(Request $request, $hotel_id)
    {
        $request->validate([
            'hotel_name' => 'required|string|max:255|regex:/^[^\_]+$/',
            'location' => 'required|string|max:255',
            'city_id' => 'required|integer',
            'description' => 'required|string|min:20|max:8000',
            'rating' => 'nullable|numeric|min:1|max:5',
        ]);

        $hotel = Hotel::find($hotel_id);
        if (!$hotel) {
            return redirect()->route('admin.viewhotel')->with('error', 'Khách sạn không tồn tại.');
        }

        $hotel->update($request->all());

        return redirect()->route('admin.viewhotel')->with('success', 'Cập nhật khách sạn thành công.');
    }


}
// 