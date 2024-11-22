<?php

namespace App\Http\Controllers;

use App\Models\RoomAmenities;
use Illuminate\Http\Request;
use App\Helpers\IdEncoder;

class RoomAmenitiesController extends Controller
{
    public function getAllRoomAmenties()
    {
        $roomAmenitie = RoomAmenities::getAllRoomAmenitie();
        return view('admin.room_amenities', ['roomAmenitie' => $roomAmenitie]);
    }
    public function deleteRoomAmenities($roomAmenities_id)
    {
        $decodeId = IdEncoder::decodeId($roomAmenities_id);
        $deleted = RoomAmenities::deleteRoomAmenities($decodeId);

        if ($deleted) {
            return redirect()->route('admin.viewroomamenities')->with('success', 'Room Amenities deleted successfully');
        }

        return redirect()->route('admin.viewroomamenities')->with('error', 'Room Amenities not found');
    }
    public function showAddRoomAmenities()
    {
        return view('admin.room_amenities_add');
    }
    public function AddRoomAmenities(Request $request)
    {
         RoomAmenities::validateRoomAmenities($request);
        
          // Kiểm tra xem loại phòng tồn tại trong cơ sở dữ liệu 
          if (RoomAmenities::where('amenity_name', $request->amenity_name)->exists()) {
            return redirect()->route('room_amenities_add')->withErrors([
                'amenity_name' => 'Dữ liệu này đã tồn tại.'
            ]);
        }

        try {
            $data = $request->only(['amenity_name', 'description']);
            RoomAmenities::createRoomAmenities($data);

            return redirect()->route('admin.viewroomamenities')->with('success', 'Room Amenities added successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.viewroomamenities')->with('error', 'Failed to add Room Amenities');
        }
    }
    public function updateRoomAmenity(Request $request, $roomAmenities_id)
    {
        $request->validate([
            'amenity_name' => 'required|string|max:255',
        ]);
        // $decodeId = IdEncoder::decodeId($roomType_id);
        $roomAmenities = RoomAmenities::find($roomAmenities_id); // Lấy đối tượng RoomType từ cơ sở dữ liệu

        if (!$roomAmenities) {
            return redirect()->route('admin.room_amenities.edit', $roomAmenities_id)->with('error', 'Room Type not found');
        }
        // Kiểm tra nếu tên phòng không thay đổi
        if ($roomAmenities->amenity_name === $request->amenity_name) {
            return redirect()->route('admin.viewroomamenities')->with('info', 'No changes were made.'); // Thông báo không có thay đổi
        }

        $data = $request->only(['amenity_name','description']);
        $updated = RoomAmenities::updateRoomAmenities($roomAmenities_id, $data);

        if ($updated) {
            return redirect()->route('admin.viewroomamenities')->with('success', 'Đã cập nhật loại phòng thành công');
        }

        return redirect()->route('admin.viewroomamenities')->with('error', 'Failed to update Room Type');
    }
    public function editRoomAmenity($roomAmenities_id)
    {
        $decodeId = IdEncoder::decodeId($roomAmenities_id);
        $roomAmenities = RoomAmenities::find($decodeId);
        // dd($roomType);
        if ($roomAmenities) {
            return view('admin.room_amenities_edit', ['roomAmenities' => $roomAmenities]);
        }

        return redirect()->route('admin.viewroomamenities')->with('error', 'Room Type not found');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $roomAmenitie = RoomAmenities::searchByNameOrDescription($query);
        return view('admin.search_results_room_amenities', compact('roomAmenitie'));
    }
}
