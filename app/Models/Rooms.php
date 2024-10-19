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
        
    // Định nghĩa mối quan hệ với RoomImage
    public function room_images()
    {
        return $this->hasMany(RoomImages::class, 'room_id', 'room_id');
    }
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
}
