<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cities;

class CitiesController extends Controller
{
    //
    public function index()
    {
        // Lấy danh sách thành phố từ database
        $cities = Cities::all();

        // Trả về view và truyền dữ liệu cities
        return view('pages.home', compact('cities'));
    }
}
