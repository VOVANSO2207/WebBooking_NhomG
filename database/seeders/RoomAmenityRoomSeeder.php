<?php

namespace Database\Seeders;
use App\Models\RoomAmenityRoom;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomAmenityRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoomAmenityRoom::insert([
            ['room_id' => 1, 'amenity_id' => 1],
            ['room_id' => 1, 'amenity_id' => 2],
            ['room_id' => 1, 'amenity_id' => 3],
            ['room_id' => 2, 'amenity_id' => 1],
            ['room_id' => 2, 'amenity_id' => 4],
            ['room_id' => 3, 'amenity_id' => 2],
            ['room_id' => 3, 'amenity_id' => 3],
            ['room_id' => 4, 'amenity_id' => 4],
            ['room_id' => 4, 'amenity_id' => 1],
            ['room_id' => 5, 'amenity_id' => 5],
        ]);
    }
}

