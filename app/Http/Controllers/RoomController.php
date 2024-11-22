<?php

namespace App\Http\Controllers;

use App\Helpers\IdEncoder;
use App\Models\RoomAmenities;
use App\Models\RoomAmenityRoom;
use App\Models\RoomImages;
use App\Models\Rooms;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
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
        $result = Rooms::deleteRoom($room_id);

        // Kiểm tra kết quả và chuyển hướng phù hợp
        if (!$result['success']) {
            return redirect()->route('admin.viewroom')->with('error', $result['message']);
        }

        return redirect()->route('admin.viewroom')->with('success', $result['message']);
    }
    public function store(Request $request)
    {
        // Gọi hàm validate từ Model
        $validator = Rooms::validateRoom($request->all());

        if ($validator->fails()) {
            // Nếu lỗi, trả về cùng thông báo
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Lấy dữ liệu hợp lệ
            $data = $request->only(['name', 'room_type_id', 'price', 'capacity', 'discount_percent', 'description']);
            $data['hotel_id'] = 0; 

            // Thêm dữ liệu vào phòng
            $room = Rooms::createRoomWithDetails(
                $data,
                $request->input('amenities'),
                $request->file('images')
            );

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
        // Lấy phòng cần cập nhật
        $room = Rooms::findOrFail($room_id);

        // Sử dụng validation từ Model
        $validator = Rooms::validateRoom($request->all(), true);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Chuẩn bị dữ liệu
            $data = $request->only(['name', 'room_type_id', 'price', 'discount_percent', 'capacity', 'description']);
            $amenities = $request->input('amenities', []);
            $images = $request->file('images');
            $existingImages = $request->input('existing_images', []);

            // Gọi hàm xử lý trong Model
            $room->updateRoom($data, $amenities, $images, $existingImages);

            return redirect()->route('admin.viewroom')->with('success', 'Cập nhật phòng thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }
    public function deleteImage($id)
    {
        return RoomImages::deleteImage($id);
    }
    // Search phòng theo đệ quy
    public function keywordSearch(Request $request)
    {
        $results = Rooms::searchRooms($request->input('query'));
        return view('admin.search_results_room', ['results' => $results])->render();
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
