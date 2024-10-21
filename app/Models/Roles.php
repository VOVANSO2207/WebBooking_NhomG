<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $table = 'roles';

    // Các trường có thể điền vào
    protected $fillable = ['name', 'description'];

    // Quan hệ với bảng users
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
