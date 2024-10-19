<?php

namespace Database\Seeders;

use App\Models\HotelImages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      HotelImages::insert([
            [
                'hotel_id' => 1,
                'image_url' => 'images/hotels/hotel1_1.jpg',
            ],
            [
                'hotel_id' => 1,
                'image_url' => 'images/hotels/hotel1_2.jpg',
            ],
            [
                'hotel_id' => 2,
                'image_url' => 'images/hotels/hotel2_1.jpg',
            ],
            [
                'hotel_id' => 2,
                'image_url' => 'images/hotels/hotel2_2.jpg',
            ],
            [
                'hotel_id' => 3,
                'image_url' => 'images/hotels/hotel3_1.jpg',
            ],
            [
                'hotel_id' => 3,
                'image_url' => 'images/hotels/hotel3_2.jpg',
            ],
            [
                'hotel_id' => 4,
                'image_url' => 'images/hotels/hotel4_1.jpg',
            ],
            [
                'hotel_id' => 4,
                'image_url' => 'images/hotels/hotel4_2.jpg',
            ],
            [
                'hotel_id' => 5,
                'image_url' => 'images/hotels/hotel5_1.jpg',
            ],
            [
                'hotel_id' => 5,
                'image_url' => 'images/hotels/hotel5_2.jpg',
            ],
        ]);
    }
}
