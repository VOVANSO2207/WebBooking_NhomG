<?php

namespace Database\Seeders;

use App\Models\RoomAmenities;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomAmenitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      RoomAmenities::insert([
            ['room_id' => 1, 'amenity_name' => 'Điều Hòa', 'description' => 'Hệ thống điều hòa không khí mát mẻ và thoải mái.'],
            ['room_id' => 1, 'amenity_name' => 'WiFi Miễn Phí', 'description' => 'Truy cập internet không dây tốc độ cao.'],
            ['room_id' => 1, 'amenity_name' => 'Truyền Hình', 'description' => 'TV màn hình phẳng với các kênh cáp.'],
            ['room_id' => 2, 'amenity_name' => 'Minibar', 'description' => 'Minibar được cung cấp đầy đủ đồ ăn nhẹ và đồ uống.'],
            ['room_id' => 2, 'amenity_name' => 'Dịch Vụ Phòng', 'description' => 'Dịch vụ phòng 24 giờ có sẵn.'],
            ['room_id' => 3, 'amenity_name' => 'Bao Gồm Bữa Sáng', 'description' => 'Bữa sáng miễn phí được bao gồm trong thời gian lưu trú.'],
            ['room_id' => 3, 'amenity_name' => 'Truy Cập Phòng Tập', 'description' => 'Truy cập vào trung tâm thể dục trong suốt thời gian lưu trú.'],
            ['room_id' => 4, 'amenity_name' => 'Hồ Bơi', 'description' => 'Truy cập vào hồ bơi ngoài trời.'],
            ['room_id' => 4, 'amenity_name' => 'Dịch Vụ Giặt Là', 'description' => 'Dịch vụ giặt là có sẵn theo yêu cầu.'],
            ['room_id' => 5, 'amenity_name' => 'Đỗ Xe', 'description' => 'Đỗ xe miễn phí cho khách.'],
        ]);
        
    }
}
