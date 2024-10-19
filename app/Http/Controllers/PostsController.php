<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function viewPost()
    {
        return view('admin.post');
    }
    public function postAdd()
    {
        return view('admin.post_add');
    }
}
