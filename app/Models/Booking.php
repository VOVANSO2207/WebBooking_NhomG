<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'promotion_id',
        'check_in',
        'check_out',
        'total_price',
        'status',
    ];

    protected $primaryKey = 'booking_id';

    public static function getAllBookings($perPage = 5)
    {
        return self::orderBy('created_at', 'DESC')->paginate($perPage);
    }

    public static function findBookingById($booking_id)
    {
        return self::where('booking_id', $booking_id)->first();
    }

    public static function createBooking(array $data)
    {
        return self::create($data);
    }

    public static function searchBooking($keyword)
    {
        // Nếu không có từ khóa, trả về tất cả
        if (empty($keyword)) {
            return static::query(); // Trả về tất cả đặt phòng
        }

        return static::where(function ($query) use ($keyword) {
            $query->where('user_id', 'LIKE', "%{$keyword}%")
                  ->orWhere('room_id', 'LIKE', "%{$keyword}%")
                  ->orWhere('promotion_id', 'LIKE', "%{$keyword}%");
        });
    }

    public function deleteBooking()
    {
        return $this->delete();
    }

    // Các quan hệ
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id', 'room_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotions::class, 'promotion_id', 'promotion_id');
    }
}
