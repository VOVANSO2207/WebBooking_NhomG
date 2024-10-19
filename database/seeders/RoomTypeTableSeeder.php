<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       RoomType::insert([
            [
                'name' => 'Phòng Đơn',
            ],
            [
                'name' => 'Phòng Đôi',
            ],
            [
                'name' => 'Phòng Gia Đình',
            ],
            [
                'name' => 'Phòng Sang Trọng',
            ],
            [
                'name' => 'Phòng Superior',
            ],
            [
                'name' => 'Phòng Executive',
            ],
            [
                'name' => 'Phòng Deluxe',
            ],
            [
                'name' => 'Phòng Kinh Tế',
            ],
            [
                'name' => 'Phòng Cổ Điển',
            ],
            [
                'name' => 'Phòng Hiện Đại',
            ],
        ]);
    }
}
