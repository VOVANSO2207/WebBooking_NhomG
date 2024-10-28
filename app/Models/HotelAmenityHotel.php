<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelAmenityHotel extends Model
{
    use HasFactory;
    protected $table = 'hotel_amenity_hotel'; // Tên bảng

    // Nếu bảng này không có cột timestamps (created_at, updated_at)
    public $timestamps = false;

    protected $fillable = ['hotel_id', 'amenity_id'];
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'hotel_id');
    }
    // Quan hệ đến RoomAmenities
    public function amenity()
    {
        return $this->belongsTo(HotelAmenities  ::class, 'amenity_id', 'amenity_id');
    }
}
