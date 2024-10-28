<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAmenityRoom extends Model
{
    use HasFactory;
    protected $table = 'room_amenity_room'; // Tên bảng

    // Nếu bảng này không có cột timestamps (created_at, updated_at)
    public $timestamps = false;

    protected $fillable = ['room_id', 'amenity_id'];
    // Quan hệ đến Rooms
    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id', 'room_id');
    }
    // Quan hệ đến RoomAmenities
    public function amenity()
    {
        return $this->belongsTo(RoomAmenities::class, 'amenity_id', 'amenity_id');
    }
}
