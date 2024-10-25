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
            'promotion_code' => $promotion->promotion_code,
            'discount_amount' => $promotion->discount_amount,
            'start_date' => $promotion->start_date,
            'end_date' => $promotion->end_date,

        ]);
    }
    public function searchVoucher(Request $request)
    {
        $keyword = $request->get('search');
        $vouchers = Promotions::searchVouchers($keyword)->paginate(7);

        return view('admin.search_results_voucher', compact('vouchers'));
    }


    public function destroy(Request $request, $promotion_id)
    {
        // Validate request
        Validator::make($request->all(), [
            'updated_at' => 'required|date',
        ])->validate();

        // Giải mã ID (nếu sử dụng mã hóa ID)
        $decodedId = IdEncoder::decodeId($promotion_id);

        // Gọi hàm xóa từ model Promotions
        $isDeleted = Promotions::deleteVoucher($decodedId, $request->updated_at);

        if (!$isDeleted) {
            return response()->json(['error' => 'VOUCHER CÓ THỂ ĐÃ BỊ XOÁ HOẶC CẬP NHẬT VUI LÒNG THỬ LẠI'], 409);
        }

        return response()->json(['success' => 'XOÁ VOUCHER THÀNH CÔNG']);
    }

    public function voucherAdd()
    {
        return view('admin.voucher_add');
    }
    public function storeVoucher(Request $request)
    {
        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'promotion_code' => 'required|max:15|min:10|alpha_num|unique:promotions,promotion_code|regex:/^(?=.*[a-zA-Z])(?=.*[0-9]).+$/',
            'discount_amount' => 'required|numeric|min:0|max:99999999|not_regex:/^0\d+$/|regex:/^\d+$/', // Thêm ràng buộc regex
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
        ], [
            'end_date.after' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu.',
            'end_date.required' => 'Vui lòng chọn ngày kết thúc',
            'start_date.required' => 'Vui lòng chọn ngày bắt đầu',
            'promotion_code.required' => 'Vui lòng nhập tên voucher.',
            'promotion_code.unique' => 'Tên voucher đã tồn tại',
            'discount_amount.required' => 'Vui lòng nhập số tiền giảm giá.',
            'discount_amount.regex' => 'Vui lòng không nhập ký tự đặc biệt.',
            'discount_amount.min' => 'Số tiền giảm giá không được là số âm.',
            'discount_amount.max' => 'Số tiền giảm giá không hợp lệ.',
            'discount_amount.not_regex' => 'Số tiền giảm giá không được bắt đầu bằng 0.',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Gọi phương thức createVoucher từ model Promotions
        try {
            Promotions::createVoucher([
                'promotion_code' => $request->promotion_code,
                'discount_amount' => $request->discount_amount,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            return response()->json(['success' => 'Voucher được tạo thành công'], 200);
        } catch (\Exception $e) {
            \Log::error('Error creating voucher: ' . $e->getMessage());
            return response()->json(['error' => 'Đã có lỗi xảy ra trong quá trình lưu.'], 500);
        }
    }
    
}


















