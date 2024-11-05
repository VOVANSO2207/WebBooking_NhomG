<?php

namespace App\Http\Controllers;
use App\Helpers\IdEncoder;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Cities;
use App\Models\HotelImages;
use App\Models\HotelAmenities;
use App\Models\HotelAmenityHotel;
use App\Models\Rooms;
class HotelController extends Controller
{
    //
    public function viewSearchHotel()
    {
        // Lấy tất cả các hotels từ cơ sở dữ liệu
        $hotels = Hotel::with('images')->get();

        // Truyền dữ liệu qua view
        return view('search_result', compact('hotels'));
    }
    public function index()
    {
        // Lấy tất cả các hotels từ cơ sở dữ liệu
        $hotels = Hotel::all();

        // Truyền dữ liệu qua view
        return view('pages.home', compact('hotels'));
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
        // Lấy tất cả các thành phố từ bảng cities
        $cities = Cities::all(); // Giả sử bạn đã khai báo model Cities

        // Lấy tất cả các tiện nghi từ bảng hotel_amenities
        $hotelAmenities = HotelAmenities::all(); // Giả sử bạn đã khai báo model HotelAmenities

        // Lấy tất cả các phòng từ bảng hotel_rooms
        $hotelRooms = Rooms::all(); // Giả sử bạn đã khai báo model HotelRoom

        // Truyền cả $cities, $hotelAmenities và $hotelRooms vào view
        return view('admin.hotel_add', compact('cities', 'hotelAmenities', 'hotelRooms'));
    }

    public function getHotelDetail($hotel_id) 
    {
        $decodedId = IdEncoder::decodeId($hotel_id);
        $hotel = Hotel::with(['images', 'amenities', 'city', 'rooms'])->find($decodedId); // Thêm 'rooms' vào here
    
        if (!$hotel) {
            return response()->json(['error' => 'Khách sạn không tồn tại'], 404);
        }
    
       // Lấy URL hình ảnh
        $images = $hotel->images->map(function ($image) {
            $imagePath = public_path('images/' . $image->image_url);
            if (file_exists($imagePath)) {
                return asset('images/' . $image->image_url);
            } else {
                return asset('images/img-upload.jpg'); // Hình ảnh mặc định
            }
        });
            
        // Lấy amenities từ bảng hotel_amenity_hotel
        $amenities = $hotel->amenities->map(function ($amenity) {
            return [
                'name' => $amenity->amenity_name,
                'description' => $amenity->description,
            ];
        });
    
        // Lấy thông tin phòng
        $rooms = $hotel->rooms->map(function ($room) {
            return [
                'room_name' => $room->name,
                'price' => $room->price,
            ];
        });
    
        return response()->json([
            'hotel_name' => $hotel->hotel_name,
            'location' => $hotel->location,
            'city' => $hotel->city->city_name ?? 'N/A',
            'description' => $hotel->description,
            'rating' => $hotel->rating,
            'images' => $images, // Danh sách URL hình ảnh
            'amenities' => $amenities, // Danh sách amenities
            'rooms' => $rooms, // Danh sách phòng
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
            'rating' => 'nullable|between:1,5',
            'images' => 'required|nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'amenities' => 'nullable|array',
            'amenities.*' => 'integer|exists:hotel_amenities,amenity_id',
            'rooms' => 'nullable|array', // Thêm rooms vào xác thực nếu cần
            'rooms.*' => 'integer|exists:rooms,room_id', // Đảm bảo các room_id tồn tại
        ], [
            // Các thông báo lỗi có thể tùy chỉnh tại đây
        ]);

        // Tạo khách sạn mới
        $hotel = Hotel::create([
            'hotel_name' => $request->hotel_name,
            'location' => $request->location,
            'city_id' => $request->city_id,
            'description' => $request->description,
            'rating' => $request->rating,
        ]);
    
        // Lấy hotel_id vừa được tạo
        $hotelId = $hotel->hotel_id;

        // Lưu hình ảnh liên quan đến khách sạn
        foreach ($request->file('images') as $image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);

            // Lưu hình ảnh vào bảng hotel_images với hotel_id
            HotelImages::create([
                'image_url' => $imageName,
                'hotel_id' => $hotelId, // Sử dụng hotel_id đã lấy
            ]);
        }

        // Lưu tiện nghi khách sạn
        if ($request->has('amenities')) {
            foreach ($request->amenities as $amenityId) {
                $amenity = HotelAmenities::find($amenityId);
                if ($amenity) {
                    HotelAmenityHotel::create([
                        'hotel_id' => $hotel->hotel_id,
                        'amenity_id' => $amenityId,
                    ]);
                }
            }
        }

        // Gán hotel_id cho các phòng được chọn
        if ($request->has('rooms')) {
            foreach ($request->rooms as $roomId) {
                // Cập nhật hotel_id cho từng phòng
                $room = Rooms::find($roomId);
                if ($room) {
                    $room->hotel_id = $hotel->hotel_id;
                    $room->save();
                }
            }
        }

