<?php

namespace App\Http\Controllers;
use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function viewPost()
    {
        $posts = Posts::getAllPosts();
        return view('admin.post', compact('posts'));
    }
    public function postAdd()
    {
        return view('admin.post_add');
    }
    public function getPostDetail($post_id)
    {
        $post = Posts::findPostById($post_id);

        if (!$post) {
            return response()->json(['error' => 'Bài viết không tồn tại'], 404);
        }

        return response()->json([
            'title' => $post->title,
            'description' => $post->description,
            'content' => $post->content,
            'meta_desc' => $post->meta_desc,
            'url_seo' => $post->url_seo,
            'status' => $post->status,
            'img' => $post->img
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:30|max:100|regex:/^[^!@#$%^&*()_+=\-{}\[\];:"\'<>,.?\/~`]+$/u|regex:/^(?!.*  )/', 
            'description' => 'required|min:50|max:1000',
            'content1' => 'required|min:100|max:10000',
            'meta_desc' => 'nullable|min:10|max:50|regex:/^[^!@#$%^&*()_+=\-{}\[\];:"\'<>,.?\/~`]+$/u',
            'status' => 'required|boolean',
            'fileUpload' => 'required|image|max:10240', 
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết',
            'title.min' => 'Tiêu đề bài viết phải trên 30 ký tự',
            'title.max' => 'Tiêu đề bài viết không được quá 100 ký tự',
            'title.regex' => 'Tiêu đề bài viết không hợp lệ',
            'description.required' => 'Mô tả là bắt buộc.',
            'description.max' => 'Mô tả không quá 1000 ký tự.',
            'description.min' => 'Mô tả bài viết không được dưới 50 ký tự',
            'content1.required' => 'Nội dung bài viết không được để trống',
            'content1.min' => 'Nội dung bài viết không được dưới 100 ký tự',
            'content1.max' => 'Nội dung bài viết được quá 10000 ký tự',
            'meta_desc.min' => 'Từ khoá mô tả bài viết không được dưới 10 ký tự',
            'meta_desc.max' => 'Từ khoá mô tả bài viết không được quá 50 ký tự',
            'meta_desc.regex' => 'Từ khoá mô tả bài viết không chứa kí tự đặc biệt',
            'status.required' => 'Trạng thái là bắt buộc.',
            'fileUpload.required' => 'Vui lòng chọn hình ảnh',
            'fileUpload.image' => 'Tệp không hợp lệ, chỉ cho phép PNG, JPEG, JPG',
            'fileUpload.max' => 'Dung lượng tệp không được vượt quá 10MB',
        ]);
    
        // Tạo một instance mới của Posts
        $post = new Posts();

        // Gán các giá trị từ request
        $post->title = $request->title;
        $post->description = $request->description;
        $post->content = $request->content1; 
        $post->meta_desc = $request->meta_desc;
        $post->url_seo = $request->url_seo;
        $post->status = $request->status === '1' ? 1 : 0;

        // Kiểm tra fileUpload
        if ($request->hasFile('fileUpload')) {
            $file = $request->file('fileUpload');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $post->img = $filename; 
        }

        Posts::createPost($post->toArray()); 

        return redirect()->route('admin.viewpost')->with('success', 'Thêm bài viết thành công.');
    }
    public function search(Request $request)
    {
        $keyword = $request->get('search');
        $results = Posts::searchPost($keyword)->paginate(5); 

        return view('admin.search_results_post', compact('results'));
    }
    public function deletePost($post_id)
    {
        $post = Posts::find($post_id);

        if (!$post) {
            return response()->json(['error' => 'Bài viết không tồn tại'], 404);
        }

        $post->deletePost();

        return response()->json(['success' => 'Bài viết đã được xóa thành công'], 200);
    }

}
