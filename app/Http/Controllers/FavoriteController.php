<?php

namespace App\Http\Controllers;

use App\Models\FavoriteHotel;
use App\Models\Hotel;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function addFavorite(Request $request)
    {
        $userId = auth()->id(); // Lấy ID của người dùng hiện tại
        $hotelId = $request->hotel_id; // Lấy ID khách sạn từ request

        // Gọi phương thức trong model để thêm vào yêu thích
        $result = FavoriteHotel::addFavorite($userId, $hotelId);

        return response()->json(['message' => $result['message']], $result['status']);
    }
    
    public function removeFavorite(Request $request)
    {
        $userId = auth()->id(); // Lấy ID của người dùng hiện tại
        $hotelId = $request->hotel_id; // Lấy ID khách sạn từ request

        // Gọi phương thức trong model để xóa khỏi yêu thích
        $result = FavoriteHotel::removeFavorite($userId, $hotelId);

        return response()->json(['message' => $result['message']], $result['status']);
    }
    
    
    public function showHotelFavorite()
    {
        $userId = auth()->id();
        $favorites = FavoriteHotel::getUserFavorites($userId);
    
        return view('pages.account', compact('favorites'));
    }
}