        return redirect()->route('admin.viewhotel')->with('success', 'Thêm khách sạn thành công.');
    }

    public function deleteHotel($hotel_id)
    {
        $decodedId = IdEncoder::decodeId($hotel_id);
        $hotel = Hotel::find($decodedId);
    
        if ($hotel) {
            // Xóa khách sạn mà không xóa các phòng, hình ảnh hay tiện nghi
            $hotel->delete();
    
            return response()->json(['success' => true, 'message' => 'Khách sạn đã được xóa.']);
        }
    
        return response()->json(['success' => false, 'message' => 'Khách sạn không tồn tại.'], 404);
    }
    

    public function searchAdminHotel(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ request
        $keyword = $request->get('search');
    
        // Kiểm tra nếu từ khóa tìm kiếm rỗng, hiển thị tất cả kết quả
        if (empty($keyword)) {
            $hotels = Hotel::getAllHotels();
        } else {
            // Thực hiện tìm kiếm toàn văn trên các trường name và description
            $hotels = Hotel::whereRaw('MATCH(hotel_name, description) AGAINST(? IN BOOLEAN MODE)', [$keyword])
                ->paginate(5);
        }
    
        // Trả về view với kết quả tìm kiếm
        return view('admin.search_results_hotel', compact('hotels'));
    }
    

    public function editHotel($hotel_id)
    {
        $decodedId = IdEncoder::decodeId($hotel_id);
        $hotel = Hotel::find($decodedId);

        $cities = Cities::all();
        $hotelAmenities = HotelAmenities::all(); // Lấy tất cả tiện nghi
        $currentAmenities = $hotel->amenities()->pluck('amenity_id')->toArray(); // Lấy các tiện nghi hiện tại của khách sạn

        // Lấy tất cả các phòng
        $rooms = Rooms::all(); // Lấy tất cả phòng, không chỉ phòng của khách sạn cụ thể
        $currentRooms = $hotel->rooms()->pluck('room_id')->toArray(); // Lấy các phòng hiện tại của khách sạn

        return view('admin.hotel_edit', compact('hotel', 'cities', 'hotelAmenities', 'currentAmenities', 'rooms', 'currentRooms'));
    }

    public function update(Request $request, $hotel_id)
    {
        $validatedData = $request->validate([
            'hotel_name' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'location' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:cities,city_id',
            'description' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        $hotel = Hotel::find($hotel_id);

        if (!$hotel) {
            return redirect()->route('admin.viewhotel')->with('error', 'Khách sạn không tồn tại.');
        }

        $hotel->update([
            'hotel_name' => $validatedData['hotel_name'],
            'location' => $validatedData['location'],
            'city_id' => $validatedData['city_id'],
            'description' => $validatedData['description'],
            'rating' => $validatedData['rating'],
        ]);

        // Xử lý tiện nghi
        if ($request->has('amenities') && is_array($request->input('amenities'))) {
            $validatedData['amenities'] = $request->input('amenities'); // Lưu amenities vào validatedData
            \Log::info('Processing amenities: ', [$validatedData['amenities']]);

            $currentAmenities = $hotel->amenities()->pluck('amenity_id')->toArray();

            // Xóa những tiện nghi không còn được chọn
            foreach (array_diff($currentAmenities, $validatedData['amenities']) as $amenityId) {
                // Detach tiện nghi khỏi khách sạn
                $hotel->amenities()->detach($amenityId);

                \Log::info('Detached amenity: ' . $amenityId);
            }

            // Thêm những tiện nghi mới nếu chưa có trong danh sách
            foreach ($validatedData['amenities'] as $amenityId) {
                if (!in_array($amenityId, $currentAmenities)) {
                    // Thêm tiện nghi mới vào khách sạn
                    $hotel->amenities()->attach($amenityId);
                    \Log::info('Attached amenity: ' . $amenityId);
                }
            }
        }

// Kiểm tra và lưu hình ảnh
if ($request->hasFile('images')) {
    // Lấy danh sách hình ảnh hiện tại
    $existingImages = $hotel->images()->pluck('image_id')->toArray();

    // Xóa hình ảnh không còn được chọn
    foreach ($existingImages as $imageId) {
        // Nếu hình ảnh không có trong danh sách mới, xóa
        if (!in_array($imageId, $request->input('existing_image_ids', []))) {
            $imageToDelete = HotelImages::where('image_id', $imageId)->first();
            if ($imageToDelete) {
                // Xóa tệp hình ảnh trong thư mục
                $imagePath = public_path('images/' . $imageToDelete->image_url);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                // Xóa hình ảnh khỏi cơ sở dữ liệu
                $imageToDelete->delete();
            }
        }
    }

    // Lưu hình ảnh mới
    foreach ($request->file('images') as $image) {
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);

        HotelImages::create([
            'hotel_id' => $hotel->hotel_id,
            'image_url' => $imageName,
        ]);
    }
}

        if ($request->has('rooms')) {
            $existingRooms = $hotel->rooms()->pluck('room_id')->toArray();
            $selectedRooms = $request->rooms;

            Rooms::whereIn('room_id', $existingRooms)
                ->whereNotIn('room_id', $selectedRooms)
                ->update(['hotel_id' => 0]);

            foreach ($selectedRooms as $roomId) {
                Rooms::where('room_id', $roomId)->update(['hotel_id' => $hotel->hotel_id]);
            }
        }

        return redirect()->route('admin.viewhotel')->with('success', 'Cập nhật khách sạn thành công.');
    }

    public function encodeId($id)
    {
        $encodedId = IdEncoder::encodeId($id);
        return response()->json(['encoded_id' => $encodedId]);
    }

    public function decodeId($encodedId)
    {
        $decodedId = IdEncoder::decodeId($encodedId);
        return response()->json(['decoded_id' => $decodedId]);
    }
}
// 