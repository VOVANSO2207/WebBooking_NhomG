<?php

namespace Database\Seeders;

use App\Models\RoomImages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       RoomImages::insert([
            ['room_id' => 1, 'image_url' => 'room1_image1.jpg', 'uploaded_at' => now()],
            ['room_id' => 1, 'image_url' => 'room1_image2.jpg', 'uploaded_at' => now()],
            ['room_id' => 2, 'image_url' => 'room2_image3.jpg', 'uploaded_at' => now()],
            ['room_id' => 2, 'image_url' => 'room2_image4.jpg', 'uploaded_at' => now()],
            ['room_id' => 3, 'image_url' => 'room3_image5.jpg', 'uploaded_at' => now()],
            ['room_id' => 3, 'image_url' => 'room3_image6.jpg', 'uploaded_at' => now()],
            ['room_id' => 4, 'image_url' => 'room4_image7.jpg', 'uploaded_at' => now()],
            ['room_id' => 4, 'image_url' => 'room4_image2.jpg', 'uploaded_at' => now()],
            ['room_id' => 5, 'image_url' => 'room5_image1.jpg', 'uploaded_at' => now()],
            ['room_id' => 5, 'image_url' => 'room5_image2.jpg', 'uploaded_at' => now()],
        ]);
    }
}
