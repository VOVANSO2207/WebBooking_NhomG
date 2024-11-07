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
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u',
        ], [
            'name.required' => 'Vui lòng nhập tên loại phòng.',
            'name.regex' => 'Tên chỉ được chứa chữ cái và khoảng trắng.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
        ]);

        // Kiểm tra xem loại phòng tồn tại trong cơ sở dữ liệu 
        if (RoomType::where('name', $request->name)->exists()) {
            return redirect()->route('roomType_add')->withErrors([
                'name' => 'Dữ liệu này đã tồn tại.'
            ]);
        }

        try {
            $data = $request->only(['name']);
            RoomType::createRoomType($data);

            return redirect()->route('roomType_add')->with('success', 'Room Type added successfully');
        } catch (\Exception $e) {
            return redirect()->route('roomType_add')->with('error', 'Failed to add Room Type');
        }
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
            return redirect()->route('admin.roomtype.edit', $roomType_id)->with('info', 'No changes were made.'); // Thông báo không có thay đổi
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
