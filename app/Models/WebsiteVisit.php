<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteVisit extends Model
{
    use HasFactory;

    protected $fillable = ['visit_date', 'count']; // Các cột có thể được gán hàng loạt
}


