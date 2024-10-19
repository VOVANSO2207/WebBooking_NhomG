<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'content',
        'meta_desc',
        'status',
        'url_seo',
        'img',
    ];
    protected $primaryKey = 'post_id';

    public static function getAllPosts($perPage = 5)
    {
        return self::orderBy('created_at', 'DESC')->paginate($perPage);
    }
}
