<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $primaryKey = 'review_id';
    public $timestamps = true;
    protected $fillable = ['hotel_id', 'user_id', 'rating', 'comment'];

    public function setRatingAttribute($value)
    {
        $this->attributes['rating'] = $value ?: 1; // Nếu không có rating thì gán giá trị mặc định là 1
    }
    // Quan hệ với bảng hotels
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'hotel_id');
    }

    // Quan hệ với bảng users

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');  // Đảm bảo 'user_id' là khóa ngoại trong bảng reviews
    }

    // Quan hệ với bảng review_image
    public function images()
    {
        return $this->hasMany(ReviewImages::class, 'review_id', 'review_id');
    }
    
    public function likes()
    {
        return $this->hasMany(ReviewLike::class, 'review_id', 'review_id');
    }
    // Hàm lấy khách sạn có nhiều đánh giá nhất
    public static function hotelsWithMostReviews($limit = 10)
    {
        return self::select('hotel_id')
            ->selectRaw('COUNT(*) as review_count')
            ->groupBy('hotel_id')
            ->orderBy('review_count', 'desc')
            ->with('hotel') // Load dữ liệu khách sạn (nếu có quan hệ)
            ->limit($limit)
            ->get();
    }
}
