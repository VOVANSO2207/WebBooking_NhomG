<?php

namespace Database\Seeders;

use App\Models\FavoriteHotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteHotelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FavoriteHotel::insert([
            [
                'user_id' => 1, // ID của người dùng
                'hotel_id' => 2, // ID của khách sạn
            ],
            [
                'user_id' => 2,
                'hotel_id' => 3,
            ],
            [
                'user_id' => 3,
                'hotel_id' => 1,
            ],
            [
                'user_id' => 4,
                'hotel_id' => 2,
            ],
            [
                'user_id' => 5,
                'hotel_id' => 5,

            ],
            [
                'user_id' => 6,
                'hotel_id' => 3,
            ],
            [
                'user_id' => 7,
                'hotel_id' => 4,
            ],
            [
                'user_id' => 8,
                'hotel_id' => 1,
            ],
            [
                'user_id' => 9,
                'hotel_id' => 5,
            ],
            [
                'user_id' => 10,
                'hotel_id' => 6,
            ],
        ]);

    }
}
