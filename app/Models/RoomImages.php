<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImages extends Model
{
    use HasFactory;
    protected $table = 'room_images';


      // Một hình ảnh thuộc về một phòng
      public function room()
      {
          return $this->belongsTo(Rooms::class, 'room_id');
      }
}
