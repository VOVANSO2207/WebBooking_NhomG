<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
    protected $table = 'promotions';
    protected $primaryKey = 'promotion_id'; // Đặt tên cột khóa chính

    public function room()
    {
        return $this->belongsTo(Rooms::class, 'promotion_id', 'room_id');
    }
}
