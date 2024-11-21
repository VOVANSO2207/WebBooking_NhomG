<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Models\ReviewLike;

use Illuminate\Http\Request;
use Illuminate\Support\Str;  // Để tạo UUID cho tên file

class ReviewsController extends Controller
{

    public function store(Request $request, $hotel_id)
    {
        // Lấy người dùng hiện tại
        $user = auth()->user();

        // Gọi logic từ model Reviews
        $result = Reviews::createReview($user, $hotel_id, $request->all(), $request->file('images', []));

        // Kiểm tra kết quả và trả về thông báo
        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 403); // 403: Forbidden
        }

        return back()->with('success', $result['message']);
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
    // Lấy người dùng hiện tại
    $user = auth()->user();

    // Gọi logic xóa từ model Reviews
    $result = Reviews::deleteReview($review_id, $user);

    // Kiểm tra kết quả và trả về thông báo
    if (!$result['success']) {
        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], 403); // 403: Forbidden
    }

    return back()->with('success', $result['message']);
}



    // public function update(Request $request, $review_id)
    // {
    //     $request->validate([
    //         'comment' => 'required|string|max:1000',
    //         'rating' => 'nullable|integer|min:1|max:5',
    //     ]);

    //     // Tìm bình luận
    //     $review = Reviews::findOrFail($review_id);

    //     // Cập nhật nội dung bình luận
    //     $review->comment = $request->comment;
    //     if ($request->has('rating')) {
    //         $review->rating = $request->rating;
    //     }
    //     $review->save();

    //     return response()->json(['success' => true, 'message' => 'Bình luận đã được chỉnh sửa.', 'comment' => $review->comment]);
    // }
    
    public function like($review_id)
{
    $user = auth()->user(); // Lấy người dùng hiện tại

    // Gọi phương thức từ model Reviews để xử lý like/unlike
    $result = Reviews::toggleLike($review_id, $user);

    return response()->json($result);
}







}
