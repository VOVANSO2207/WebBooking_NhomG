<?php

namespace Database\Seeders;

use App\Models\ReviewImages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       ReviewImages::insert([
            [
                'review_id' => 1,
                'image_url' => 'review1_image1.jpg',
                'uploaded_at' => now(),
            ],
            [
                'review_id' => 1,
                'image_url' => 'review1_image2.jpg',
                'uploaded_at' => now(),
            ],
            [
                'review_id' => 2,
                'image_url' => 'review2_image1.jpg',
                'uploaded_at' => now(),
            ],
            [
                'review_id' => 2,
                'image_url' => 'review2_image2.jpg',
                'uploaded_at' => now(),
            ],
            [
                'review_id' => 3,
                'image_url' => 'review3_image1.jpg',
                'uploaded_at' => now(),
            ],
            [
                'review_id' => 4,
                'image_url' => 'review4_image1.jpg',
                'uploaded_at' => now(),
            ],
            [
                'review_id' => 4,
                'image_url' => 'review4_image2.jpg',
                'uploaded_at' => now(),
            ],
            [
                'review_id' => 5,
                'image_url' => 'review5_image1.jpg',
                'uploaded_at' => now(),
            ],
            [
                'review_id' => 5,
                'image_url' => 'review5_image2.jpg',
                'uploaded_at' => now(),
            ],
            [
                'review_id' => 6,
                'image_url' => 'review6_image1.jpg',
                'uploaded_at' => now(),
            ],
        ]);
    }
}
