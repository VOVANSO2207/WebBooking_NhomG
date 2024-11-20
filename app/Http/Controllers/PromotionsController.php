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
        $maxStartDate = Carbon::today()->addYear()->format('Y-m-d');

        // Validate dữ liệu với các ràng buộc chi tiết
        $validator = Validator::make($request->all(), [
            'promotion_code' => [
                'required',
                'max:15',
                'min:10',
                'alpha_num',
                'regex:/^(?=.*[a-zA-Z])(?=.*[0-9]).+$/',

            ],
            'discount_amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:99999999',
                'not_regex:/^0\d+$/',
                'regex:/^\d+$/',
            ],
            'pro_description' => [
                'required',
                'regex:/^[^#&\'()!]*$/',
                'max:255',
                'string',
            ],
            'pro_title' => 'required|string|max:255', // Thêm validate cho pro_title
            'start_date' => "required|date|date_format:Y-m-d|after_or_equal:today|before_or_equal:$maxStartDate",
            'end_date' => "required|date|date_format:Y-m-d|after:start_date|after_or_equal:today|before_or_equal:$maxStartDate",
        ], [
            'end_date.after' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu.',
            'end_date.required' => 'Vui lòng chọn ngày kết thúc.',
            'end_date.date_format' => 'Ngày kết thúc phải ở định dạng yyyy-mm-dd.',
            'end_date.after_or_equal' => 'Ngày kết thúc không được là ngày trong quá khứ.',
            'end_date.before_or_equal' => 'Ngày kết thúc không được chọn quá xa.',
            'start_date.required' => 'Vui lòng chọn ngày bắt đầu.',
            'start_date.date_format' => 'Ngày bắt đầu phải ở định dạng yyyy-mm-dd.',
            'start_date.after_or_equal' => 'Ngày bắt đầu không được là ngày trong quá khứ.',
            'start_date.before_or_equal' => 'Ngày bắt đầu không được chọn quá xa.',
            'promotion_code.required' => 'Vui lòng nhập tên voucher.',
            'promotion_code.alpha_num' => 'Tên voucher chỉ bao gồm chữ và số.',
            'promotion_code.regex' => 'Tên voucher phải bao gồm cả chữ và số.',
            'promotion_code.max' => 'Tên voucher không được vượt quá 15 ký tự.',
            'promotion_code.min' => 'Tên voucher phải có ít nhất 10 ký tự.',
            'discount_amount.required' => 'Vui lòng nhập số tiền giảm giá.',
            'discount_amount.regex' => 'Số tiền giảm giá không được chứa ký tự đặc biệt.',
            'discount_amount.min' => 'Số tiền giảm giá không được là số âm.',
            'discount_amount.max' => 'Số tiền giảm giá không hợp lệ.',
            'discount_amount.not_regex' => 'Số tiền giảm giá không được bắt đầu bằng 0.',
            'pro_description.required' => 'Mô tả voucher không được để trống',
            'pro_description.regex' => 'Mô tả không hợp lệ',
            'pro_description.max' => 'Mô tả không được quá 255 kí tự',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        // Tìm voucher theo ID
        $voucher = Promotions::findOrFail($id);
        if ($voucher->updated_at != $request->updated_at) {
            return response()->json(['error' => 'Voucher đã được cập nhật bởi một người dùng khác. Vui lòng tải lại và thử lại.'], 409);
        } else {
            // Cập nhật các giá trị cho voucher
            $voucher->promotion_code = $request->promotion_code;
            $voucher->discount_amount = $request->discount_amount;
            $voucher->pro_description = $request->pro_description; // Thêm dòng này để cập nhật mô tả
            $voucher->pro_title = $request->pro_title; // Thêm dòng này để cập nhật pro_title
            // Cập nhật ngày
            $voucher->start_date = $request->start_date;
            $voucher->end_date = $request->end_date;

            // Lưu lại dữ liệu
            $voucher->save();

            // Trả về phản hồi JSON
            return response()->json(['success' => true]);
        }

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
                ->where('start_date', '<=', Carbon::now())
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


















