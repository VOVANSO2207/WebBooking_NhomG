<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    //
    public function viewPay()
    {
        return view('pages.pay');
    }
    public function getInfoPayment($hotel_id){
        $hotel = Hotel::with('images','city','rooms')->findOrFail($hotel_id);
        $rooms = $hotel->rooms()->get();
        dd($hotel);
        return view('pages.pay',compact('hotels','room'));

    }
}
