<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteHotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'hotel_id',
    ];

    protected $primaryKey = 'favorite_id';
    public $timestamps = true;
    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với Hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
}
