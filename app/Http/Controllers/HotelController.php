<?php

namespace App\Http\Controllers;
use App\Helpers\IdEncoder;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Cities;
use App\Models\HotelImages;
use App\Models\HotelAmenities;
use App\Models\HotelAmenityHotel;
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
        $decodedId = IdEncoder::decodeId($hotel_id);
        $hotel = Hotel::with(['images', 'amenities', 'city'])->find($decodedId);

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

        // Lấy amenities từ bảng hotel_amenity_hotel
        $amenities = $hotel->amenities->map(function ($amenity) {
            return [
                'name' => $amenity->amenity_name,
                'description' => $amenity->description,
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
            'rating' => 'nullable|integer|between:1,5', // Thêm xác thực cho rating nếu cần
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'amenities' => 'nullable|array',
            'amenities.*' => 'integer|exists:hotel_amenities,amenity_id',
        ], [
            // Các thông báo lỗi có thể tùy chỉnh tại đây
        ]);

        // Tạo khách sạn mới
        $hotel = Hotel::create([
            'hotel_name' => $request->hotel_name,
            'location' => $request->location,
            'city_id' => $request->city_id,
            'description' => $request->description,
            'rating' => $request->rating, // Lưu rating
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
                    HotelAmenityHotel::create([
                        'hotel_id' => $hotel->hotel_id,
                        'amenity_id' => $amenityId,
                    ]);
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
            $hotel->delete();
            return response()->json(['success' => true, 'message' => 'Khách sạn đã được xóa.']);
        }

        return response()->json(['success' => false, 'message' => 'Khách sạn không tồn tại.'], 404);
    }

    public function searchAdminHotel(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ request
        $keyword = $request->get('search');
        
        // Thực hiện tìm kiếm toàn văn trên các trường name và description
        $hotels = Hotel::whereRaw('MATCH(hotel_name, description) AGAINST(? IN BOOLEAN MODE)', [$keyword])
                        ->paginate(5);
        
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

        return view('admin.hotel_edit', compact('hotel', 'cities', 'hotelAmenities', 'currentAmenities'));
    }

    public function update(Request $request, $hotel_id)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'hotel_name' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'location' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:cities,city_id',
            'description' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:20480',
        ], [
            'hotel_name.required' => 'Tên khách sạn là bắt buộc.',
            'hotel_name.string' => 'Tên khách sạn phải là chuỗi ký tự.',
            'hotel_name.max' => 'Tên khách sạn không được vượt quá 255 ký tự.',
            'hotel_name.regex' => 'Tên khách sạn chỉ được chứa chữ cái và khoảng trắng.',
            'location.required' => 'Địa chỉ là bắt buộc.',
            'location.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'location.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'city_id.required' => 'Mã thành phố là bắt buộc.',
            'city_id.integer' => 'Mã thành phố phải là một số nguyên.',
            'city_id.exists' => 'Mã thành phố không hợp lệ.',
            'description.required' => 'Mô tả là bắt buộc.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
            'rating.required' => 'Đánh giá là bắt buộc.',
            'rating.numeric' => 'Đánh giá phải là một số.',
            'rating.min' => 'Đánh giá tối thiểu là 1.',
            'rating.max' => 'Đánh giá tối đa là 5.',
            'images.array' => 'Hình ảnh phải là một mảng.',
            'images.*.image' => 'Mỗi mục trong hình ảnh phải là một ảnh.',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg.',
            'images.*.max' => 'Mỗi hình ảnh không được vượt quá 20MB.',
        ]);        

        // Tìm khách sạn và cập nhật thông tin
        $decodedId = IdEncoder::decodeId($hotel_id);
        $hotel = Hotel::find($decodedId);

        if (!$hotel) {
            return redirect()->route('admin.viewhotel')->with('error', 'Khách sạn không tồn tại.');
        }

        // Cập nhật thông tin khách sạn
        $hotel->update([
            'hotel_name' => $validatedData['hotel_name'],
            'location' => $validatedData['location'],
            'city_id' => $validatedData['city_id'],
            'description' => $validatedData['description'],
            'rating' => $validatedData['rating'], // Cập nhật rating
        ]);

        // Xử lý tiện nghi
        if ($request->has('amenities')) {
            // Lưu lại các tiện nghi hiện tại
            $currentAmenities = $hotel->amenities()->pluck('amenity_id')->toArray();

            // Xóa những tiện nghi không còn được chọn
            foreach (array_diff($currentAmenities, $validatedData['amenities']) as $amenityId) {
                $hotel->amenities()->detach($amenityId);
            }

            // Thêm những tiện nghi mới hoặc cập nhật nếu cần
            foreach ($validatedData['amenities'] as $amenityId) {
                if (!in_array($amenityId, $currentAmenities)) {
                    $hotel->amenities()->attach($amenityId);
                }
            }
        }
        
        // Xử lý upload ảnh nếu có
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                // Lưu ảnh vào storage/app/public/images
                $image->storeAs('images', $imageName, 'public');

                // Lưu đường dẫn ảnh vào cơ sở dữ liệu
                HotelImages::create([
                    'hotel_id' => $hotel->hotel_id,
                    'image_url' => 'storage/images/' . $imageName, // Lưu đường dẫn đầy đủ để truy cập từ public
                ]);
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