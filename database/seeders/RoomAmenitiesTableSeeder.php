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
            ['amenity_name' => 'Điều Hòa', 'description' => 'Hệ thống điều hòa không khí mát mẻ và thoải mái.'],
            ['amenity_name' => 'WiFi Miễn Phí', 'description' => 'Truy cập internet không dây tốc độ cao.'],
            ['amenity_name' => 'Truyền Hình', 'description' => 'TV màn hình phẳng với các kênh cáp.'],
            ['amenity_name' => 'Minibar', 'description' => 'Minibar được cung cấp đầy đủ đồ ăn nhẹ và đồ uống.'],
            ['amenity_name' => 'Dịch Vụ Phòng', 'description' => 'Dịch vụ phòng 24 giờ có sẵn.'],
            ['amenity_name' => 'Bao Gồm Bữa Sáng', 'description' => 'Bữa sáng miễn phí được bao gồm trong thời gian lưu trú.'],
            ['amenity_name' => 'Truy Cập Phòng Tập', 'description' => 'Truy cập vào trung tâm thể dục trong suốt thời gian lưu trú.'],
            ['amenity_name' => 'Hồ Bơi', 'description' => 'Truy cập vào hồ bơi ngoài trời.'],
            ['amenity_name' => 'Dịch Vụ Giặt Là', 'description' => 'Dịch vụ giặt là có sẵn theo yêu cầu.'],
            ['amenity_name' => 'Đỗ Xe', 'description' => 'Đỗ xe miễn phí cho khách.'],
        ]);
        
    }
}
