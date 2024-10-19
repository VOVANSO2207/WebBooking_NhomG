<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    
    public function viewUser()
    {
        return view('admin.user');
    }

    public function userAdd()
    {
        return view('admin.user_add');
    }

}
