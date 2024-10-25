<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HotelImages;

class Hotel extends Model
{
    use HasFactory;

    // Chỉ định tên bảng nếu nó khác với quy tắc mặc định
    //  protected $table = 'your_custom_table_name';
    protected $table = 'hotels'; // Tên bảng
    protected $primaryKey = 'hotel_id'; // Khóa chính

    // Nếu không có timestamps trong bảng:
    public $timestamps = false;

    // Khai báo các trường được phép fill
    protected $fillable = ['hotel_name', 'location', 'city_id', 'description', 'rating'];
    public function images()
    {
        return $this->hasMany(HotelImages::class, 'hotel_id');
    }
}
