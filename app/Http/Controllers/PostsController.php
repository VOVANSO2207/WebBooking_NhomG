<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use App\Helpers\IdEncoder;
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
        // Giải mã ID nếu cần
        $decodedId = IdEncoder::decodeId($post_id);
        $post = Posts::findPostById($decodedId);

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
   public function encodeId($id)
    {
        $encodedId = IdEncoder::encodeId($id);
        return response()->json(['encoded_id' => $encodedId]);
    }

    public function decodeId($encodedId)
    { 
        $decodedId = IdEncoder::decodeId($encodedId);
        return response()->json(['decoded_id' => $decodedId]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:30|max:100|regex:/^[^!@#$%^&*()_+=\-{}\[\];:"\'<>,.?\/~`]+$/u|regex:/^(?!.*  )/',
            'description' => 'required|min:50|max:1000',
            'content1' => 'required|min:100|max:100000',
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
            'content1.max' => 'Nội dung bài viết được quá 100000 ký tự',
            'meta_desc.min' => 'Từ khoá mô tả bài viết không được dưới 10 ký tự',
            'meta_desc.max' => 'Từ khoá mô tả bài viết không được quá 50 ký tự',
            'meta_desc.regex' => 'Từ khoá mô tả bài viết không chứa kí tự đặc biệt',
            'status.required' => 'Trạng thái là bắt buộc.',
            'fileUpload.required' => 'Vui lòng chọn hình ảnh',
            'fileUpload.image' => 'Tệp không hợp lệ, chỉ cho phép PNG, JPEG, JPG',
            'fileUpload.max' => 'Dung lượng tệp không được vượt quá 10MB',
        ]);

        $post = new Posts();

        $post->title = $request->title;
        $post->description = $request->description;
        $post->content = $request->content1;
        $post->meta_desc = $request->meta_desc;
        $post->url_seo = $request->url_seo;
        $post->status = $request->status === '1' ? 1 : 0;

        if ($request->hasFile('fileUpload')) {
            $file = $request->file('fileUpload');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $post->img = $filename;
        }
        Posts::createPost($post->toArray());
        return redirect()->route('admin.viewpost')->with('success', 'Thêm bài viết thành công.');
    }

    public function deletePost($id)
    {
        // Giải mã ID nếu bạn đang sử dụng mã hóa
        $postId = IdEncoder::decodeId($id);

        // Tìm bài viết bằng ID và xóa nó
        $post = Posts::find($postId);
        if ($post) {
            $post->delete();
            return response()->json(['success' => true, 'message' => 'Bài viết đã được xóa.']);
        }

        return response()->json(['success' => false, 'message' => 'Bài viết không tồn tại.'], 404);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('search');
        $results = Posts::searchPost($keyword)->paginate(5);

        return view('admin.search_results_post', compact('results'));
    }
  
    public function editPost($post_id)
    {
        // Giải mã ID
        $decodedId = IdEncoder::decodeId($post_id);
        $post = Posts::findPostById($decodedId);

        if (!$post) {
            return redirect()->route('admin.viewpost')->with('error', 'Bài viết không tồn tại.');
        }

        return view('admin.post_edit', compact('post'));
    }
    public function update(Request $request, $post_id)
    {
        // Xác thực các dữ liệu đầu vào
        $request->validate([
            'title' => 'required|min:30|max:100|regex:/^[^!@#$%^&*()_+=\-{}\[\];:"\'<>,.?\/~`]+$/u|regex:/^(?!.*  )/',
            'description' => 'required|min:50|max:1000',
            'content1' => 'required|min:100|max:100000',
            'meta_desc' => 'nullable|min:10|max:50|regex:/^[^!@#$%^&*()_+=\-{}\[\];:"\'<>,.?\/~`]+$/u',
            'status' => 'required|boolean',
            'fileUpload' => 'nullable|image|max:10240',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết',
            'title.min' => 'Tiêu đề bài viết phải trên 30 ký tự',
            'title.max' => 'Tiêu đề bài viết không được quá 100 ký tự',
            'title.regex' => 'Tiêu đề bài viết không hợp lệ',
            'description.required' => 'Vui lòng nhập mô tả bài viết',
            'description.max' => 'Mô tả không quá 1000 ký tự.',
            'description.min' => 'Mô tả bài viết không được dưới 50 ký tự',
            'content1.required' => 'Nội dung bài viết không được để trống',
            'content1.min' => 'Nội dung bài viết không được dưới 100 ký tự',
            'content1.max' => 'Nội dung bài viết không được quá 10000 ký tự',
            'meta_desc.min' => 'Từ khoá mô tả bài viết không được dưới 10 ký tự',
            'meta_desc.max' => 'Từ khoá mô tả bài viết không được quá 50 ký tự',
            'meta_desc.regex' => 'Từ khoá mô tả bài viết không chứa kí tự đặc biệt',
            'status.required' => 'Trạng thái là bắt buộc.',
            'fileUpload.image' => 'Tệp không hợp lệ, chỉ cho phép PNG, JPEG, JPG',
            'fileUpload.max' => 'Dung lượng tệp không được vượt quá 10MB',
        ]);

        $post = Posts::findPostById($post_id);
        if (!$post) {
            return redirect()->route('admin.viewpost')->with('error', 'Bài viết không tồn tại.');
        }

        $post->title = $request->title;
        $post->description = $request->description;
        $post->content = $request->content1;
        $post->meta_desc = $request->meta_desc;
        $post->url_seo = $request->url_seo;
        $post->status = $request->status === '1' ? 1 : 0;

        if ($request->hasFile('fileUpload')) {
            $file = $request->file('fileUpload');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $post->img = $filename;
        }

        $post->save();
        
        return redirect()->route('admin.viewpost')->with('success', 'Cập nhật bài viết thành công.');
    }


}
