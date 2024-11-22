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
        foreach ($posts as $post) {
            $post->description = html_entity_decode(strip_tags($post->description));
            $post->content = html_entity_decode(strip_tags($post->content));
        }
        return view('admin.post', compact('posts'));
    }

    public function postAdd()
    {
        return view('admin.post_add');
    }

    public function getPostDetail($post_id)
    {
        $decodedId = IdEncoder::decodeId($post_id);
        $post = Posts::findPostById($decodedId);

        if (!$post) {
            return response()->json(['error' => 'Bài viết không tồn tại'], 404);
        }

        return response()->json([
            'title' => $post->title,
            'description' => html_entity_decode(strip_tags($post->description)),
            'content' => html_entity_decode(strip_tags($post->content)),
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
        $data = $request->all();
        $post = Posts::createPost($data);
        
        if ($post instanceof \Illuminate\Support\MessageBag) {
            return response()->json(['errors' => $post], 422);  
        }

        return response()->json(['success' => true]);
    }

    public function deletePost($id)
    {
        $result = Posts::deletePostById($id);

        if ($result['success']) {
            return response()->json(['success' => true, 'message' => $result['message']]);
        }

        return response()->json(['success' => false, 'message' => $result['message']], 404);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('search');
        $results = Posts::searchPost($keyword)->paginate(5);

        return view('admin.search_results_post', compact('results'));
    }

    public function editPost($post_id)
    {
        $decodedId = IdEncoder::decodeId($post_id);
        if (!$decodedId) {
            return response()->view('errors.404', [], 404);
        }
        $post = Posts::findPostById($decodedId);

        if (!$post) {
            return response()->view('errors.404', [], 404);
        }
        return view('admin.post_edit', compact('post'));
    }
 // Controller

 public function update(Request $request, $id)
 {
     // Include the uploaded file in the $data array
     $data = $request->all();
     if ($request->hasFile('fileUpload')) {
         $data['fileUpload'] = $request->file('fileUpload');
     }

     // Call model's updatePost method
     $result = Posts::updatePost($id, $data);

     if (is_string($result)) {
         // Handle conflict or not found
         return response()->json(['message' => $result], 409);
     } elseif ($result instanceof \Illuminate\Support\MessageBag) {
         // Handle validation errors
         return response()->json(['errors' => $result], 422);
     }

     // Success response
     return response()->json(['message' => 'Cập nhật bài viết thành công.'], 200);
 }
 

    public function getViewBlog()
    {
        $posts = Posts::getViewBlogs();
        foreach ($posts as $post) {
            $post->description = html_entity_decode(strip_tags($post->description));
            $post->content = html_entity_decode(strip_tags($post->content));
        }
        return view('view_blog', compact('posts'));
    }
    public function searchViewBlog(Request $request)
    {
        $query = $request->input('query');

        $posts = Posts::searchPost($query)->get();

        return response()->json($posts);
    }
    public function getBlogDetail($url_seo)
    {
        $post = Posts::where('url_seo', $url_seo)->first();

        if (!$post) {
            abort(404);
        }

        $relatedPosts = Posts::where('post_id', '!=', $post->post_id)
            ->where(function ($query) use ($post) {
                $titleKeywords = implode(' ', array_slice(explode(' ', $post->title), 0, 3));
                $query->where('title', 'LIKE', '%' . $titleKeywords . '%')
                    ->orWhere('description', 'LIKE', '%' . substr($post->description, 0, 50) . '%')
                    ->orWhereRaw('MATCH(content) AGAINST (? IN BOOLEAN MODE)', [$post->description]); // Tìm kiếm toàn văn
            })
            ->limit(5)
            ->get();

        return view('blog_detail', compact('post', 'relatedPosts'));
    }

}
