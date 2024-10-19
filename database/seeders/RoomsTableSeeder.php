<?php

namespace Database\Seeders;

use App\Models\Rooms;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rooms::insert([
            [
                'hotel_id' => 1,
                'room_type_id' => 1,
                'name' => 'Phòng LabuRa Hải Âu 1',  // Thêm tên phòng
                'price' => 150.00,
                'discount_percent' => 10,
                'capacity' => 2,
                'description' => 'Phòng Deluxe với tầm nhìn ra biển tại Đà Nẵng.',
            ],
            [
                'hotel_id' => 1,
                'room_type_id' => 1,
                'name' => 'Phòng LabuRa Hải Âu 2',  // Thêm tên phòng
                'price' => 100.00,
                'discount_percent' => 5,
                'capacity' => 3,
                'description' => 'Phòng tiêu chuẩn với tầm nhìn ra thành phố Đà Nẵng.',
            ],
            [
                'hotel_id' => 2,
                'room_type_id' => 1,
                'name' => 'Phòng gia đình tại Hà Nội', // Thêm tên phòng
                'price' => 200.00,
                'discount_percent' => 15,
                'capacity' => 4,
                'description' => 'Phòng gia đình có hai giường tại Hà Nội.',
            ],
            [
                'hotel_id' => 2,
                'room_type_id' => 1,
                'name' => 'Phòng sang trọng tại Hà Nội', // Thêm tên phòng
                'price' => 250.00,
                'discount_percent' => 20,
                'capacity' => 5,
                'description' => 'Phòng sang trọng với dịch vụ spa tại Hà Nội.',
            ],
            [
                'hotel_id' => 3,
                'room_type_id' => 1,
                'name' => 'Phòng ấm cúng Hồ Chí Minh', // Thêm tên phòng
                'price' => 120.00,
                'discount_percent' => 10,
                'capacity' => 2,
                'description' => 'Phòng ấm cúng có bữa sáng tại Hồ Chí Minh.',
            ],
            [
                'hotel_id' => 3,
                'room_type_id' => 1,
                'name' => 'Phòng Superior Hồ Chí Minh', // Thêm tên phòng
                'price' => 180.00,
                'discount_percent' => 25,
                'capacity' => 3,
                'description' => 'Phòng Superior với ban công tại Hồ Chí Minh.',
            ],
            [
                'hotel_id' => 4,
                'room_type_id' => 1,
                'name' => 'Phòng Penthouse Nha Trang', // Thêm tên phòng
                'price' => 220.00,
                'discount_percent' => 30,
                'capacity' => 2,
                'description' => 'Phòng Penthouse với tầm nhìn toàn cảnh tại Nha Trang.',
            ],
            [
                'hotel_id' => 4,
                'room_type_id' => 1,
                'name' => 'Phòng kinh tế Nha Trang', // Thêm tên phòng
                'price' => 140.00,
                'discount_percent' => 5,
                'capacity' => 4,
                'description' => 'Phòng kinh tế dành cho khách du lịch tại Nha Trang.',
            ],
            [
                'hotel_id' => 5,
                'room_type_id' => 2,
                'name' => 'Phòng hiện đại Đà Lạt', // Thêm tên phòng
                'price' => 175.00,
                'discount_percent' => 15,
                'capacity' => 3,
                'description' => 'Phòng hiện đại có Wi-Fi miễn phí tại Đà Lạt.',
            ],
            [
                'hotel_id' => 5,
                'room_type_id' => 2,
                'name' => 'Phòng Executive Đà Lạt', // Thêm tên phòng
                'price' => 210.00,
                'discount_percent' => 20,
                'capacity' => 2,
                'description' => 'Phòng Executive có không gian làm việc tại Đà Lạt.',
            ],
        ]);
    }
}
