<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewLike extends Model
{
    protected $table = 'review_likes';
    protected $fillable = ['review_id', 'user_id'];

    public function review()
    {
        return $this->belongsTo(Reviews::class, 'review_id');
    }
}
