<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    //
    public function viewPay()
    {
        return view('pages.pay');
    }
}
