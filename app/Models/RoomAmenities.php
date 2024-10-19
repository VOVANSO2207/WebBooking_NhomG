<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAmenities extends Model
{
    use HasFactory;
    protected $table = 'room_amenities';
    protected $fillable = ['amenity_id','room_id', 'amenity_name','description'];
    public $timestamps = false;
     // Một tiện nghi thuộc về một phòng
     public function room()
     {  
         return $this->belongsTo(Rooms::class, 'room_id');
     }
   
   
}
