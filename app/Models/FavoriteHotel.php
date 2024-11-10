<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteHotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'hotel_id',
    ];

    protected $primaryKey = 'favorite_id';
    public $timestamps = true;
    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với Hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
    /**
     * Thêm khách sạn vào danh sách yêu thích
     */
    public static function addFavorite($userId, $hotelId)
    {
        // Kiểm tra xem khách sạn đã được yêu thích chưa
        $favorite = self::where('user_id', $userId)->where('hotel_id', $hotelId)->first();

        if (!$favorite) {
            // Thêm vào yêu thích
            self::create([
                'user_id' => $userId,
                'hotel_id' => $hotelId,
            ]);

            return ['message' => 'Khách sạn đã được thêm vào yêu thích!', 'status' => 200];
        }

        return ['message' => 'Khách sạn đã được yêu thích trước đó!', 'status' => 409];
    }

    /**
     * Xóa khách sạn khỏi danh sách yêu thích
     */
    public static function removeFavorite($userId, $hotelId)
    {
        // Kiểm tra xem khách sạn đã được yêu thích chưa
        $favorite = self::where('user_id', $userId)->where('hotel_id', $hotelId)->first();

        if ($favorite) {
            // Xóa khỏi yêu thích
            $favorite->delete();

            return ['message' => 'Khách sạn đã bị xóa khỏi yêu thích!', 'status' => 200];
        }

        return ['message' => 'Khách sạn này không có trong danh sách yêu thích của bạn!', 'status' => 404];
    }
    public static function getUserFavorites($userId, $pagination = 2)
    {
        return self::where('user_id', $userId)
            ->with([
                'hotel' => function ($query) {
                    $query->with([
                        'images',
                        'city',
                        'reviews',
                        'rooms' => function ($roomQuery) {
                            $roomQuery->orderBy('price', 'asc')
                            ->with('roomType');; // Get the room with the lowest price
                        }
                    ]);
                }
            ])
            ->paginate($pagination);
    }
}
