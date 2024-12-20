<?php

namespace App\Http\Controllers;

use App\Models\Rooms;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Helpers\IdEncoder;

class RoomTypeController extends Controller
{
    // public function viewRoomType()
    // {
    //     // $vouchers = RoomType::getAllVouchers(7);
    //     return view('admin.room_type');
    // }

    public function getAllRoomType()
    {
        $roomType = RoomType::getAllRoomType();
        return view('admin.room_type', ['roomType' => $roomType]);
    }
    public function showAddRoomType()
    {
        return view('admin.room_type_add');
    }
    public function AddRoomType(Request $request)
    {
        // Lấy dữ liệu từ request
        $data = $request->only(['name']);

        // Gọi phương thức createRoomType từ Model
        $result = RoomType::createRoomType($data);

        // Kiểm tra kết quả trả về
        if (isset($result['errors'])) {
            return redirect()->route('roomType_add')->withErrors($result['errors']);
        }

        // Nếu không có lỗi, thông báo thành công
        return redirect()->route('roomType_add')->with('success', 'Đã xóa loại phòng thành công');
    }


    public function updateRoomType(Request $request, $roomType_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        // $decodeId = IdEncoder::decodeId($roomType_id);
        $roomType = RoomType::find($roomType_id); // Lấy đối tượng RoomType từ cơ sở dữ liệu
    
        if (!$roomType) {
            return redirect()->route('admin.roomtype.edit', $roomType_id)->with('error', 'Room Type not found');
        }
        
        // Kiểm tra nếu tên phòng không thay đổi
        if ($roomType->name === $request->name) {
            return redirect()->route('admin.roomtype.edit', $roomType_id)->with('info', 'Thông báo không có thay đổi.'); // Thông báo không có thay đổi
        }
    
        $data = $request->only(['name']);
        $updated = RoomType::updateRoomType($roomType_id, $data);
    
        if ($updated) {
            return redirect()->route('admin.viewroomtype')->with('success', 'Đã cập nhật loại phòng thành công');
        }
        
        return redirect()->route('admin.viewroomtype')->with('error', 'Failed to update Room Type');
    }
    public function editRoomType($roomType_id)
    {
        $decodeId = IdEncoder::decodeId($roomType_id);
        $roomType = RoomType::find($decodeId);
        // dd($roomType);
        if ($roomType) {
            return view('admin.room_type_edit', ['roomType' => $roomType]);
        }

        return redirect()->route('admin.viewroomtype')->with('error', 'Room Type not found');
    }

    public function deleteRoomType($roomType_id)
    {
        $decodeId = IdEncoder::decodeId($roomType_id);
        $deleted = RoomType::deleteRoomType($decodeId);
        
        if ($deleted) {
            return redirect()->route('admin.viewroomtype')->with('success', 'Room Type deleted successfully');
        }

        return redirect()->route('admin.viewroomtype')->with('error', 'Room Type not found');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $roomType = RoomType::searchByName($query);
        
        return view('admin.search_results_room_type', compact('roomType'));
    }
}
