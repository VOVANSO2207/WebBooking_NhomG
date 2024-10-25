<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function headerTest()
    {
        return view('partials.header');
    }

    public function hotelDetailTest()
    {
        return view('pages.hotel_detail');
    }

}
