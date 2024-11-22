<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
class Rooms extends Model
{
    use HasFactory;
    protected $table = 'rooms';
    protected $primaryKey = 'room_id'; // Nếu bạn sử dụng room_id làm khóa chính
    public $timestamps = true;
    protected $fillable = ['name', 'room_type_id', 'price', 'capacity', 'discount_percent', 'description', 'hotel_id'];

    // Định nghĩa mối quan hệ với RoomImage
    public function room_images()
    {
        return $this->hasMany(RoomImages::class, 'room_id', 'room_id');
    }
    public function amenities()
    {
        return $this->belongsToMany(RoomAmenities::class, 'room_amenity_room', 'room_id', 'amenity_id');
    }
    // Một phòng thuộc một loại phòng
    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id', 'room_type_id');
    }
    public static function getAllRooms($perPage = 5)
    {
        return self::with('roomType', 'amenities', 'room_images')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    public static function createRoom($data)
    {
        return self::create($data);
    }

    // public function updateRoom($data)
    // {
    //     return $this->update($data);
    // }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_id');
    }
    public function room_types()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }
    public static function searchRooms($searchQuery)
    {
        $keywords = explode(' ', trim($searchQuery));
        $query = self::query();

        foreach ($keywords as $keyword) {
            $query->orWhere(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('description', 'LIKE', '%' . $keyword . '%');
            });
        }

        return $query->with('room_images', 'roomType')->get();
    }
    public static function createRoomWithDetails($data, $amenities, $images)
    {
        DB::beginTransaction();
        try {
            // Tạo dữ liệu phòng
            $room = self::create($data);

            // Thêm tiện nghi
            if (!empty($amenities)) {
                foreach ($amenities as $amenityId) {
                    RoomAmenityRoom::create([
                        'room_id' => $room->room_id,
                        'amenity_id' => $amenityId,
                    ]);
                }
            }

            // Upload hình ảnh
            if (!empty($images)) {
                RoomImages::uploadImages($room->room_id, $images);
            }

            DB::commit();
            return $room;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public static function validateRoom($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'room_type_id' => 'required|exists:room_types,room_type_id',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'description' => 'required|string',
            'amenities' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        return $validator;
    }
    /**
     * Cập nhật thông tin phòng
     */
    public function updateRoom($data, $amenities, $images = null, $existingImages = [])
    {
        // Cập nhật thông tin chính
        $this->update($data);

        // Cập nhật hình ảnh
        if ($images) {
            $this->updateImages($images, $existingImages);
        }

        // Cập nhật tiện nghi
        $this->updateAmenities($amenities);
    }

    /**
     * Cập nhật hình ảnh
     */
    public function updateImages($newImages, $existingImages)
    {
        // Xóa ảnh cũ không nằm trong danh sách giữ lại
        $this->room_images()->whereNotIn('image_id', $existingImages)->each(function ($image) {
            if (file_exists(public_path('storage/images/' . $image->image_url))) {
                unlink(public_path('storage/images/' . $image->image_url));
            }
            $image->delete();
        });

        // Upload ảnh mới
        if ($newImages) {
            RoomImages::uploadImages($this->room_id, $newImages);
        }
    }

    /**
     * Cập nhật tiện nghi
     */
    public function updateAmenities($amenities)
    {
        // Xóa tiện nghi cũ
        RoomAmenityRoom::where('room_id', $this->room_id)->delete();

        // Thêm tiện nghi mới
        foreach ($amenities as $amenityId) {
            RoomAmenityRoom::create([
                'room_id' => $this->room_id,
                'amenity_id' => $amenityId
            ]);
        }
    }
      /**
     * Xóa phòng và tất cả các liên quan (hình ảnh và tiện nghi).
     *
     * @param int $room_id
     * @return bool
     */
    public static function deleteRoom($room_id)
    {
        // Tìm phòng theo ID
        $room = self::find($room_id);

        if (!$room) {
            return [
                'success' => false,
                'message' => 'Phòng không tồn tại!'
            ];
        }

        // Xóa hình ảnh liên quan (nếu có)
        foreach ($room->room_images as $image) {
            // Xóa ảnh từ thư mục
            $filePath = public_path('storage/images/' . $image->image_url);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            // Xóa ảnh từ cơ sở dữ liệu
            $image->delete();
        }

        // Xóa các tiện nghi liên quan từ bảng trung gian
        RoomAmenityRoom::where('room_id', $room_id)->delete();

        // Xóa phòng
        $room->delete();

        return [
            'success' => true,
            'message' => 'Phòng đã được xóa thành công!'
        ];
    }
    // public function updateAmenities($amenities)
    // {
    //     return RoomAmenities::addAmenitiesToRoom($this->room_id, $amenities);
    // }
    // public static function deleteRoom($roomId)
    // {
    //     // Lấy phòng và các quan hệ liên quan (hình ảnh, tiện nghi)
    //     $room = self::with(['room_images', 'amenities'])->find($roomId);

    //     if ($room) {
    //         // Xóa file hình ảnh trong thư mục storage/images
    //         foreach ($room->room_images as $image) {
    //             $imagePath = public_path('storage/images/' . $image->image_url);
    //             if (file_exists($imagePath)) {
    //                 unlink($imagePath); // Xóa file
    //             }
    //         }

    //         // Xóa record trong bảng room_images và amenities
    //         $room->room_images()->delete();
    //         $room->amenities()->delete();

    //         // Xóa phòng
    //         $room->delete();

    //         return true;
    //     }
    //     return false;
    // }
}
