<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
        'phone_number',
        'role_id',
        'status',
        'avatar',
    ];

    protected $primaryKey = 'user_id';

    public static function getAllUsers($perPage = 10)
    {
        return self::orderBy('created_at', 'DESC')->paginate($perPage);
    }

    public static function findUserById($user_id)
    {
        return self::where('user_id', $user_id)->first();
    }

    public static function createUser(array $data)
    {
        return self::create($data);
    }

    public static function searchUser($keyword)
    {
        if (empty($keyword)) {
            return static::query(); // Trả về tất cả người dùng
        }

        return static::where(function ($query) use ($keyword) {
            $query->where('username', 'LIKE', "%{$keyword}%")
                  ->orWhere('email', 'LIKE', "%{$keyword}%")
                  ->orWhere('phone_number', 'LIKE', "%{$keyword}%");
        });
    }

    public function deleteUser()
    {
        return $this->delete();
    }
}
