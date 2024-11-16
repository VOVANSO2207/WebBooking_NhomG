<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Models\ReviewImages;
use Illuminate\Http\Request;
use Illuminate\Support\Str;  // Để tạo UUID cho tên file

class ReviewsController extends Controller
{
    public function store(Request $request, $hotel_id)
    {
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

        // Xóa tất cả các ảnh liên quan (nếu có)
        // Nếu bạn có liên kết đến bảng ReviewImages thì bạn có thể xóa ảnh ở đây
        // $review->images()->delete();

        // Xóa bình luận
        $review->delete();

        // Trả về thông báo thành công và điều hướng lại
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

    
    
    

}
