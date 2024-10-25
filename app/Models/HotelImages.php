<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelImages extends Model
{
    use HasFactory;
    protected $table = 'hotel_images';
    protected $fillable = ['image_id', 'hotel_id', 'image_url', 'uploaded_at'];
    public $timestamps = false;
}
