<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAmenities extends Model
{
    use HasFactory;
    protected $table = 'room_amenities';
    protected $fillable = ['amenity_id', 'amenity_name', 'description'];
    protected $primaryKey = 'amenity_id';
    public $timestamps = false;
    // Một tiện nghi thuộc về một phòng
    // public function room()
    // {
    //     return $this->belongsTo(Rooms::class, 'room_id');
    // }
    public function room()
    {
        return $this->belongsToMany(Rooms::class, 'room_amenity_room', 'amenity_id', 'room_id');
    }
    // Quan hệ 1-n với RoomAmenityRoom
    public function roomAmenityRooms()
    {
        return $this->hasMany(RoomAmenityRoom::class, 'amenity_id', 'amenity_id');
    }
    public static function addAmenitiesToRoom($roomId, $amenities)
    {
        foreach ($amenities as $amenity) {
            self::create([
                'amenity_name' => $amenity,
                'description' => 'null',                                            
            ]);
        }
    }
    // Cập nhật tiện nghi cho phòng
    public static function updateAmenitiesForRoom($room_id, $amenities)
    {
        // Xóa các tiện nghi hiện tại của phòng
        self::where('room_id', $room_id)->delete();

        // Thêm tiện nghi mới
        foreach ($amenities as $amenityId) {
            self::create([
                'room_id' => $room_id,
                'amenity_id' => $amenityId,
            ]);
        }
    }
}
