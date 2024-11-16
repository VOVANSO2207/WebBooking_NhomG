<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_name',
        'location',
        'city_id',
        'description',
        'rating',
    ];

    protected $primaryKey = 'hotel_id';

    // Lấy tất cả khách sạn với phân trang
    public static function getAllHotels($perPage = 5)
    {
        return self::with(['images', 'city'])->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    // Tìm khách sạn theo ID
    public static function findHotelById($hotel_id)
    {
        return self::where('hotel_id', $hotel_id)->first();
    }

    // Tạo khách sạn mới
    public static function createHotel(array $data)
    {
        return self::create($data);
    }

    // Tìm kiếm khách sạn
    public static function searchHotel($keyword)
    {
        if (empty($keyword)) {
            return static::query(); // Trả về tất cả khách sạn
        }

        return static::where(function ($query) use ($keyword) {
            $query->where('hotel_name', 'LIKE', "%{$keyword}%")
                ->orWhere('location', 'LIKE', "%{$keyword}%");
        });
    }

    // Xóa khách sạn
    public function deleteHotel()
    {
        return $this->delete();
    }

    // Quan hệ với bảng HotelImage
    public function images()
    {
        return $this->hasMany(HotelImages::class, 'hotel_id', 'hotel_id');
    }

    // Quan hệ với bảng City
    public function city()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }

    // Quan hệ với bảng HotelAmenities thông qua bảng trung gian hotel_amenity_hotel
    public function amenities()
    {
        return $this->belongsToMany(
            HotelAmenities::class,
            'hotel_amenity_hotel',
            'hotel_id',
            'amenity_id'
        )->select('hotel_amenities.amenity_id', 'hotel_amenities.amenity_name', 'hotel_amenities.description');
    }
    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'hotel_id');
    }
    // Hàm lọc khách sạn theo số lượng đánh giá nhiều nhất


    public function rooms()
    {
        return $this->hasMany(Rooms::class, 'hotel_id', 'hotel_id');
    }
    // Tính tiền
    public function averageRoomPrice()
    {
        return $this->rooms()->avg('price');
    }
    public static function getHotelsWithAverageRoomPrice()
    {
        return self::with('rooms')
            ->get()
            ->map(function ($hotel) {
                // Tính giá trung bình và lưu vào thuộc tính tạm `average_price`
                $hotel->average_price = $hotel->averageRoomPrice();
                return $hotel;
            });
    }
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorite_hotels');
    }
    /**
     * Tính giá gốc trung bình
     */
    public function getAveragePriceAttribute()
    {
        return $this->rooms->avg('price');
    }

    /**
     * Tính phần trăm giảm giá trung bình
     */
    public function getAverageDiscountPercentAttribute()
    {
        return $this->rooms->avg('discount_percent');
    }

    /**
     * Tính giá sale trung bình
     */
    public function getAveragePriceSaleAttribute()
    {
        $averagePrice = $this->average_price;
        $averageDiscountPercent = $this->average_discount_percent;

        return $averagePrice * (1 - $averageDiscountPercent / 100);
    }

    // Phương thức tìm kiếm khách sạn
    public static function searchHotels($cityId, $checkInDate, $checkOutDate, $rooms, $adults, $children)
    {
        $city = Cities::find($cityId);
        $cityName = $city ? $city->city_name : 'Chưa xác định';

        // Đếm số lượng khách sạn tại thành phố
        $hotelCount = self::where('city_id', $cityId)->count();

        // dd($adults . ' ' . $children . ' ' . $adults + $children . ' ' . $rooms . ' ' . $cityId);

        // Tiến hành tìm kiếm các khách sạn
        $hotels = self::where(function ($query) use ($cityId, $checkInDate, $checkOutDate, $adults, $children) {
            $query->where('city_id', $cityId)
                ->whereHas('rooms', function ($query) use ($checkInDate, $checkOutDate, $adults, $children) {
                    $query->where('capacity', '>=', $adults + $children)
                        ->whereDoesntHave('bookings', function ($query) use ($checkInDate, $checkOutDate) {
                            $query->where(function ($q) use ($checkInDate, $checkOutDate) {
                                $q->where('check_in', '<', $checkOutDate)
                                    ->where('check_out', '>', $checkInDate);
                            });
                        });
                });
        })
            ->with([
                'rooms' => function ($query) use ($rooms) {
                    $query->take($rooms)
                    ->with('roomType'); 
                },
            ])
            ->withCount('reviews') 
            ->orderByRaw("CASE WHEN city_id = ? THEN 1 ELSE 2 END", [$cityId]) // Ưu tiên khách sạn có city_id khớp chính xác
            ->get();

        // Trả về cả khách sạn, số lượng khách sạn và tên thành phố
        return [
            'hotels' => $hotels,
            'hotelCount' => $hotelCount,
            'cityName' => $cityName
        ];
    }

    public function getIsFavoriteAttribute()
    {
        if (Auth::check()) {
            return FavoriteHotel::where('user_id', Auth::id())
                ->where('hotel_id', $this->hotel_id)
                ->exists();
        }
        return false;
    }
}
