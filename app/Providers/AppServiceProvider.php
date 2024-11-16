<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cities;
use App\Models\Hotel;
use App\Models\RoomImages;
use App\Models\HotelImages;
use App\Models\HotelAmenities;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Schema::defaultStringLength(191);
        // Lấy danh sách thành phố và chia sẻ với tất cả các views
        $cities = Cities::all();
        View::share('cities', $cities);

        $room_images = RoomImages::all();
        View::share('room_images', $room_images);

        $hotel_images = HotelImages::all();
        View::share('hotel_images', $hotel_images);

        $get_hotels = Hotel::orderBy('rating', 'desc')->get();
        View::share('get_hotels_desc', $get_hotels);

        $get_hotels = Hotel::orderBy('rating', 'desc')->get();
        View::share('get_hotels_desc', $get_hotels);

        $hotel_amenities_ser = HotelAmenities::all();
        View::share('hotel_amenities_ser', $hotel_amenities_ser);

        // Quy tắc kiểm tra không có khoảng trắng trong email
        Validator::extend('no_spaces_in_email', function ($attribute, $value, $parameters, $validator) {
            return !preg_match('/\s/', $value); // Kiểm tra nếu có khoảng trắng
        });

        // Đếm số lượng khách sạn trong thành phố
        $cityId = '';
        $city = Cities::find($cityId);
        $cityName = $city ? $city->name : ''; // fallback nếu không tìm thấy thành phố

        // Đếm số lượng khách sạn trong thành phố
        $hotelCount = Hotel::where('city_id', $cityId)->count();

        // Chia sẻ với tất cả view
        view()->share('hotelCount', $hotelCount);
        view()->share('cityName', $cityName);

        // Quy tắc kiểm tra tên miền hợp lệ
        Validator::extend('valid_domain', function ($attribute, $value, $parameters, $validator) {
            $emailParts = explode('@', $value);
            if (count($emailParts) != 2) {
                return false;
            }

            $domain = $emailParts[1];

            // Kiểm tra tên miền có tồn tại không
            return checkdnsrr($domain, 'MX');
        });
        // Quy tắc kiểm tra tên miền cấp cao (phần mở rộng)
        Validator::extend('valid_top_level_domain', function ($attribute, $value, $parameters, $validator) {
            $emailParts = explode('@', $value);
            if (count($emailParts) != 2) {
                return false;
            }

            $domain = $emailParts[1];

            // Kiểm tra phần mở rộng tên miền (phần sau dấu chấm)
            return preg_match('/\.[a-zA-Z]{2,}$/', $domain);
        });
    }
}
