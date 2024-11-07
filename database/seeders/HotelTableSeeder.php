<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // Tạo mảng dữ liệu cho các tiện nghi khách sạn
      Hotel::insert([
            [
                'hotel_name' => 'Khách sạn Sài Gòn Star',
                'location' => 'Quận 1, TP.HCM',
                'city_id' => 1,
                'description' => 'Khách sạn 4 sao tại trung tâm Quận 1 với dịch vụ chất lượng.',
                'rating' => 4.5,
            ],
            [
                'hotel_name' => 'Khách sạn Hà Nội Elegance',
                'location' => 'Hoàn Kiếm, Hà Nội',
                'city_id' => 2,
                'description' => 'Khách sạn boutique tại Hà Nội với view hồ Hoàn Kiếm.',
                'rating' => 4.7,
            ],
            [
                'hotel_name' => 'Khách sạn Đà Nẵng Golden Bay',
                'location' => 'Sơn Trà, Đà Nẵng',
                'city_id' => 3,
                'description' => 'Khách sạn 5 sao với bể bơi vàng 24k, view biển tuyệt đẹp.',
                'rating' => 4.9,
            ],
            [
                'hotel_name' => 'Khách sạn Nha Trang Beach',
                'location' => 'Nha Trang, Khánh Hòa',
                'city_id' => 4,
                'description' => 'Khách sạn ven biển Nha Trang với view nhìn ra biển.',
                'rating' => 4.3,
            ],
            [
                'hotel_name' => 'Khách sạn Phú Quốc Resort',
                'location' => 'Dương Đông, Phú Quốc',
                'city_id' => 5,
                'description' => 'Resort nghỉ dưỡng 5 sao với bãi biển riêng tại Phú Quốc.',
                'rating' => 4.8,
            ],
            [
                'hotel_name' => 'Khách sạn Vinpearl Luxury',
                'location' => 'Vũng Tàu, Bà Rịa - Vũng Tàu',
                'city_id' => 6,
                'description' => 'Khách sạn sang trọng bên bờ biển tại Vũng Tàu.',
                'rating' => 4.6,
            ],
            [
                'hotel_name' => 'Khách sạn Lotte Hà Nội',
                'location' => 'Ba Đình, Hà Nội',
                'city_id' => 2,
                'description' => 'Khách sạn cao cấp tại Hà Nội với view toàn cảnh thành phố.',
                'rating' => 4.9,
            ],
            [
                'hotel_name' => 'Khách sạn Hội An Heritage',
                'location' => 'Hội An, Quảng Nam',
                'city_id' => 7,
                'description' => 'Khách sạn 4 sao với kiến trúc cổ kính đặc trưng của Hội An.',
                'rating' => 4.4,
            ],
            [
                'hotel_name' => 'Khách sạn Sapa Paradise',
                'location' => 'Sapa, Lào Cai',
                'city_id' => 8,
                'description' => 'Khách sạn trên núi với view nhìn ra ruộng bậc thang và thung lũng.',
                'rating' => 4.6,
            ],
            [
                'hotel_name' => 'Khách sạn Hạ Long Bay View',
                'location' => 'Hạ Long, Quảng Ninh',
                'city_id' => 9,
                'description' => 'Khách sạn với view nhìn ra vịnh Hạ Long nổi tiếng.',
                'rating' => 4.7,
            ],
        ]);
    }
}
