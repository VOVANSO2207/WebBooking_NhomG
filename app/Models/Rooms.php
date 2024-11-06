<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
      // Định nghĩa mối quan hệ với RoomImages
    //   public function roomImages()
    //   {
    //       return $this->hasMany(RoomImages::class, 'room_id');
    //   }
    // Mối quan hệ với RoomAmenity
    // public function amenities()
    // {
    //     return $this->hasMany(RoomAmenities::class, 'room_id');
    // }
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
    public static function deleteRoom($roomId)
    {
        // Lấy phòng và các quan hệ liên quan (hình ảnh, tiện nghi)
        $room = self::with(['room_images', 'amenities'])->find($roomId);
    
        if ($room) {
            // Xóa file hình ảnh trong thư mục storage/images
            foreach ($room->room_images as $image) {
                $imagePath = public_path('storage/images/' . $image->image_url);
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Xóa file
                }
            }
    
            // Xóa record trong bảng room_images và amenities
            $room->room_images()->delete();
            $room->amenities()->delete();
            
            // Xóa phòng
            $room->delete();
            
            return true;
        }
        return false;
    }
    
    public function updateRoom($data)
    {
        return $this->update($data);
    }

    public function updateAmenities($amenities)
    {
        return RoomAmenities::addAmenitiesToRoom($this->room_id, $amenities);
    }
    public function hotel() 
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
}
