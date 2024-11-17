<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Models\ReviewImages;
use App\Models\ReviewLike;
use Illuminate\Http\Request;
use Illuminate\Support\Str;  // Để tạo UUID cho tên file

class ReviewsController extends Controller
{
    public function store(Request $request, $hotel_id)
    {
        // Kiểm tra người dùng đã đăng nhập chưa
    if (!auth()->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Vui lòng đăng nhập để bình luận.'
        ], 401); // 401: Unauthorized
    }
        // Validate dữ liệu đầu vào
        $request->validate([
            'comment' => 'required|string|max:1000',
            'rating' => 'nullable|min:1|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        // Lấy người dùng hiện tại
        $user = auth()->user();
        
        // Lưu bình luận vào database
        $review = new Reviews();
        $review->hotel_id = $hotel_id;
        $review->user_id = $user->user_id;  // Đảm bảo 'user_id' là khóa ngoại
        $review->rating = $request->rating;
        $review->comment = $request->comment;
    
        $review->save();
        
        // Xử lý ảnh tải lên
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Tạo tên file duy nhất để tránh xung đột
                $imageName = Str::random(10) . '_' . time() . '.' . $image->getClientOriginalExtension();
                
                // Lưu ảnh vào thư mục 'public/review_images'
                $image->move(public_path('review_images'), $imageName);
        
                // Lưu thông tin ảnh vào database
                $reviewImage = new ReviewImages();
                $reviewImage->review_id = $review->review_id;  // Đảm bảo trường 'review_id' có trong bảng ReviewImages
                $reviewImage->image_url = 'review_images/' . $imageName;
                $reviewImage->save();
            }
        }
        
        // Trả về thông báo thành công hoặc điều hướng lại
        return back()->with('success', 'Đánh giá của bạn đã được gửi.');
    }
    
    // public function reply(Request $request, $review_id)
    // {
    //     $request->validate([
    //         'comment' => 'required|string|max:1000',
    //         'rating' => 'nullable|min:1|max:5',
    //     ]);
    
    //     // Lấy thông tin người dùng hiện tại
    //     $user = auth()->user();
    
    //     // Tìm review (bình luận) gốc mà người dùng muốn phản hồi
    //     $review = Reviews::findOrFail($review_id);
    
    //     $reply = new Reviews();
    //     $reply->hotel_id = $review->hotel_id;
    //     $reply->user_id = $user->user_id;
    //     $reply->parent_id = $review->review_id;  
    //     $reply->comment = $request->comment;
    //     $reply->rating = $request->rating;  // Nếu có rating thì thêm vào
    
    //     // Lưu phản hồi vào cơ sở dữ liệu
    //     $reply->save();
    
    //     // Trả về trang cũ với thông báo thành công
    //     return back()->with('success', 'Phản hồi của bạn đã được gửi.');
    // }
    public function destroy($review_id)
    {
        // Tìm bình luận theo review_id
        $review = Reviews::findOrFail($review_id);
    
        // Kiểm tra xem người dùng có quyền xóa bình luận này không
        $user = auth()->user();
    
        if ($user->user_id !== $review->user_id && !$user->is_admin) {
            return response()->json(['success' => false, 'message' => 'Bạn không có quyền xóa bình luận này.']);
        }
    
        // Xóa bình luận
        $review->delete();
    
        // Trả về thông báo thành công
        return back()->with('success', 'Bình luận đã được xóa.');
    }
    
    
    
    public function update(Request $request, $review_id)
{
    $request->validate([
        'comment' => 'required|string|max:1000',
        'rating' => 'nullable|integer|min:1|max:5',
    ]);

    // Tìm bình luận
    $review = Reviews::findOrFail($review_id);

    // Cập nhật nội dung bình luận
    $review->comment = $request->comment;
    if ($request->has('rating')) {
        $review->rating = $request->rating;
    }
    $review->save();

    return response()->json(['success' => true, 'message' => 'Bình luận đã được chỉnh sửa.', 'comment' => $review->comment]);
}
public function like($review_id)
{
    $user = auth()->user(); // Lấy người dùng hiện tại

    // Kiểm tra xem người dùng đã like chưa
    $like = ReviewLike::where('review_id', $review_id)
                      ->where('user_id', $user->user_id)
                      ->first();

    // Nếu đã like, thì bỏ like
    if ($like) {
        $like->delete();
        // Cập nhật lại số lượng like sau khi bỏ thích
        $likes_count = Reviews::find($review_id)->likes()->count();
        return response()->json([
            'success' => true,
            'action' => 'unliked',
            'likes_count' => $likes_count, // Trả về số lượng like mới nhất
            'message' => 'Bạn đã bỏ thích bình luận này.'
        ]);
    } else {
        // Nếu chưa like, thì thêm like
        ReviewLike::create([
            'review_id' => $review_id,
            'user_id' => $user->user_id,
        ]);
        // Cập nhật lại số lượng like sau khi thích
        $likes_count = Reviews::find($review_id)->likes()->count();
        return response()->json([
            'success' => true,
            'action' => 'liked',
            'likes_count' => $likes_count, // Trả về số lượng like mới nhất
            'message' => 'Bạn đã thích bình luận này.'
        ]);
    }
}




    
    
    

}
