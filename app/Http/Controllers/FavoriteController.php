<?php

namespace App\Http\Controllers;

use App\Models\FavoriteHotel;
use App\Models\Hotel;
use App\Models\Booking;
use App\Models\Rooms;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function addFavorite(Request $request)
    {
        $userId = auth()->id(); 
        $hotelId = $request->hotel_id; 

        // Gọi phương thức trong model để thêm vào yêu thích
        $result = FavoriteHotel::addFavorite($userId, $hotelId);

        return response()->json(['message' => $result['message']], $result['status']);
    }

    public function removeFavorite(Request $request)
    {
        $userId = auth()->id(); 
        $hotelId = $request->hotel_id;

        // Gọi phương thức trong model để xóa khỏi yêu thích
        $result = FavoriteHotel::removeFavorite($userId, $hotelId);

        return response()->json(['message' => $result['message']], $result['status']);
    }


    public function showHotelFavorite()
    {
        $userId = auth()->id();
        $favorites = FavoriteHotel::getUserFavorites($userId);
        $bookings = Booking::where('user_id', auth()->id())->paginate(2);
        $rooms = Rooms::with('roomType')->get();
        
        return view('pages.account', compact('favorites', 'rooms', 'bookings'));
    }
}