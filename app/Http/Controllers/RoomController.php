<?php

namespace App\Http\Controllers;

use App\Models\RoomAmenities;
use App\Models\RoomAmenityRoom;
use App\Models\RoomImages;
use App\Models\Rooms;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Rooms::getAllRooms();
        return view('admin.room', ['rooms' => $rooms]);
    }


    public function show(Request $request)
    {
        // Lấy danh sách loại phòng và tiện nghi
        $roomTypes = RoomType::all();
        $amenities = RoomAmenities::all();

        // Trả về view với dữ liệu
        return view('admin.room_add', [
            'roomTypes' => $roomTypes,
            'amenities' => $amenities,
        ]);
    }
    public function destroy($room_id)
    {
        // Tìm phòng dựa trên ID
        $room = Rooms::find($room_id);
    
        if (!$room) {
            return redirect()->route('admin.viewroom')->with('error', 'Phòng không tồn tại!');
        }
    
        // Xóa hình ảnh liên quan (nếu có)
        foreach ($room->room_images as $image) {
            // Xóa ảnh từ thư mục
            if (file_exists(public_path('storage/images/' . $image->image_url))) {
                unlink(public_path('storage/images/' . $image->image_url));
            }
            // Xóa ảnh từ cơ sở dữ liệu
            $image->delete();
        }
    
        // Xóa các tiện nghi liên quan từ bảng trung gian
        RoomAmenityRoom::where('room_id', $room_id)->delete();
    
        // Xóa phòng
        $room->delete();
    
        // Chuyển hướng về danh sách phòng với thông báo thành công
        return redirect()->route('admin.viewroom')->with('success', 'Phòng đã được xóa thành công!');
    }
    
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'room_type_id' => 'required|exists:room_types,room_type_id',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'description' => 'required|string',
            'amenities' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // DB::beginTransaction();
        try {
            // Tạo dữ liệu phòng
            $data = $request->only(['name', 'room_type_id', 'price', 'capacity', 'discount_percent', 'description']);
            $data['hotel_id'] = 0; // Thay đổi nếu cần
            $room = Rooms::create($data);

            // Thêm tiện nghi vào bảng trung gian room_amenity_room
            if ($request->has('amenities')) {
                foreach ($request->amenities as $amenityId) {
                    RoomAmenityRoom::create([
                        'room_id' => $room->room_id,  
                        'amenity_id' => $amenityId    
                    ]);
                }
            }

            // Upload hình ảnh
            if ($request->hasFile('images')) {
                RoomImages::uploadImages($room->room_id, $request->file('images'));
            }

            return redirect()->route('admin.viewroom')->with('success', 'Phòng đã được thêm thành công!');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Thêm phòng thất bại: ' . $e->getMessage());
        }
    }


    public function edit($room_id)
    {
        // Lấy thông tin phòng dựa trên ID
        $room = Rooms::with(['roomType', 'amenities', 'room_images'])->findOrFail($room_id);

        // Lấy danh sách loại phòng và tiện nghi để hiển thị trong form
        $roomTypes = RoomType::all();
        $amenities = RoomAmenities::all();
        // dd($room);
        return view('admin.room_edit', [
            'room' => $room,
            'roomTypes' => $roomTypes,
            'amenities' => $amenities,
        ]);
    }
    public function update(Request $request, $room_id)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'room_type_id' => 'required|exists:room_types,room_type_id',
            'price' => 'required|numeric',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'capacity' => 'required|integer',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Kích thước tối đa 2MB
            'amenities' => 'required|array',
            'amenities.*' => 'exists:room_amenities,amenity_id' // Đảm bảo ID tiện nghi tồn tại
        ]);

        // Lấy phòng cần sửa
        $room = Rooms::findOrFail($room_id);

        // Cập nhật thông tin phòng
        $room->update([
            'name' => $request->name,
            'room_type_id' => $request->room_type_id,
            'price' => $request->price,
            'discount_percent' => $request->discount_percent,
            'capacity' => $request->capacity,
            'description' => $request->description,
        ]);

        // Cập nhật hình ảnh (nếu có hình ảnh mới được tải lên)
        if ($request->hasFile('images')) {
            // Xóa hình ảnh cũ
            foreach ($room->room_images as $image) {
                // Xóa ảnh từ thư mục
                if (file_exists(public_path('storage/images/' . $image->image_url))) {
                    unlink(public_path('storage/images/' . $image->image_url));
                }
                // Xóa ảnh từ cơ sở dữ liệu
                $image->delete();
            }

            // Upload và thêm hình ảnh mới
            RoomImages::uploadImages($room->room_id, $request->file('images'));
        }

        // Cập nhật tiện nghi
        RoomAmenityRoom::where('room_id', $room->room_id)->delete();

        // Thêm tiện nghi mới vào bảng trung gian
        if ($request->has('amenities')) {
            foreach ($request->amenities as $amenityId) {
                RoomAmenityRoom::create([
                    'room_id' => $room->room_id,
                    'amenity_id' => $amenityId
                ]);
            }
        }
        return redirect()->route('admin.viewroom')->with('success', 'Room updated successfully.');
    }
}
