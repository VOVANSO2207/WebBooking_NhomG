<?php

namespace App\Http\Controllers;
use App\Models\Promotions;
use App\Helpers\IdEncoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PromotionsController extends Controller
{
    public function viewVoucher()
    {
        $vouchers = Promotions::getAllVouchers(7);
        return view('admin.voucher', compact('vouchers'));
    }
    public function getVoucherDetail($promotion_id)
    {
        // Giải mã ID nếu cần
        $decodedId = IdEncoder::decodeId($promotion_id);
        $promotion = Promotions::findVouchersById($decodedId);

        if (!$promotion) {
            return response()->json(['error' => 'Voucher không tồn tại'], 404);
        }

        return response()->json([
            'pro_title' => $promotion->pro_title,
            'promotion_code' => $promotion->promotion_code,
            'discount_amount' => $promotion->discount_amount,
            'pro_description' => $promotion->pro_description,
            'start_date' => $promotion->start_date,
            'end_date' => $promotion->end_date,

        ]);
    }
    public function searchVoucher(Request $request)
    {
        $keyword = $request->get('search');
        $vouchers = Promotions::searchVouchers($keyword);

        return view('admin.search_results_voucher', compact('vouchers'));
    }

    public function destroy(Request $request, $promotion_id)
    {
        // Validate request
        $validated = $request->validate([
            'updated_at' => 'required|date',
        ]);

        $decodedId = IdEncoder::decodeId($promotion_id);

        if (!$decodedId) {
            return response()->json(['error' => 'Voucher không tồn tại'], 404);
        }

        $isDeleted = Promotions::deleteVoucher($decodedId, $validated['updated_at']);

        if (!$isDeleted) {
            return response()->json(['error' => 'Voucher có thể bị xoá vui lòng cập nhật lại'], 409);
        }

        return response()->json(['success' => 'Xóa voucher thành công']);
    }

    public function voucherAdd()
    {
        return view('admin.voucher_add');
    }
    public function storeVoucher(Request $request)
    {
        $result = Promotions::createVoucher($request->all());

        if (!$result['success']) {
            return response()->json(['errors' => $result['errors'] ?? $result['error']], 422);
        }
        
         // Lấy thông tin từ $result
        $promotionCode = $request['promotion_code'];
        $discountAmount = $request['discount_amount'];
        $description = $request['pro_description'];
        $startDate = $request['start_date'];
        $endDate = $request['end_date'];
        $formattedAmount = number_format($discountAmount, 0, ',', '.') . ' VND';

        // Thêm thông báo vào session cho tất cả người dùng
        $notifications = session('notifications', []);
        $notifications[] = [
            'content' => "Mã khuyến mãi mới '{$promotionCode}' đã có! Giảm giá {$formattedAmount} . {$description}. Áp dụng từ ngày {$startDate} đến hết ngày {$endDate}.",
        ];
        session(['notifications' => $notifications]);

        return response()->json(['success' => $result['message']], 200);
    }
    public function editVoucher($promotion_id)
    {
        $decodedId = IdEncoder::decodeId($promotion_id);

        if (!$decodedId) {
            return response()->view('errors.404', [], 404);
        }
        $voucher = Promotions::findVouchersById($decodedId);
        if (!$voucher) {
            return response()->view('errors.404', [], 404);
        }

        $start_date = $voucher->start_date ? \Carbon\Carbon::createFromFormat('d/m/Y', $voucher->start_date)->format('Y-m-d') : null;
        $end_date = $voucher->end_date ? \Carbon\Carbon::createFromFormat('d/m/Y', $voucher->end_date)->format('Y-m-d') : null;

        return view('admin.voucher_edit', compact('voucher', 'start_date', 'end_date'));
    }

    public function updateVoucher(Request $request, $id)
    {
        $data = $request->all();

        $voucher = Promotions::findOrFail($id);

        $result = $voucher->updateVoucherWithValidation($data);

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 422);
        }

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 409);
        }

        return response()->json(['success' => true]);
        
    }
    public function viewVoucherUser()
    {
        $vouchers = Promotions::getAllVouchers(7);

        foreach ($vouchers as $voucher) {
            try {
                // Chuyển đổi end_date sang Carbon và đặt thời gian bắt đầu của ngày
                $endDate = Carbon::createFromFormat('d/m/Y', $voucher->end_date, 'Asia/Ho_Chi_Minh')->startOfDay();
                $currentDate = Carbon::now('Asia/Ho_Chi_Minh')->startOfDay();

                // Kiểm tra ngày hết hạn
                if ($endDate->isBefore($currentDate)) {
                    $voucher->status = 'expired'; // Đã hết hạn
                } elseif ($currentDate->diffInDays($endDate) <= 3) {
                    $voucher->status = 'expiring_soon'; // Sắp hết hạn trong 2-3 ngày
                } else {
                    $voucher->status = 'active'; // Vẫn còn hiệu lực
                }
            } catch (\Exception $e) {
                // Nếu có lỗi khi xử lý ngày
                $voucher->status = 'unknown';
            }
        }

        return view('pages.detail_voucher', compact('vouchers'));
    }


    public function applyPromotion(Request $request)
    {
        
        $request->validate([
            'promotion_code' => 'required|string',
            'original_amount' => 'required|numeric|min:0'
        ]);

        try {
            $promotion = Promotions::where('promotion_code', $request->promotion_code)
                // ->where('start_date', '<=', Carbon::now())
                ->where('end_date', '>=', Carbon::now())
                ->first();

            if (!$promotion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá không tồn tại hoặc đã hết hạn!'
                ]);
            }

            // Calculate discount amount based on percentage
            $discountPercentage = $promotion->discount_amount;
            $calculatedDiscount = round(($request->original_amount * $discountPercentage) / 100);
            
            // Calculate new total after discount
            $newTotal = $request->original_amount - $calculatedDiscount;
            // session(['applied_promotion_id' => $promotion->promotion_id]);
            return response()->json([
                'success' => true,
                'promotion_code' => $promotion->promotion_code,
                'discount_percentage' => $discountPercentage,
                'calculated_discount' => $calculatedDiscount,
                'new_total' => $newTotal,
                'message' => $promotion->pro_title,
                'description' => $promotion->pro_description,
                'promotion_id' => $promotion->promotion_id,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã có lỗi xảy ra khi áp dụng mã giảm giá.'
            ]);
        }
    }

}


















