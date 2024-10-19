<?php

namespace Database\Seeders;

use App\Models\Promotions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromotionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotions::insert([
            [
                'promotion_code' => 'PROMO10',
                'discount_amount' => 10.0,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
            ],
            [
                'promotion_code' => 'SUMMER20',
                'discount_amount' => 20.0,
                'start_date' => now(),
                'end_date' => now()->addDays(60),
            ],
            [
                'promotion_code' => 'WINTER15',
                'discount_amount' => 15.0,
                'start_date' => now(),
                'end_date' => now()->addDays(45),
            ],
            [
                'promotion_code' => 'FALL25',
                'discount_amount' => 25.0,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
            ],
            [
                'promotion_code' => 'NEWYEAR30',
                'discount_amount' => 30.0,
                'start_date' => now(),
                'end_date' => now()->addDays(90),
            ],
            [
                'promotion_code' => 'EASTER5',
                'discount_amount' => 5.0,
                'start_date' => now(),
                'end_date' => now()->addDays(14),
            ],
            [
                'promotion_code' => 'BLACKFRIDAY50',
                'discount_amount' => 50.0,
                'start_date' => now(),
                'end_date' => now()->addDays(5),
            ],
            [
                'promotion_code' => 'CHRISTMAS40',
                'discount_amount' => 40.0,
                'start_date' => now(),
                'end_date' => now()->addDays(25),
            ],
            [
                'promotion_code' => 'VIP20',
                'discount_amount' => 20.0,
                'start_date' => now(),
                'end_date' => now()->addDays(15),
            ],
            [
                'promotion_code' => 'WEEKEND15',
                'discount_amount' => 15.0,
                'start_date' => now(),
                'end_date' => now()->addDays(10),
            ],
        ]);
    }
}
