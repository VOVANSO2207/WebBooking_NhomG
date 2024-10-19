<?php

namespace Database\Seeders;

use App\Models\Payments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Payments::insert([
            [
                'booking_id' => 1,
                'payment_status' => 'Completed',
                'amount' => 150.00,
                'payment_date' => now(),
            ],
            [
                'booking_id' => 2,
                'payment_status' => 'Pending',
                'amount' => 200.50,
                'payment_date' => now(),
            ],
            [
                'booking_id' => 3,
                'payment_status' => 'Failed',
                'amount' => 100.75,
                'payment_date' => now(),
            ],
            [
                'booking_id' => 4,
                'payment_status' => 'Completed',
                'amount' => 250.00,
                'payment_date' => now(),
            ],
            [
                'booking_id' => 5,
                'payment_status' => 'Completed',
                'amount' => 300.00,
                'payment_date' => now(),
            ],
            [
                'booking_id' => 6,
                'payment_status' => 'Pending',
                'amount' => 120.00,
                'payment_date' => now(),
            ],
            [
                'booking_id' => 7,
                'payment_status' => 'Completed',
                'amount' => 90.50,
                'payment_date' => now(),
            ],
            [
                'booking_id' => 8,
                'payment_status' => 'Failed',
                'amount' => 180.00,
                'payment_date' => now(),
            ],
            [
                'booking_id' => 9,
                'payment_status' => 'Completed',
                'amount' => 150.25,
                'payment_date' => now(),
            ],
            [
                'booking_id' => 10,
                'payment_status' => 'Pending',
                'amount' => 200.00,
                'payment_date' => now(),
            ],
        ]);
    }
}
