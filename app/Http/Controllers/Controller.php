<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function headerTest()
    {
        return view('partials.header');
    }
}
