<?php

namespace App\Http\Controllers;

use App\Models\HotelAmenities;
use Illuminate\Http\Request;

class AmenityHotelController extends Controller
{
    /**
     * Lấy tất cả tiện nghi của một khách sạn 
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllAmenities()
    {
        $amenities = HotelAmenities::getAllAmenities();
     
        return view('pages.search_result', compact('amenities'));
    }
}
