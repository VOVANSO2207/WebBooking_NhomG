<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert(
            [
                [
                    'username' => 'john_doe',
                    'email' => 'john@example.com',
                    'password' => bcrypt('password123'), // Mật khẩu đã băm
                    'phone_number' => '0123456789',
                    'role_id' => 2, // Vai trò người dùng
                    'status' => true, // Kích hoạt người dùng
                    'avatar' => 'john_avatar.png',
                ],
                [
                    'username' => 'jane_smith',
                    'email' => 'jane@example.com',
                    'password' => bcrypt('password456'), // Mật khẩu đã băm
                    'phone_number' => '0987654321',
                    'role_id' => 3, // Vai trò người dùng khác
                    'status' => false, // Người dùng chưa được kích hoạt
                    'avatar' => 'jane_avatar.png',
                ],
                [
                    'username' => 'mike_jones',
                    'email' => 'mike@example.com',
                    'password' => bcrypt('password789'),
                    'phone_number' => '0112233445',
                    'role_id' => 2,
                    'status' => true,
                    'avatar' => 'mike_avatar.png',
                ],
                [
                    'username' => 'lisa_williams',
                    'email' => 'lisa@example.com',
                    'password' => bcrypt('password101'),
                    'phone_number' => '0223344556',
                    'role_id' => 3,
                    'status' => true,
                    'avatar' => 'lisa_avatar.png',
                ],
                [
                    'username' => 'susan_brown',
                    'email' => 'susan@example.com',
                    'password' => bcrypt('password202'),
                    'phone_number' => '0334455667',
                    'role_id' => 2,
                    'status' => false,
                    'avatar' => 'susan_avatar.png',

                ],
            ]

        );
    }
}
