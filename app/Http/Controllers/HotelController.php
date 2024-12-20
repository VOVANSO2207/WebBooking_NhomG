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
    // Filter Hotels 
    public function filterHotels(Request $request)
    {
        try {
            $filters = $request->input('filters', []);
            $hotels = Hotel::query();
        

            // Lọc theo số hạng sao
            if (in_array('two_start', $filters)) {
                $hotels->where('rating', 2);
            }
            if (in_array('three_start', $filters)) {
                $hotels->where('rating', '>=', 3)->where('rating', '<', 4); // Lọc khách sạn từ 3 sao đến dưới 4 sao
            }
            if (in_array('four_start', $filters)) {
                $hotels->where('rating', '>=', 4)->where('rating', '<', 5); // Lọc khách sạn từ 4 sao đến dưới 5 sao
            }
            if (in_array('five_start', $filters)) {
                $hotels->where('rating', 5); // Lọc khách sạn có 5 sao
            }

            // Sắp xếp theo rating giảm dần nếu có yêu cầu
            if (in_array('desc_rating', $filters)) {
                $hotels->orderBy('rating', 'desc')->get();
            }
            // Lọc theo số lượng đánh giá nhiều nhất nếu có yêu cầu
            if (in_array('high_rating', $filters)) {
                $hotels->withCount('reviews')->orderBy('reviews_count', 'desc');
            }
            // Lọc theo khách sạn có khuyến mãi nếu có 
            if (in_array('promotions', $filters)) {
                $hotels->whereHas('rooms', function ($query) {
                    $query->where('discount_percent', '>', 0);
                });
            }
            if (in_array('single_room', $filters)) {
                $hotels->whereHas('rooms.roomType', function ($query) {
                    $query->where('name', 'Phòng Đơn');
                });
            }
            if (in_array('double_room', $filters)) {
                $hotels->whereHas('rooms.roomType', function ($query) {
                    $query->where('name', 'Phòng Đôi');
                });
            }
            // Lọc theo tiện nghi khách sạn 
            $amenities = $request->input('amenities', []);
            if (!empty($amenities)) {
                $hotels->whereHas('amenities', function ($query) use ($amenities) {
                    $query->whereIn('hotel_amenity_hotel.amenity_id', $amenities);
                });
            }
            // Lọc theo giá rẻ
            if (in_array('low_price', $filters)) {
                $hotels->addSelect([
                    'min_price' => Rooms::select('price')
                        ->whereColumn('rooms.hotel_id', 'hotels.hotel_id')
                        ->orderBy('price', 'asc')
                        ->limit(1)
                ])->orderBy('min_price', 'asc');
            }

            // Lọc theo giá đắt
            if (in_array('high_price', $filters)) {
                $hotels->addSelect([
                    'max_price' => Rooms::select('price')
                        ->whereColumn('rooms.hotel_id', 'hotels.hotel_id')
                        ->orderBy('price', 'desc')
                        ->limit(1)
                ])->orderBy('max_price', 'desc');
            }

            $hotels = $hotels->with('images', 'city', 'rooms.roomType', 'amenities')->get();
            foreach ($hotels as $hotel) {

                // Tính giá gốc trung bình
                $hotel->average_price = $hotel->rooms->avg('price');

                // Tính phần trăm giảm giá trung bình
                $hotel->average_discount_percent = $hotel->rooms->avg('discount_percent');

                // Tính giá sale dựa trên giá gốc và phần trăm giảm giá trung bình
                $hotel->average_price_sale = $hotel->average_price * (1 - $hotel->average_discount_percent / 100);
                // Format giá theo định dạng Việt Nam
                $hotel->formatted_average_price = number_format($hotel->average_price, 0, ',', '.') . ' VND';
                $hotel->formatted_average_price_sale = number_format($hotel->average_price_sale, 0, ',', '.') . ' VND';
            }
            return response()->json(['hotels' => $hotels]);
        } catch (\Exception $e) {
            // \Log::error('Error filtering hotels: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while processing your request.'], 500);
        }
    }

    // Chi tiết khách sạn
    public function show($hotel_id)
    {
        $hotel = Hotel::with(['rooms.room_images', 'images', 'city', 'reviews.user', 'reviews.likes'])->findOrFail($hotel_id);
        $rooms = $hotel->rooms()->paginate(4);
        $reviews = $hotel->reviews()->withCount('likes')->latest()->paginate(7);  // Đếm số lượt like
        $averageRating = $reviews->avg('rating'); // Tính trung bình rating
        return view('pages.hotel_detail', compact('hotel', 'rooms', 'reviews', 'averageRating'));
    }

    public function search(Request $request)
    {
        // Lưu các tham số tìm kiếm vào session
        $request->session()->put([
            'location' => $request->location,
            'daterange' => $request->daterange,
            'rooms' => $request->rooms,
            'adults' => $request->adults,
            'children' => $request->children,
        ]);

        // Lấy thông tin từ form
        $location = $request->input('location');
        $daterange = $request->input('daterange');
        $rooms = $request->input('rooms');
        $adults = $request->input('adults');
        $children = $request->input('children');

        // Tách ngày đi và ngày về từ daterange
        list($checkInDate, $checkOutDate) = explode(' - ', $daterange);
        $daterange = session('daterange'); // Lấy dữ liệu từ session


        // Gọi phương thức tìm kiếm từ model Hotel
        $hotels = Hotel::searchHotels($location, $checkInDate, $checkOutDate, $rooms, $adults, $children);
        // dd($daterange);
        // Trả về kết quả tìm kiếm tới view
        $amenities = HotelAmenities::getAllAmenities();

        // Nếu là yêu cầu AJAX, trả về HTML của danh sách phòng
        if ($request->ajax()) {
            // Lấy danh sách rooms từ các khách sạn
            $rooms = $hotels['hotels']->flatMap(function ($hotel) {
                return $hotel->rooms;
            });

            return response()->json([
                'html' => view('pages.hotel_detail', [
                    'rooms' => $rooms,
                    'hotels' => $hotels['hotels'],
                    'hotelCount' => $hotels['hotelCount'],
                    'cityName' => $hotels['cityName'],
                ])->render(),
            ]);
        }

        // Trả về kết quả tìm kiếm trong view search_result
        return view('pages.search_result', [
            'hotels' => $hotels['hotels'],
            'hotelCount' => $hotels['hotelCount'],
            'cityName' => $hotels['cityName'],
            'amenities' => $amenities,
            'location' => $location,
            'daterange' => $daterange,
            'rooms' => $rooms,
            'adults' => $adults,
            'children' => $children,

        ]);
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

        // Lấy các phòng chưa được liên kết với bất kỳ khách sạn nào (hotel_id = 0)
        $hotelRooms = Rooms::where('hotel_id', 0)->get(); // Giả sử bạn đã khai báo model Rooms

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
            $imagePath = public_path('storage/images/' . $image->image_url);
            if (file_exists($imagePath)) {
                return asset('storage/images/' . $image->image_url);
            } else {
                return asset('/storage/images/' . $image->image_url); // Hình ảnh mặc định
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
                                $imagePath = public_path('storage/images/' . $imageToDelete->image_url);
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
                        $image->move(public_path('storage/images'), $imageName);
        
                        HotelImages::create([
                            'hotel_id' => $hotel->hotel_id,
                            'image_url' => $imageName,
                        ]);
                    }
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

        // Kiểm tra xem có 'selected_rooms' hay không và nếu có thì giải mã JSON thành mảng
        if ($request->has('selected_rooms')) {
            // Giải mã chuỗi JSON thành mảng
            $selectedRooms = json_decode($request->input('selected_rooms'), true); // true để trả về mảng

            // Kiểm tra xem $selectedRooms có phải là mảng hợp lệ không
            if (is_array($selectedRooms)) {
                foreach ($selectedRooms as $roomId) {
                    $room = Rooms::find($roomId);

                    if ($room) {
                        // Gán hotel_id cho phòng
                        $room->hotel_id = $hotel->hotel_id;
                        // Lưu thay đổi
                        $room->save();
                    }
                }
            } else {
                // Nếu không phải là mảng hợp lệ, có thể trả về lỗi hoặc xử lý khác
                return response()->json(['error' => 'Invalid room selection'], 400);
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

            return redirect()->route('admin.viewhotel')->with('success', 'Khách sạn đã được xóa.');
        }

        return redirect()->route('admin.viewhotel')->with('error', 'Khách sạn không tồn tại.');
    }


    public function searchAdminHotel(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ request
        $keyword = $request->get('search');

        // Thực hiện tìm kiếm bằng phương thức searchHotel từ model
        $hotels = Hotel::searchHotel($keyword)->paginate(5);

        // Trả về view với kết quả tìm kiếm
        return view('admin.search_results_hotel', compact('hotels'));
    }



    public function editHotel($hotel_id)
    {
        // Giải mã ID
        $decodedId = IdEncoder::decodeId($hotel_id);

        // Tìm khách sạn cụ thể theo ID đã giải mã
        $hotel = Hotel::find($decodedId);

        // Lấy danh sách thành phố
        $cities = Cities::all();

        // Lấy tất cả các tiện nghi
        $hotelAmenities = HotelAmenities::all();

        // Lấy các tiện nghi hiện tại của khách sạn
        $currentAmenities = $hotel->amenities()->pluck('amenity_id')->toArray();

        // Lấy tất cả các phòng, bao gồm ảnh đầu tiên của mỗi phòng
        $rooms = Rooms::with([
            'room_images' => function ($query) {
                $query->orderBy('image_id', 'asc')->take(1); // Lấy ảnh đầu tiên
            }
        ])->get();

        // Lấy các phòng hiện tại của khách sạn
        $currentRooms = $hotel->rooms()->pluck('room_id')->toArray();
        $selectedRooms = $hotel->rooms->pluck('room_id')->toArray(); // Lấy tất cả room_id
        // Trả về view với dữ liệu cần thiết
        return view('admin.hotel_edit', compact(
            'hotel',
            'cities',
            'hotelAmenities',
            'currentAmenities',
            'rooms',
            'currentRooms', 'selectedRooms'
        ));
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
                        $imagePath = public_path('storage/images/' . $imageToDelete->image_url);
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
                $image->move(public_path('storage/images'), $imageName);

                HotelImages::create([
                    'hotel_id' => $hotel->hotel_id,
                    'image_url' => $imageName,
                ]);
            }
        }

        if ($request->has('selected_rooms')) {
            $selectedRooms = json_decode($request->input('selected_rooms'), true);

            $existingRooms = $hotel->rooms()->pluck('room_id')->toArray();
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
    public function getInfoPayment(Request $request, $hotel_id, $room_id)
    {
        $daterange = $request->input('daterange');
        if ($daterange) {
            $request->session()->put('daterange', $daterange);
        } else {
            $daterange = session('daterange');
        }

        $hotel = Hotel::with(['images', 'city'])->findOrFail($hotel_id);
        $room = Rooms::with(['room_images', 'amenities'])->where('hotel_id', $hotel_id)->findOrFail($room_id);
        $firstImage = $hotel->images->first();

        $originalPrice = $room->price;
        $discountedPrice = $originalPrice - ($originalPrice * ($room->discount_percent / 100));

        if ($daterange) {
            list($checkIn, $checkOut) = explode(' - ', $daterange);
        
            // Thiết lập ngôn ngữ tiếng Việt
            \Carbon\Carbon::setLocale('vi');
        
            // Chuyển đổi ngày nhận phòng và trả phòng thành đối tượng Carbon
            $checkInDay = \Carbon\Carbon::createFromFormat('d/m/Y', trim($checkIn));
            $checkOutDay = \Carbon\Carbon::createFromFormat('d/m/Y', trim($checkOut));

            
        
            // Tính số ngày (bao gồm cả ngày nhận và trả phòng)
            $days = $checkInDay->diffInDays($checkOutDay) + 1; // +1 để tính cả ngày nhận và ngày trả
        
            // Tính số đêm (số ngày - 1)
            $nights = $days - 1;
        
            // Xử lý định dạng ngày check-in
            $checkInFormattedDay = $checkInDay->format('D'); // Lấy thứ trong tuần
            switch ($checkInFormattedDay) {
                case 'Mon':
                    $checkInFormattedDay = 'Thứ 2';
                    break;
                case 'Tue':
                    $checkInFormattedDay = 'Thứ 3';
                    break;
                case 'Wed':
                    $checkInFormattedDay = 'Thứ 4';
                    break;
                case 'Thu':
                    $checkInFormattedDay = 'Thứ 5';
                    break;
                case 'Fri':
                    $checkInFormattedDay = 'Thứ 6';
                    break;
                case 'Sat':
                    $checkInFormattedDay = 'Thứ 7';
                    break;
                case 'Sun':
                    $checkInFormattedDay = 'CN';
                    break;
            }
        
            // Định dạng ngày check-in
            $checkInFormatted = $checkInFormattedDay . ', ' . $checkInDay->format('j') . ' thg ' . $checkInDay->format('m') . ' ' . $checkInDay->format('Y');
        
            // Xử lý định dạng ngày check-out
            $checkOutFormattedDay = $checkOutDay->format('D'); 
            switch ($checkOutFormattedDay) {
                case 'Mon':
                    $checkOutFormattedDay = 'Thứ 2';
                    break;
                case 'Tue':
                    $checkOutFormattedDay = 'Thứ 3';
                    break;
                case 'Wed':
                    $checkOutFormattedDay = 'Thứ 4';
                    break;
                case 'Thu':
                    $checkOutFormattedDay = 'Thứ 5';
                    break;
                case 'Fri':
                    $checkOutFormattedDay = 'Thứ 6';
                    break;
                case 'Sat':
                    $checkOutFormattedDay = 'Thứ 7';
                    break;
                case 'Sun':
                    $checkOutFormattedDay = 'CN';
                    break;
            }
        
            // Định dạng ngày check-out
            $checkOutFormatted = $checkOutFormattedDay . ', ' . $checkOutDay->format('j') . ' thg ' . $checkOutDay->format('m') . ' ' . $checkOutDay->format('Y');
        
            // Định dạng số đêm và số ngày
            $nightText = $nights == 1 ? '1 đêm' : "$nights đêm";
            $dayText = $days == 1 ? '1 ngày' : "$days ngày";
        } else {
            $checkInFormatted = null;
            $checkOutFormatted = null;
            $nightText = null;
            $dayText = null;
        }
        
        // Tính tổng tiền thanh toán trước thuế
        $totalAmountBeforeTax = $discountedPrice * $nights;

        // Tính thuế
        $taxRate = 0.08; // 8%
        $taxAmount = $totalAmountBeforeTax * $taxRate;

        // Tổng tiền phải thanh toán 
        $totalAmount = $totalAmountBeforeTax + $taxAmount;
        return view('pages.pay', compact('hotel', 'room', 'originalPrice', 'discountedPrice', 'checkInFormatted', 'checkOutFormatted', 'nightText', 'dayText', 'totalAmount','taxAmount'));
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
                    'hotel_id' => $hotel->hotel_id,
                    'hotel_name' => $hotel->hotel_name,
                    'location' => $hotel->location,
                    'city' => $hotel->city->city_name, // Lấy tên thành phố
                    'reviews_count' => $hotel->reviews->count(),
                    'old_price' => number_format($hotel->average_price_sale, 0, ',', '.'),
                    'new_price' => number_format($hotel->average_price, 0, ',', '.'),
                    'is_favorite' => $hotel->is_favorite,
                    'discount_percent' => number_format($hotel->average_discount_percent),
                    'image_url' => $hotel->images->isNotEmpty() ? asset('storage/images/' . $hotel->images->first()->image_url) : asset('images/img-hotel.jpg'),
                    'detail_url' => route('pages.hotel_detail', ['hotel_id' => $hotel->hotel_id]),
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
                    'hotel_id' => $hotel->hotel_id,
                    'hotel_name' => $hotel->hotel_name,
                    'location' => $hotel->location,
                    'city' => $hotel->city->city_name, // Lấy tên thành phố
                    'reviews_count' => $hotel->reviews->count(),
                    'old_price' => number_format($hotel->average_price_sale, 0, ',', '.'),
                    'new_price' => number_format($hotel->average_price, 0, ',', '.'),
                    'is_favorite' => $hotel->is_favorite,
                    'discount_percent' => number_format($hotel->average_discount_percent),
                    'image_url' => $hotel->images->isNotEmpty() ? asset('images/' . $hotel->images->first()->image_url) : '/images/default-image.png',
                    'detail_url' => route('pages.hotel_detail', ['hotel_id' => $hotel->hotel_id]),
                ];
            });

        return response()->json([
            'hotels' => $hotels
        ]);
    }
}
