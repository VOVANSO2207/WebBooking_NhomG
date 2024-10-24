<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    // Đặt tên bảng (nếu khác với tên mặc định)
    protected $table = 'roles';

    // Đặt primary key (nếu khác với tên mặc định)
    protected $primaryKey = 'role_id';

    // Cho phép chỉ định hàng loạt
    protected $fillable = ['role_name'];

    // Nếu role_id không tự động tăng (nếu sử dụng kiểu UUID hoặc kiểu khác), thêm thuộc tính này
    public $incrementing = true;

    // Kiểu dữ liệu primary key (nếu không phải là int)
    protected $keyType = 'int';
}
