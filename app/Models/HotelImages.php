<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelImages extends Model
{
    use HasFactory;

    // Chỉ định tên bảng
    protected $table = 'hotel_images';

    // Chỉ định khóa chính
    protected $primaryKey = 'image_id';

    // Không sử dụng timestamps
    public $timestamps = false;

    // Các trường có thể được gán
    protected $fillable = [
        'hotel_id',
        'image_url',
    ];

    // Thiết lập quan hệ với mô hình Hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'hotel_id');
    }
}
