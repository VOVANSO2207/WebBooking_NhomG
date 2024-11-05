<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelAmenities extends Model
{
    use HasFactory;

    protected $table = 'hotel_amenities';
    protected $primaryKey = 'amenity_id';

    protected $fillable = [
        'amenity_name',
        'description',
    ];

    public $timestamps = false; // Không sử dụng cột created_at và updated_at

    // Lấy danh sách tất cả các tiện ích
    public static function getAllAmenities($perPage = 5)
    {
        return self::orderBy('amenity_id', 'DESC')->paginate($perPage); // Sử dụng amenity_id để sắp xếp
    }

    // Tìm tiện ích theo ID
    public static function findAmenityById($amenity_id)
    {
        return self::where('amenity_id', $amenity_id)->first();
    }

    // Tạo tiện ích mới
    public static function createAmenity(array $data)
    {
        return self::create($data);
    }

    // Tìm kiếm tiện ích theo tên hoặc mô tả
    public static function searchAmenity($keyword)
    {
        if (empty($keyword)) {
            return static::query(); // Trả về tất cả tiện ích nếu không có từ khóa
        }

        return static::where(function ($query) use ($keyword) {
            $query->where('amenity_name', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%");
        });
    }

    // Xóa tiện ích
    public function deleteAmenity()
    {
        return $this->delete();
    }

    // public static function getAllAmenities()
    // {
    //     return self::all();
    // }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'hotel_amentities'); // Use your actual pivot table name here
    }
}
