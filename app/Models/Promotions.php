<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
    use HasFactory;

    protected $table = 'promotions'; // Tên bảng
    protected $primaryKey = 'promotion_id'; // Khóa chính

    // Nếu bảng không sử dụng timestamps
    public $timestamps = false;

    // Các cột có thể gán giá trị hàng loạt
    protected $fillable = [
        'promotion_code',
        'discount_amount',
        'start_date',
        'end_date',
    ];

    // Quan hệ với bảng Rooms
    public function room()
    {
        return $this->belongsTo(Rooms::class, 'promotion_id', 'room_id');
    }

    // Lấy tất cả các khuyến mãi, sắp xếp theo ngày tạo
    public static function getAllPromotions($perPage = 5)
    {
        return self::orderBy('start_date', 'DESC')->paginate($perPage);
    }

    // Tìm khuyến mãi theo ID
    public static function findPromotionById($promotion_id)
    {
        return self::where('promotion_id', $promotion_id)->first();
    }

    // Tạo khuyến mãi mới
    public static function createPromotion(array $data)
    {
        return self::create($data);
    }

    // Tìm kiếm khuyến mãi theo mã khuyến mãi hoặc số tiền giảm giá
    public static function searchPromotion($keyword)
    {
        // Nếu không có từ khóa, trả về tất cả
        if (empty($keyword)) {
            return static::query(); // Trả về tất cả khuyến mãi
        }

        return static::where(function ($query) use ($keyword) {
            $query->where('promotion_code', 'LIKE', "%{$keyword}%")
                  ->orWhere('discount_amount', 'LIKE', "%{$keyword}%");
        });
    }

    // Xóa khuyến mãi
    public function deletePromotion()
    {
        return $this->delete();
    }
}
