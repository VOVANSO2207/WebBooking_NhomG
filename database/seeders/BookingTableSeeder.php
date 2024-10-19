<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Booking::insert([
            [
                'user_id' => 1,
                'room_id' => 1, // Đặt giá trị nhỏ hơn
                'promotion_id' => 1,
                'check_in' => '2024-10-10',
                'check_out' => '2024-10-15',
                'total_price' => 5000000.00,
                'status' => 'confirmed',
            ],
            [
                'user_id' => 2,
                'room_id' => 2, // Đặt giá trị nhỏ hơn
                'promotion_id' => 2,
                'check_in' => '2024-10-05',
                'check_out' => '2024-10-10',
                'total_price' => 4500000.00,
                'status' => 'cancelled',
            ],
            [
                'user_id' => 3,
                'room_id' => 3, // Đặt giá trị nhỏ hơn
                'promotion_id' => 3,
                'check_in' => '2024-09-25',
                'check_out' => '2024-09-30',
                'total_price' => 6000000.00,
                'status' => 'pending',
            ],
            [
                'user_id' => 4,
                'room_id' => 4, // Đặt giá trị nhỏ hơn
                'promotion_id' => 4,
                'check_in' => '2024-08-20',
                'check_out' => '2024-08-25',
                'total_price' => 5500000.00,
                'status' => 'confirmed',
            ],
            [
                'user_id' => 5,
                'room_id' => 5, // Đặt giá trị nhỏ hơn
                'promotion_id' => 5,
                'check_in' => '2024-07-15',
                'check_out' => '2024-07-20',
                'total_price' => 4000000.00,
                'status' => 'completed',
            ],
            [
                'user_id' => 6,
                'room_id' => 6, // Đặt giá trị nhỏ hơn
                'promotion_id' => 6,
                'check_in' => '2024-06-05',
                'check_out' => '2024-06-10',
                'total_price' => 3500000.00,
                'status' => 'confirmed',
            ],
            [
                'user_id' => 7,
                'room_id' => 7, // Đặt giá trị nhỏ hơn
                'promotion_id' => 7,
                'check_in' => '2024-05-01',
                'check_out' => '2024-05-05',
                'total_price' => 5000000.00,
                'status' => 'completed',
            ],
            [
                'user_id' => 8,
                'room_id' => 8, // Đặt giá trị nhỏ hơn
                'promotion_id' => 8,
                'check_in' => '2024-04-15',
                'check_out' => '2024-04-20',
                'total_price' => 3000000.00,
                'status' => 'cancelled',
            ],
            [
                'user_id' => 9,
                'room_id' => 9, // Đặt giá trị nhỏ hơn
                'promotion_id' => 9,
                'check_in' => '2024-03-01',
                'check_out' => '2024-03-05',
                'total_price' => 2500000.00,
                'status' => 'pending',
            ],
            [
                'user_id' => 10,
                'room_id' => 10, // Đặt giá trị nhỏ hơn
                'promotion_id' => 10,
                'check_in' => '2024-02-20',
                'check_out' => '2024-02-25',
                'total_price' => 6000000.00,
                'status' => 'completed',
            ],
        ]);
    }
}
