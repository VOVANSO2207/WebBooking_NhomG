<?php

namespace App\Http\Controllers;

use App\Helpers\IdEncoder;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Cities;
use App\Models\FavoriteHotel;
use App\Models\HotelImages;
use App\Models\HotelAmenities;
use App\Models\Reviews;
use App\Models\Promotions;
use App\Models\HotelAmenityHotel;
use App\Models\Rooms;
use Carbon\Carbon;

class HotelController extends Controller
{
    //
    public function viewSearchHotel()
    {
        // Lấy tất cả các hotels từ cơ sở dữ liệu
        $hotels = Hotel::with('images')->get();

        // Truyền dữ liệu qua view
        return view('pages.search_result', compact('hotels'));
    }
    public function index()
    {
        // Lấy tất cả các hotels từ cơ sở dữ liệu
        $hotels = Hotel::with('rooms', 'city', 'reviews', 'images')->get();
        $userId = auth()->id();
        // Lấy danh sách khách sạn mà người dùng đã yêu thích
        $favoriteHotelIds = FavoriteHotel::where('user_id', $userId)->pluck('hotel_id')->toArray();
        foreach ($hotels as $hotel) {
            // Kiểm tra nếu khách sạn là yêu thích
            $hotel->is_favorite = in_array($hotel->hotel_id, $favoriteHotelIds);
            // Tính giá gốc trung bình
            $hotel->average_price = $hotel->rooms->avg('price');

            // Tính phần trăm giảm giá trung bình
            $hotel->average_discount_percent = $hotel->rooms->avg('discount_percent');

            // Tính giá sale dựa trên giá gốc và phần trăm giảm giá trung bình
            $hotel->average_price_sale = $hotel->average_price * (1 - $hotel->average_discount_percent / 100);
        }
        $vouchers = Promotions::where('end_date', '>=', now())->take(5)->get();
        $currentDate = Carbon::now();
        foreach ($vouchers as $voucher) {
            $voucher->start_date = Carbon::createFromFormat('d/m/Y', $voucher->start_date);
            $voucher->end_date = Carbon::createFromFormat('d/m/Y', $voucher->end_date);

            if ($voucher->end_date instanceof Carbon) {
                $daysLeft = $voucher->end_date->diffInDays($currentDate);

                if ($daysLeft <= 1) {
                    $voucher->borderClass = 'red-border';
                } else {
                    $voucher->borderClass = 'blue-border';
                }
            }
        }

        // dd($hotels);
        // Truyền dữ liệu qua view
        return view('pages.home', compact('hotels', 'vouchers'));
    }
    // Filter
    public function filterHotels(Request $request)
    {
        $filters = $request->input('filters', []);
        $hotels = Hotel::query();

        if (in_array('high_rating', $filters)) {
            $hotels->where('rating', '>=', 4); // Lọc theo rating từ 4-5
        }

        // Sắp xếp theo rating giảm dần nếu có yêu cầu
        if (in_array('desc_rating', $filters)) {
            $hotels->orderBy('rating', 'desc')->get();
        }
        // Thêm điều kiện cho các bộ lọc
        // ...

        $hotels = $hotels->with('images')->get();

        return response()->json(['hotels' => $hotels]);
    }

    // Chi tiết khách sạn
    public function show($hotel_id)
    {
        $hotel = Hotel::with(['rooms.room_images'], 'images', 'city')->findOrFail($hotel_id);
        $rooms = $hotel->rooms()->paginate(4);
        return view('pages.hotel_detail', compact('hotel', 'rooms'));
    }

    public function search(Request $request)
    {
        // Lấy thông tin từ form
        $location = $request->input('location');
        $daterange = $request->input('daterange');
        $rooms = $request->input('rooms');
        $adults = $request->input('adults');
        $children = $request->input('children');

        // Tách ngày đi và ngày về từ daterange
        list($checkInDate, $checkOutDate) = explode(' - ', $daterange);

        // Gọi phương thức tìm kiếm từ model Hotel
        $hotels = Hotel::searchHotels($location, $checkInDate, $checkOutDate, $rooms, $adults, $children);

        // Trả về kết quả tìm kiếm tới view
        $amenities = HotelAmenities::getAllAmenities();

        // Trả dữ liệu về trang search_result
        return view('pages.search_result', compact('hotels', 'amenities', 'location', 'daterange', 'rooms', 'adults', 'children'));
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
            'hotel_name' => 'required|string|max:255|regex:/^[\pL\s]+$/u|unique:hotels,hotel_name',
            'location' => 'required|string|max:255',
            'city_id' => 'required|integer',
            'description' => 'required|string',
            'rating' => 'required|nullable|between:1,5',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'amenities' => 'required|nullable|array',
            'amenities.*' => 'integer|exists:hotel_amenities,amenity_id',
            'rooms' => 'required|nullable|array',
            'rooms.*' => 'integer|exists:rooms,room_id',
        ], [
            'hotel_name.required' => 'Tên khách sạn là bắt buộc.',
            'hotel_name.unique' => 'Tên khách sạn đã tồn tại.',
            'hotel_name.regex' => 'Tên khách sạn chỉ được chứa chữ cái và khoảng trắng.',
            'location.required' => 'Vị trí là bắt buộc.',
            'city_id.required' => 'Thành phố là bắt buộc.',
            'description.required' => 'Mô tả là bắt buộc.',
            'rating.between' => 'Đánh giá phải từ 1 đến 5.',
            'rating.required' => 'Đánh giá là bắt buộc.',
            'images.array' => 'Hình ảnh phải là một mảng.',
            'images.*.image' => 'Tập tin phải là hình ảnh.',
            'images.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png hoặc jpg.',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'amenities.*.exists' => 'Tiện nghi không tồn tại.',
            'amenities.required' => 'Tiện nghi là bắt buộc.',
            'rooms.*.exists' => 'Phòng không tồn tại.',
            'rooms.required' => 'Phòng là bắt buộc.',
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

        // Kiểm tra xem có hình ảnh nào được upload không
        if ($request->hasFile('images') && count($request->file('images')) > 0) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);

