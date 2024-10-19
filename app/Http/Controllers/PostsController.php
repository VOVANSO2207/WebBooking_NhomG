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
}
