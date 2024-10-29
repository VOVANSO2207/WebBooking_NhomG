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
    public static function findPostById($post_id)
    {
        return self::where('post_id', $post_id)->first();
    }
    public static function createPost(array $data)
    {
        return self::create($data);
    }
    // public static function searchPost($keyword)
    // {
    //     // Nếu không có từ khóa, trả về tất cả
    //     if (empty($keyword)) {
    //         return static::query(); // Trả về tất cả bài viết
    //     }

    //     return static::where(function ($query) use ($keyword) {
    //         $query->where('title', 'LIKE', "%{$keyword}%")
    //               ->orWhere('description', 'LIKE', "%{$keyword}%");
    //     });
    // }
    public static function searchPost($keyword)
    {
        $query = static::query(); // Sử dụng static::query() để giữ nguyên Model và cho phép phân trang

        if (!empty($keyword)) {
            // Thực hiện tìm kiếm
            $query->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%")
                    ->orWhereRaw('MATCH(title, description) AGAINST (? IN BOOLEAN MODE)', [$keyword]);
            });
        }

        return $query; // Trả về Query Builder để có thể phân trang
    }
    public function deletePost()
    {
        return $this->delete();
    }
    public static function getViewBlogs($perPage = 6)
    {
        return self::where('status', 1)->paginate($perPage); // 1 có thể là trạng thái "show"
    }
}
