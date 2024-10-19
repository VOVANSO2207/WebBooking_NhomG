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
        // Lấy tất cả các phòng cùng với tiện nghi, loại phòng và hình ảnh
        $rooms = Rooms::with('roomType', 'amenities', 'room_images')->get();
        // dd($rooms);
        // Trả về view với dữ liệu rooms
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

    public function store(Request $request)
    {
        // Create a new room
        $room = new Rooms();
        $room->name = $request->name;
        $room->room_type_id = $request->room_type_id;
        $room->price = $request->price;
        $room->capacity = $request->capacity;
        $room->discount_percent = $request->discount_percent;
        $room->description = $request->description;
        $room->hotel_id = 0;
        $room->save();


        // Add amenities to room
        foreach ($request->amenities as $amenity) {
            RoomAmenities::create([
                'room_id' => $room->room_id,
                'amenity_name' => $amenity,
                'description' => 'null', 
            ]);
        }
        
        // // Upload images
        // if ($request->hasFile('images')) {
        //     foreach ($request->file('images') as $image) {
        //         $path = $image->store('room_images', 'public'); // Store the image in public storage
        //         RoomImages::create([
        //             'room_id' => $room->id,
        //             'img_url' => $path,
        //         ]);
        //     }
        // }
        return redirect()->route('admin.viewroom')->with('success', 'Phòng đã được thêm thành côngs!');
    }
    public function destroy($room_id)
    {
        // Tìm phòng dựa trên ID
        $room = Rooms::where('room_id', $room_id)->first();

        // Kiểm tra nếu phòng có tồn tại
        if (!$room) {
            return redirect()->route('admin.viewroom')->with('error', 'Phòng không tồn tại!');
        }

        // Xóa phòng
        $room->delete();

        // Redirect sau khi xóa thành công
        return redirect()->route('admin.viewroom')->with('success', 'Phòng đã được xóa thành công!');
    }

    public function getRoomDetails($id)
    {
        $room = Rooms::with(['room_images', 'roomType', 'amenities'])->findOrFail($id);
        return response()->json($room);
    }
}
