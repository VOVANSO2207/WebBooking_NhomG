<?php

namespace Database\Seeders;

use App\Models\HotelAmenities;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelAmenitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       HotelAmenities::insert([
            [
                'hotel_id' => 1,
                'amenity_name' => 'Wi-Fi miễn phí',
                'description' => 'Khách sạn cung cấp Wi-Fi miễn phí tốc độ cao.',
            ],
            [
                'hotel_id' => 2,
                'amenity_name' => 'Hồ bơi ngoài trời',
                'description' => 'Hồ bơi ngoài trời với view biển tuyệt đẹp.',
            ],
            [
                'hotel_id' => 3,
                'amenity_name' => 'Nhà hàng 24/7',
                'description' => 'Nhà hàng phục vụ thực đơn đa dạng, hoạt động suốt 24 giờ.',
            ],
            [
                'hotel_id' => 4,
                'amenity_name' => 'Spa và massage',
                'description' => 'Dịch vụ spa và massage chuyên nghiệp cho khách lưu trú.',
            ],
            [
                'hotel_id' => 5,
                'amenity_name' => 'Phòng tập gym',
                'description' => 'Phòng tập gym đầy đủ trang thiết bị hiện đại.',
            ],
            [
                'hotel_id' => 6,
                'amenity_name' => 'Dịch vụ đưa đón sân bay',
                'description' => 'Dịch vụ đưa đón sân bay miễn phí cho khách lưu trú.',
            ],
            [
                'hotel_id' => 7,
                'amenity_name' => 'Bãi biển riêng',
                'description' => 'Khách sạn có bãi biển riêng chỉ dành cho khách lưu trú.',
            ],
            [
                'hotel_id' => 8,
                'amenity_name' => 'Phòng hội nghị',
                'description' => 'Phòng hội nghị hiện đại với sức chứa lên đến 200 người.',
            ],
            [
                'hotel_id' => 9,
                'amenity_name' => 'Dịch vụ giặt ủi',
                'description' => 'Dịch vụ giặt ủi nhanh chóng, tiện lợi cho khách hàng.',
            ],
            [
                'hotel_id' => 10,
                'amenity_name' => 'Bar trên tầng thượng',
                'description' => 'Bar trên tầng thượng với view toàn cảnh thành phố.',
            ],
        ]);
    }
}
