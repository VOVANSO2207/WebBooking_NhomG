<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelAmenities extends Model
{
    use HasFactory;

    protected $table = 'hotel_amenities';
    protected $primaryKey = 'amenity_id';

    protected $fillable = [
        'hotel_id',
        'amenity_name',
        'description',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'hotel_id');
    }
}
