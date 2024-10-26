<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Auth\Authenticatable; 
use Illuminate\Auth\Authenticatable as AuthenticatableTrait; 

class User extends Model implements Authenticatable // Thêm giao diện
{
    use HasFactory, AuthenticatableTrait; // Thêm trait

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

    public static function getAllUsers($perPage = 5)
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
    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }
    // Ẩn các trường khi trả về JSON
    protected $hidden = [
        'password',
    ];

    // Tự động thêm created_at và updated_at
    public $timestamps = true;

    // Mã hóa mật khẩu trước khi lưu vào database
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public static function register($data)
    {
        // Tạo người dùng mới
        return self::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'], // Sử dụng mutator để mã hóa
            'phone_number' => $data['phone_number'],
            'role_id' => $data['role_id'] ?? 2, // Mặc định role là 2
            'status' => $data['status'] ?? 1,  // Mặc định trạng thái là hoạt động
            'avatar' => $data['avatar'] ?? 'default-avatar.png',
        ]);
    }
   
    public static function login($data)
    {
        $validator = Validator::make($data, [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        
        $user = self::where('username', $data['login'])
                    ->orWhere('email', $data['login'])
                    ->first();
        
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['Thông tin đăng nhập không chính xác.'],
            ]);
        }
            
        if ($user->status != 1) {
            throw ValidationException::withMessages([
                'status' => ['Tài khoản của bạn đã bị khóa hoặc không hoạt động.'],
            ]);
        }

        return $user;
    }
}
