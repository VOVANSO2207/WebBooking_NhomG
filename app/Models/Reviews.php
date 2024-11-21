<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

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
    public static function createReview($user, $hotel_id, $data, $images = [])
    {
        // Kiểm tra xem người dùng đã đặt phòng tại khách sạn này chưa
        $hasBooking = Booking::where('user_id', $user->user_id)
            ->whereHas('room', function ($query) use ($hotel_id) {
                $query->where('hotel_id', $hotel_id);
            })
            ->exists();

        if (!$hasBooking) {
            return [
                'success' => false,
                'message' => 'Bạn phải đặt phòng tại khách sạn này để có thể bình luận.'
            ];
        }

        // Kiểm tra xem người dùng đã đánh giá khách sạn này chưa
        $hasReviewed = Reviews::where('user_id', $user->user_id)
            ->where('hotel_id', $hotel_id)
            ->exists();

        if ($hasReviewed) {
            return [
                'success' => false,
                'message' => 'Bạn chỉ được đánh giá khách sạn này một lần.'
            ];
        }

        // Validate dữ liệu
        $validator = Validator::make($data, [
            'comment' => 'required|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        }

        // Lưu bình luận vào database
        $review = new Reviews();
        $review->hotel_id = $hotel_id;
        $review->user_id = $user->user_id;
        $review->rating = $data['rating'] ?? null;
        $review->comment = $data['comment'];
        $review->save();

        // Xử lý ảnh tải lên
        foreach ($images as $image) {
            $imageName = Str::random(10) . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('review_images'), $imageName);

            $reviewImage = new ReviewImages();
            $reviewImage->review_id = $review->review_id;
            $reviewImage->image_url = 'review_images/' . $imageName;
            $reviewImage->save();
        }

        return [
            'success' => true,
            'message' => 'Đánh giá của bạn đã được gửi.',
        ];
    }
    public static function deleteReview($review_id, $user)
    {
        // Tìm review theo ID
        $review = self::findOrFail($review_id);

        // Kiểm tra quyền: Người dùng sở hữu hoặc admin
        if ($user->user_id !== $review->user_id && !$user->is_admin) {
            return [
                'success' => false,
                'message' => 'Bạn không có quyền xóa bình luận này.'
            ];
        }

        // Xóa review
        $review->delete();

        return [
            'success' => true,
            'message' => 'Bình luận đã được xóa.'
        ];
    }
    public static function toggleLike($review_id, $user)
    {
        // Kiểm tra xem người dùng đã like bình luận này chưa
        $like = ReviewLike::where('review_id', $review_id)
            ->where('user_id', $user->user_id)
            ->first();

        // Nếu đã like, bỏ like
        if ($like) {
            $like->delete();
            // Cập nhật số lượng like mới
            $likes_count = self::find($review_id)->likes()->count();

            return [
                'success' => true,
                'action' => 'unliked',
                'likes_count' => $likes_count,
                'message' => 'Bạn đã bỏ thích bình luận này.'
            ];
        }

        // Nếu chưa like, thêm like
        ReviewLike::create([
            'review_id' => $review_id,
            'user_id' => $user->user_id,
        ]);

        // Cập nhật số lượng like mới
        $likes_count = self::find($review_id)->likes()->count();

        return [
            'success' => true,
            'action' => 'liked',
            'likes_count' => $likes_count,
            'message' => 'Bạn đã thích bình luận này.'
        ];
    }
}
