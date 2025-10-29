<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            NotificationsTableSeeder::class,
            HotelTableSeeder::class,
            ReviewsTableSeeder::class,
            FavoriteHotelTableSeeder::class,
            HotelAmenitiesTableSeeder::class,
            OrderHistoryTableSeeder::class,
            PaymentsTableSeeder::class,
            PostsTableSeeder::class,
            PromotionsTableSeeder::class,
            ReviewImagesTableSeeder::class,
            ReviewsTableSeeder::class,
            RolesTableSeeder::class,
            RoomAmenitiesTableSeeder::class,
            RoomImageTableSeeder::class,
            RoomsTableSeeder::class,
            RoomTypeTableSeeder::class,
            HotelImageTableSeeder::class,
            BookingTableSeeder::class,
            CitiesTableSeeder::class,
        ]);

    }
}
