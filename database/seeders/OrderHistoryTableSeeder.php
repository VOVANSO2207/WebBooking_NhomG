<?php

namespace Database\Seeders;

use App\Models\OrderHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderHistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       OrderHistory::insert([
            [
                'user_id' => 1,
                'booking_id' => 1, // Đảm bảo booking_id tồn tại
            ],
            [
                'user_id' => 2,
                'booking_id' => 2, // Đảm bảo booking_id tồn tại
            ],
            [
                'user_id' => 3,
                'booking_id' => 3, // Đảm bảo booking_id tồn tại
            ],
            [
                'user_id' => 4,
                'booking_id' => 4, // Đảm bảo booking_id tồn tại
            ],
            [
                'user_id' => 5,
                'booking_id' => 5, // Đảm bảo booking_id tồn tại
            ],
            [
                'user_id' => 6,
                'booking_id' => 6, // Đảm bảo booking_id tồn tại
            ],
            [
                'user_id' => 7,
                'booking_id' => 7, // Đảm bảo booking_id tồn tại
            ],
            [
                'user_id' => 8,
                'booking_id' => 8, // Đảm bảo booking_id tồn tại
            ],
            [
                'user_id' => 9,
                'booking_id' => 9, // Đảm bảo booking_id tồn tại
            ],
            [
                'user_id' => 10,
                'booking_id' => 10, // Đảm bảo booking_id tồn tại
            ],
        ]);
    }
}