                // Lưu hình ảnh vào bảng hotel_images với hotel_id
                HotelImages::create([
                    'image_url' => $imageName,
                    'hotel_id' => $hotelId,
                ]);
            }
        } else {
            // Nếu không có hình ảnh nào được chọn, lưu hình ảnh mặc định
            $defaultImage = 'img-upload.jpg'; // Tên file hình ảnh mặc định
            HotelImages::create([
                'image_url' => $defaultImage,
                'hotel_id' => $hotelId,
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
        ], [
            'hotel_name.required' => 'Tên khách sạn là bắt buộc.',
            'hotel_name.regex' => 'Tên khách sạn chỉ được chứa chữ cái và khoảng trắng.',
            'hotel_name.max' => 'Tên khách sạn không được vượt quá 255 ký tự.',
            'location.required' => 'Vị trí là bắt buộc.',
            'location.max' => 'Vị trí không được vượt quá 255 ký tự.',
            'city_id.required' => 'Thành phố là bắt buộc.',
            'city_id.integer' => 'Thành phố phải là một số nguyên.',
            'city_id.exists' => 'Thành phố không tồn tại.',
            'description.required' => 'Mô tả là bắt buộc.',
            'rating.required' => 'Đánh giá là bắt buộc.',
            'rating.numeric' => 'Đánh giá phải là một số.',
            'rating.min' => 'Đánh giá tối thiểu là 1.',
            'rating.max' => 'Đánh giá tối đa là 5.',
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
            // \Log::info('Processing amenities: ', [$validatedData['amenities']]);

            $currentAmenities = $hotel->amenities()->pluck('amenity_id')->toArray();

            // Xóa những tiện nghi không còn được chọn
            foreach (array_diff($currentAmenities, $validatedData['amenities']) as $amenityId) {
                // Detach tiện nghi khỏi khách sạn
                $hotel->amenities()->detach($amenityId);

                // \Log::info('Detached amenity: ' . $amenityId);
            }

            // Thêm những tiện nghi mới nếu chưa có trong danh sách
            foreach ($validatedData['amenities'] as $amenityId) {
                if (!in_array($amenityId, $currentAmenities)) {
                    // Thêm tiện nghi mới vào khách sạn
                    $hotel->amenities()->attach($amenityId);
                    // \Log::info('Attached amenity: ' . $amenityId);
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
    // Chi tiết đặt phòng 
    public function getInfoPayment($hotel_id, $room_id)
    {
        $hotel = Hotel::with(['images', 'city'])->findOrFail($hotel_id);
        $room = Rooms::with(['room_images', 'amenities'])->where('hotel_id', $hotel_id)->findOrFail($room_id);
        //    dd($hotel);
        $firstImage = $hotel->images->first();
        // dd($firstImage);
        return view('pages.pay', compact('hotel', 'room', ));
    }

   
    // Trong controller
    public function filterHotelsByCity(Request $request)
    {
        $cityId = $request->get('city_id');

        // Eager load quan hệ city và lấy thông tin về tên thành phố
        $hotels = Hotel::with('city') // Eager load quan hệ city
                    ->where('city_id', $cityId)
                    ->get()
                    ->map(function ($hotel) {
                        return [
                            'hotel_id' => $hotel->id,
                            'hotel_name' => $hotel->hotel_name,
                            'location' => $hotel->location,
                            'city' => $hotel->city->city_name, // Lấy tên thành phố
                            'reviews_count' => Reviews::countReviewsForHotel($hotel->id),
                            'old_price' => number_format($hotel->average_price_sale, 0, ',', '.'),
                            'new_price' => number_format($hotel->average_price, 0, ',', '.'),
                            'is_favorite' => $hotel->is_favorite,
                            'discount_percent' => number_format($hotel->average_discount_percent),
                            'image_url' => $hotel->images->isNotEmpty() ? asset('storage/images/' . $hotel->images->first()->image_url) : '/images/default-image.png',
                        ];
                    });
                    
        return response()->json([
            'hotels' => $hotels
        ]);
    }

    public function getAllHotels(Request $request)
    {
        // Lấy tất cả khách sạn mà không lọc theo city_id
        $hotels = Hotel::with('city') // Eager load quan hệ city
                    ->get() // Lấy tất cả khách sạn
                    ->map(function ($hotel) {
                        return [
                            'hotel_id' => $hotel->id,
                            'hotel_name' => $hotel->hotel_name,
                            'location' => $hotel->location,
                            'city' => $hotel->city->city_name, // Lấy tên thành phố
                            'reviews_count' => Reviews::countReviewsForHotel($hotel->id),
                            'old_price' => number_format($hotel->average_price_sale, 0, ',', '.'),
                            'new_price' => number_format($hotel->average_price, 0, ',', '.'),
                            'is_favorite' => $hotel->is_favorite,
                            'discount_percent' => number_format($hotel->average_discount_percent),
                            'image_url' => $hotel->images->isNotEmpty() ? asset('storage/images/' . $hotel->images->first()->image_url) : '/images/default-image.png',
                        ];
                    });
                    
        return response()->json([
            'hotels' => $hotels
        ]);
    }
}
// 