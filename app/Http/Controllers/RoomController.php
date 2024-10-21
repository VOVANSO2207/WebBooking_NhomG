<?php

namespace App\Http\Controllers;

use App\Models\RoomAmenities;
use App\Models\RoomImages;
use App\Models\Rooms;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Rooms::getAllRooms();
        return view('admin.room', ['rooms' => $rooms]);
    }
    
    


}
