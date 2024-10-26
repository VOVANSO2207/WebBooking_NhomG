<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_name',
        'location',
        'city_id',
        'description',
        'rating',
    ];

    protected $primaryKey = 'hotel_id';

    // Lấy tất cả khách sạn với phân trang
    public static function getAllHotels($perPage = 5)
    {
        return self::orderBy('created_at', 'DESC')->paginate($perPage);
    }

    // Tìm khách sạn theo ID
    public static function findHotelById($hotel_id)
    {
        return self::where('hotel_id', $hotel_id)->first();
    }

    // Tạo khách sạn mới
    public static function createHotel(array $data)
    {
        return self::create($data);
    }

    // Tìm kiếm khách sạn
    public static function searchHotel($keyword)
    {
        if (empty($keyword)) {
            return static::query(); // Trả về tất cả khách sạn
        }

        return static::where(function ($query) use ($keyword) {
            $query->where('hotel_name', 'LIKE', "%{$keyword}%")
                  ->orWhere('location', 'LIKE', "%{$keyword}%");
        });
    }

    // Xóa khách sạn
    public function deleteHotel()
    {
        return $this->delete();
    }
    // Định nghĩa mối quan hệ với HotelImages
    public function hotelImages()
    {
        return $this->hasMany(HotelImages::class, 'hotel_id', 'hotel_id');
    }
}
