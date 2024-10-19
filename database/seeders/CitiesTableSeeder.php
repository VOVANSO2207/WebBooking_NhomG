<?php

namespace Database\Seeders;

use App\Models\Cities;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Cities::insert([
            ['city_name' => 'Hà Nội'],
            ['city_name' => 'Hồ Chí Minh'],
            ['city_name' => 'Đà Nẵng'],
            ['city_name' => 'Nha Trang'],
            ['city_name' => 'Huế'],
            ['city_name' => 'Cần Thơ'],
            ['city_name' => 'Vũng Tàu'],
            ['city_name' => 'Đà Lạt'],
            ['city_name' => 'Hạ Long'],
            ['city_name' => 'Biên Hòa'],
        ]);
    }
}
