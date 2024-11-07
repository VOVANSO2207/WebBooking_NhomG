<?php

namespace Database\Seeders;

use App\Models\HotelAmenityHotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelAmenityHotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HotelAmenityHotel::insert([
            ['hotel_id' => 1, 'amenity_id' => 1],
            ['hotel_id' => 1, 'amenity_id' => 2],
            ['hotel_id' => 2, 'amenity_id' => 1],
            ['hotel_id' => 2, 'amenity_id' => 3],
            ['hotel_id' => 3, 'amenity_id' => 1],
            ['hotel_id' => 3, 'amenity_id' => 4],
            ['hotel_id' => 4, 'amenity_id' => 2],
            ['hotel_id' => 4, 'amenity_id' => 5],
            ['hotel_id' => 5, 'amenity_id' => 3],
            ['hotel_id' => 5, 'amenity_id' => 4],
        ]);
    }
}
