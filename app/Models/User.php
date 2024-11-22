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

    public static function registerUser($data)
    {
        // Xác thực dữ liệu
        $validatedData = Validator::make($data, [
            'username' => 'required|string|max:25|unique:users,username',
            'email' => 'required|string|email|max:255|min:5|regex:/^[^@.]+@[A-Za-z0-9-]+\.[A-Za-z0-9-]+$/|unique:users,email',
            'phone_number' => 'required|string|regex:/^0[0-9]{9}$/',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập.',
            'username.max' => 'Tên đăng nhập không được vượt quá 25 ký tự.',
            'username.unique' => 'Tên đăng nhập đã tồn tại, vui lòng chọn tên khác.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.max' => 'Địa chỉ email không được dài quá 255 ký tự.',
            'email.min' => 'Địa chỉ email phải từ 5 ký tự trở lên.',
            'email.regex' => 'Địa chỉ email không đúng định dạng.',
            'email.unique' => 'Địa chỉ email này đã được sử dụng, vui lòng chọn email khác.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'phone_number.regex' => 'Số điện thoại hợp lệ là ký tự số bắt đầu bằng 0 và có 10 chữ số.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Vui lòng xác nhận lại mật khẩu.',
        ]);

        if ($validatedData->fails()) {
            throw new \Exception('Dữ liệu không hợp lệ');
        }
        
        // Tạo người dùng mới
        return self::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'], // Sử dụng mutator để mã hóa
            'phone_number' => $data['phone_number'],
            'role_id' => $data['role_id'] ?? 2, // Mặc định role là 2
            'status' => $data['status'] ?? 1,  // Mặc định trạng thái là hoạt động
            'avatar' => $data['avatar'] ?? 'user-profile.png',
        ]);
    }

    public static function authenticate(array $credentials)
    {
        // Validate dữ liệu
        $validator = Validator::make($credentials, [
            'login' => [
                'required',
                'string',
                'max:254',
                function ($attribute, $value, $fail) {
                    // Nếu không phải là email (không chứa '@'), cho phép tên người dùng không có ký tự '@'
                    if (!str_contains($value, '@')) {
                        // Kiểm tra cho phép tên người dùng hoặc email
                        $userExists = self::where('username', $value)->orWhere('email', $value)->exists();
                        if (!$userExists) {
                            $fail('Thông tin đăng nhập không chính xác.');
                        }
                    } else {
                        // Kiểm tra có tên miền sau '@'
                        if (!preg_match('/@.+\./', $value)) {
                            $fail('Vui lòng nhập tên miền cho địa chỉ email (VD: gmail.com).');
                        }
                        // Kiểm tra định dạng email
                        elseif (!preg_match('/^[\w\.\-]+@[a-zA-Z\d\-]+\.[a-zA-Z]{2,}(\.[a-zA-Z]{2,})?$/', $value)) {
                            $fail('Địa chỉ email không hợp lệ. Vui lòng kiểm tra lại.');
                        }
                    }
                },
            ],
            'password' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Kiểm tra nếu mật khẩu chỉ chứa khoảng trắng
                    if (trim($value) === '') {
                        $fail('Vui lòng nhập mật khẩu.');
                    }
                },
            ],
        ]);
        
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Tìm người dùng theo login (email hoặc username)
        $user = self::where('username', $credentials['login'])
            ->orWhere('email', $credentials['login'])
            ->first();
        
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
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

    public function favorites()
    {
        return $this->belongsToMany(Hotel::class, 'favorite_hotels');
    }


    public function updateProfileUser($data, $userId = null)
    {
    try {
        // Nếu không truyền userId thì lấy id của user hiện tại
        $userId = $userId ?? auth()->id();
        
        $user = self::findOrFail($userId);
        
        // Validate email unique nếu email thay đổi
        // if (isset($data['email']) && $data['email'] !== $user->email) {
        //     $existingEmail = self::where('email', $data['email'])
        //                         ->where('id', '!=', $userId)
        //                         ->exists();
        //     if ($existingEmail) {
        //         throw new \Exception('Email đã tồn tại trong hệ thống.');
        //     }
        // }

        // Validate phone unique nếu phone thay đổi  
        if (isset($data['phone_number']) && $data['phone_number'] !== $user->phone_number) {
            $existingPhone = self::where('phone_number', $data['phone_number'])
                                ->where('user_id', '!=', $userId)
                                ->exists();
            if ($existingPhone) {
                throw new \Exception('Số điện thoại đã tồn tại trong hệ thống.');
            }
        }

        // Xử lý upload avatar nếu có
        if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
            // Xóa avatar cũ nếu có
            if ($user->avatar && file_exists(public_path('storage/images/' . $user->avatar))) {
                unlink(public_path('storage/images/' . $user->avatar));
            }

            // Upload avatar mới
            $avatar = $data['avatar'];
            $filename = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('storage/images'), $filename);
            $data['avatar'] = $filename;
        }
        // Cập nhật thông tin user
        $user->update([
            // 'username' => $data['username'] ?? $user->username,
            // 'email' => $data['email'] ?? $user->email,
            'phone_number' => $data['phone_number'] ?? $user->phone_number,
            'avatar' => $data['avatar'] ?? $user->avatar,
        ]);

        return true;

    } catch (\Exception $e) {
        // Log lỗi nếu cần
        // \Log::error('Error updating user profile: ' . $e->getMessage());
        throw $e;
    }
}
}
