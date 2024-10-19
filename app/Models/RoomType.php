<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;
    protected $table = 'room_types';
    protected $primaryKey = 'room_type_id';
    
      // Một loại phòng có nhiều phòng
      public function rooms()
      {
          return $this->hasMany(Rooms::class, 'room_type_id'); // Liên kết về phòng
      }
}
