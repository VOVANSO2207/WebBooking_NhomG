<?php

namespace App\Http\Controllers;

use App\Models\RoomAmenities;
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
        if (Rooms::deleteRoom($room_id)) {
            return redirect()->route('admin.viewroom')->with('success', 'Phòng đã được xóa thành công!');
        }
        return redirect()->route('admin.viewroom')->with('error', 'Phòng không tồn tại!');
    }
    public function store(Request $request)
    {
        // Tạo dữ liệu phòng
        $data = $request->only(['name', 'room_type_id', 'price', 'capacity', 'discount_percent', 'description']);
        $data['hotel_id'] = 0;
        $room = Rooms::createRoom($data);

        // Thêm tiện nghi vào phòng
        RoomAmenities::addAmenitiesToRoom($room->room_id, $request->amenities);

        // Upload images
        if ($request->hasFile('images')) {
            RoomImages::uploadImages($room->room_id, $request->file('images'));
        }

        return redirect()->route('admin.viewroom')->with('success', 'Phòng đã được thêm thành công!');
    }


}
