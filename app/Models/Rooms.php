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
    public function amenities()
    {
        return $this->hasMany(RoomAmenities::class, 'room_id', 'room_id');
    }
    // Một phòng thuộc một loại phòng
    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id'); 
    }
    public static function getAllRooms()
    {
        return self::with('roomType', 'amenities', 'room_images')->get();
    }
    public static function createRoom($data)
    {
        return self::create($data);
    }
    public static function deleteRoom($roomId)
    {
        $room = self::with(['roomImages', 'amenities'])->find($roomId);
        if ($room) {
            $room->roomImages()->delete();
            $room->amenities()->delete();
            $room->delete();
            return true;
        }
        return false;
    }
    
}
