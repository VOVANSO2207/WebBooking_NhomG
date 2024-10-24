<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'roles'; // Tên bảng
    protected $primaryKey = 'role_id'; // Đặt khóa chính
    public $incrementing = true; // Nếu role_id tự động tăng
    protected $keyType = 'int'; // Kiểu dữ liệu của khóa chính
    protected $fillable = ['role_name']; // Thuộc tính có thể được gán hàng loạt
}
