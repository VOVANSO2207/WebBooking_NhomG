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
    
        // Kiểm tra xem khách sạn đã được yêu thích chưa
        $favorite = FavoriteHotel::where('user_id', $userId)->where('hotel_id', $hotelId)->first();
        
        if (!$favorite) {
            // Thêm vào yêu thích
            FavoriteHotel::create([
                'user_id' => $userId,
                'hotel_id' => $hotelId,
            ]);
    
            return response()->json(['message' => 'Khách sạn đã được thêm vào yêu thích!']);
        } else {
            return response()->json(['message' => 'Khách sạn đã được yêu thích trước đó!'], 409);
        }
    }
    
    public function removeFavorite(Request $request)
    {
        $userId = auth()->id(); // Lấy ID của người dùng hiện tại
        $hotelId = $request->hotel_id; // Lấy ID khách sạn từ request
    
        // Kiểm tra xem khách sạn đã được yêu thích chưa
        $favorite = FavoriteHotel::where('user_id', $userId)->where('hotel_id', $hotelId)->first();
    
        if ($favorite) {
            // Xóa khách sạn khỏi danh sách yêu thích
            $favorite->delete();
    
            return response()->json(['message' => 'Khách sạn đã bị xóa khỏi yêu thích!']);
        } else {
            return response()->json(['message' => 'Khách sạn này không có trong danh sách yêu thích của bạn!'], 404);
        }
    }
    
    
    public function showHotelFavorite()
    {
        $hotels = Hotel::with('rooms', 'city', 'reviews', 'images')->get();
        foreach ($hotels as $hotel) {
            // Tính giá gốc trung bình
            $hotel->average_price = $hotel->rooms->avg('price');
            // Tính phần trăm giảm giá trung bình
            $hotel->average_discount_percent = $hotel->rooms->avg('discount_percent');
            // Tính giá sale dựa trên giá gốc và phần trăm giảm giá trung bình
            $hotel->average_price_sale = $hotel->average_price * (1 - $hotel->average_discount_percent / 100);
        }
        $userId = auth()->id();
        // Giả sử bạn lấy danh sách khách sạn và các thông tin liên quan từ database
        $favorites = FavoriteHotel::where('user_id', $userId)
        ->with(['hotel.images', 'hotel.rooms' => function($query) {
            // Lọc phòng có giá thấp nhất
            $query->orderBy('price', 'asc');
        }])
        ->paginate(2);
        // dd($favorites);
        // dd($hotels);
        return view('pages.account', compact('favorites','hotels'));
    }
}
