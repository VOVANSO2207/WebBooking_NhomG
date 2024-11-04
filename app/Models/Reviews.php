<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $primaryKey = 'review_id'; // Nếu bạn sử dụng room_id làm khóa chính
    public $timestamps = true;
    protected $fillable = ['hotel_id', 'user_id', 'rating', 'comment'];
    
    public static function hotelsWithMostReviews($limit = 10)
    {
        return self::select('hotel_id')
                    ->selectRaw('COUNT(*) as review_count')
                    ->groupBy('hotel_id')
                    ->orderBy('review_count', 'desc')
                    ->limit($limit)
                    // ->pluck('hotel_id')
                    ->with('hotel')
                    ->get(); // Trả về danh sách hotel_id
    }
}
