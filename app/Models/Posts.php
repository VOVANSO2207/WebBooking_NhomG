<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Helpers\IdEncoder;

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
        $validator = Validator::make($data, [
            'title' => 'required|unique:posts,title|min:30|max:200|regex:/^[^!@#$%^&*()_+=\-{}\[\];:"\'<>,.?\/~`]+$/u|regex:/^(?!.*  )/',
            'description' => 'required|min:50|max:1000',
            'content' => 'required|min:100|max:100000',
            'meta_desc' => 'nullable|min:10|max:50|regex:/^[^!@#$%^&*()_+=\-{}\[\];:"\'<>,.?\/~`]+$/u',
            'status' => 'required|in:0,1',
            'url_seo' => '|unique:posts,title|min:30|max:200',
            'fileUpload' => 'required|image|max:5120',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết',
            'title.unique' => 'Tiêu đề bài viết đã tồn tại',
            'title.min' => 'Tiêu đề bài viết phải trên 30 ký tự',
            'title.max' => 'Tiêu đề bài viết không được quá 200 ký tự',
            'title.regex' => 'Tiêu đề bài viết không hợp lệ',
            'url_seo.unique' => 'Url_seo của bài viết đã tồn tại',
            'url_seo.min' => 'Không hợp lệ',
            'url_seo.max' => 'Không hợp lệ',
            'description.required' => 'Mô tả bài viết không được để trống.',
            'description.max' => 'Mô tả bài viết không quá 1000 ký tự.',
            'description.min' => 'Mô tả bài viết không được dưới 50 ký tự',
            'content.required' => 'Nội dung bài viết không được để trống',
            'content.min' => 'Nội dung bài viết không được dưới 100 ký tự',
            'content.max' => 'Nội dung bài viết được quá 100000 ký tự',
            'meta_desc.min' => 'Từ khoá mô tả bài viết không được dưới 10 ký tự',
            'meta_desc.max' => 'Từ khoá mô tả bài viết không được quá 50 ký tự',
            'meta_desc.regex' => 'Từ khoá mô tả bài viết không chứa kí tự đặc biệt',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'fileUpload.required' => 'Vui lòng chọn hình ảnh',
            'fileUpload.image' => 'Tệp không hợp lệ, chỉ cho phép PNG, JPEG, JPG',
            'fileUpload.max' => 'Dung lượng tệp không được vượt quá 5MB',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $img = null;
        if (isset($data['fileUpload'])) {
            $file = $data['fileUpload'];
            $img = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $img);
        }

        $post = new self();
        $post->title = $data['title'];
        $post->description = $data['description'];
        $post->content = $data['content'];
        $post->meta_desc = $data['meta_desc'] ?? null;
        $post->url_seo = $data['url_seo'] ?? null;
        $post->status = $data['status'] === '1' ? 1 : 0;
        $post->img = $img;
        
        $post->save();

        return $post;
    }
    public static function searchPost($keyword)
    {
        $query = static::query();
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%")
                    ->orWhereRaw('MATCH(title, description) AGAINST (? IN BOOLEAN MODE)', [$keyword]);
            });
        }
        return $query; 
    }
    public static function deletePostById($id)
    {
        $postId = IdEncoder::decodeId($id);

        $post = self::find($postId);
        if ($post) {
            $post->delete();
            return ['success' => true, 'message' => 'Bài viết đã được xóa.'];
        }

        return ['success' => false, 'message' => 'Bài viết không tồn tại.'];
    }
    public static function updatePost($post_id, array $data)
    {
        $post = self::find($post_id);

        if (!$post) {
            return 'Bài viết không tồn tại.';
        }

        if ($post->updated_at != $data['updated_at']) {
            return 'Bài viết đã được cập nhật bởi một người dùng khác. Vui lòng tải lại và thử lại.';
        }

        $validator = Validator::make($data, [
            'title' => 'required|min:30|max:200|regex:/^[^!@#$%^&*()_+=\-{}\[\];:"\'<>,.?\/~`]+$/u|regex:/^(?!.*  )/',
            'description' => 'required|min:50|max:1000',
            'content1' => 'required|min:100|max:100000',
            'meta_desc' => 'nullable|min:10|max:50|regex:/^[^!@#$%^&*()_+=\-{}\[\];:"\'<>,.?\/~`]+$/u',
            'status' => 'required|in:0,1',
            'url_seo' => '|unique:posts,title|min:30|max:200',
            'fileUpload' => 'nullable|image|max:1024',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết',
            'title.min' => 'Tiêu đề bài viết phải trên 30 ký tự',
            'title.max' => 'Tiêu đề bài viết không được quá 200 ký tự',
            'title.regex' => 'Tiêu đề bài viết không hợp lệ',
            'description.required' => 'Mô tả bài viết không được để trống.',
            'description.max' => 'Mô tả không quá 1000 ký tự.',
            'description.min' => 'Mô tả bài viết không được dưới 50 ký tự',
            'url_seo.unique' => 'Url_seo của bài viết đã tồn tại',
            'url_seo.min' => 'Không hợp lệ',
            'url_seo.max' => 'Không hợp lệ',
            'content1.required' => 'Nội dung bài viết không được để trống',
            'content1.min' => 'Nội dung bài viết không được dưới 100 ký tự',
            'content1.max' => 'Nội dung bài viết không được quá 10000 ký tự',
            'meta_desc.min' => 'Từ khoá mô tả bài viết không được dưới 10 ký tự',
            'meta_desc.max' => 'Từ khoá mô tả bài viết không được quá 50 ký tự',
            'meta_desc.regex' => 'Từ khoá mô tả bài viết không chứa kí tự đặc biệt',
            'status.required' => 'Vui lòng chọn trạng thái hiển thị bài viết (show/hidden)',
            'status.in' => 'Trạng thái không hợp lệ.',
            'fileUpload.image' => 'Tệp không hợp lệ, chỉ cho phép PNG, JPEG, JPG',
            'fileUpload.max' => 'Dung lượng tệp không được vượt quá 1MB',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $post->title = $data['title'];
        $post->description = $data['description'];
        $post->content = $data['content1'];
        $post->meta_desc = $data['meta_desc'];
        $post->url_seo = $data['url_seo'];
        $post->status = $data['status'];

        if (isset($data['fileUpload'])) {
            $file = $data['fileUpload'];
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);

            if ($post->img && file_exists(public_path('images/' . $post->img))) {
                unlink(public_path('images/' . $post->img));
            }

            $post->img = $filename;
        }

        $post->save();

        return $post; 
    }
    public static function getViewBlogs($perPage = 6)
    {
        return self::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

}
