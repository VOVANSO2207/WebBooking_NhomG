<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cities;
use App\Models\RoomImages;
use App\Models\HotelImages;

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
    }
}
