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
    public $timestamps = true;
    public function payments()
    {
        return $this->hasMany(Payments::class, 'booking_id', 'booking_id');
    }

    public static function getAllBookings($perPage = 7)
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

        return self::query()
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    // Tìm kiếm trên trường 'username' từ bảng 'users' với LIKE
                    $q->whereHas('user', function ($queryUser) use ($keyword) {
                        $queryUser->where('username', 'LIKE', "%{$keyword}%")
                            ->orWhere('email', 'LIKE', "%{$keyword}%"); // Thêm tìm kiếm email
                    })
                        // Tìm kiếm trên trường 'name' từ bảng 'rooms'
                        ->orWhereHas('room', function ($queryRoom) use ($keyword) {
                        $queryRoom->where('name', 'LIKE', "%{$keyword}%");
                    })
                        // Tìm kiếm trên trường 'promotion_code' từ bảng 'promotions'
                        ->orWhereHas('promotion', function ($queryPromo) use ($keyword) {
                        $queryPromo->where('promotion_code', 'LIKE', "%{$keyword}%");
                    });
                });
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
