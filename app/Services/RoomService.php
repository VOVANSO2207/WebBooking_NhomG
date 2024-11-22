<?php 
namespace App\Services;

use App\Models\Rooms;
use App\Models\RoomType;
use App\Models\RoomAmenities;
use App\Models\RoomImages;
use App\Models\RoomAmenityRoom;
use Illuminate\Support\Facades\File;

class RoomService
{
    public function getRoomData($room_id)
    {
        $room = Rooms::with(['roomType', 'amenities', 'room_images'])->findOrFail($room_id);
        $roomTypes = RoomType::all();
        $amenities = RoomAmenities::all();

        return [
            'room' => $room,
            'roomTypes' => $roomTypes,
            'amenities' => $amenities,
        ];
    }

    public function updateRoom($request, $room_id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'room_type_id' => 'required|exists:room_types,room_type_id',
                'price' => 'required|numeric',
                'discount_percent' => 'required|numeric|min:0|max:100',
                'capacity' => 'required|integer',
                'description' => 'required|string',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'amenities' => 'required|array',
                'amenities.*' => 'exists:room_amenities,amenity_id',
            ]);

            $room = Rooms::findOrFail($room_id);
            $room->update($request->only(['name', 'room_type_id', 'price', 'discount_percent', 'capacity', 'description']));

            if ($request->hasFile('images')) {
                $this->updateRoomImages($room, $request->file('images'));
            } else {
                $existingImages = $request->input('existing_images', []);
                $room->room_images()->whereNotIn('image_id', $existingImages)->delete();
            }

            RoomAmenityRoom::where('room_id', $room->room_id)->delete();

            foreach ($request->amenities as $amenityId) {
                RoomAmenityRoom::create([
                    'room_id' => $room->room_id,
                    'amenity_id' => $amenityId,
                ]);
            }

            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function deleteImage($id)
    {
        try {
            $image = RoomImages::find($id);
            if ($image) {
                $filePath = public_path('storage/images/' . $image->image_url);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
                $image->delete();
                return ['success' => true, 'message' => 'Xóa ảnh thành công'];
            }
            return ['success' => false, 'message' => 'Không tìm thấy ảnh'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Lỗi khi xóa ảnh: ' . $e->getMessage()];
        }
    }

    public function searchRooms($query)
    {
        $keywords = explode(' ', trim($query));
        $rooms = Rooms::query();

        foreach ($keywords as $keyword) {
            $rooms->orWhere(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('description', 'LIKE', '%' . $keyword . '%');
            });
        }

        return $rooms->with('room_images', 'roomType')->get();
    }

    private function updateRoomImages($room, $images)
    {
        foreach ($room->room_images as $image) {
            if (file_exists(public_path('storage/images/' . $image->image_url))) {
                unlink(public_path('storage/images/' . $image->image_url));
            }
            $image->delete();
        }
        RoomImages::uploadImages($room->room_id, $images);
    }
}
