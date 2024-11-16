<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewImages extends Model
{
    use HasFactory;

    protected $table = 'review_images';
    protected $primaryKey = 'image_id';
    protected $fillable = ['review_id', 'image_url'];

    public function review()
    {
        return $this->belongsTo(Reviews::class, 'review_id', 'review_id');
    }
}
