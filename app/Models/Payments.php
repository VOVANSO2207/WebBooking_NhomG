<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'payment_status',
        'payment_method',
        'amount',
        'payment_date',
    ];

    protected $primaryKey = 'payment_id';
    public $timestamps = false;
}
