<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // Tên bảng
    protected $table = 'users';

    // Khóa chính của bảng
    protected $primaryKey = 'user_id';

    // Các trường được phép fill vào
    protected $fillable = [
        'username',
        'email',
        'password',
        'phone_number',
        'role_id',
        'status',
        'avatar',
    ];

    // Ẩn các trường khi trả về JSON
    protected $hidden = [
        'password',
    ];

    // Tự động thêm created_at và updated_at
    public $timestamps = true;
}
