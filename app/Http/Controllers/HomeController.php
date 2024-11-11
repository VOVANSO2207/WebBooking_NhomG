<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        return view('pages.home'); // Trả về view trang chủ
    }
    public function introduce(){
        return view('introduce');
    }
    public function detail_voucher(){
        return view('pages.detail_voucher');
    }
}
