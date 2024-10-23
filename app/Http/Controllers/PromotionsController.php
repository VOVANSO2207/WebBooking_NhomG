<?php

namespace App\Http\Controllers;
use App\Models\Promotions;
use App\Helpers\IdEncoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
            'updated_at' => $promotion->updated_at // Đảm bảo giá trị này có sẵn
        ]);
    }
    public function searchVoucher(Request $request)
    {
        $keyword = $request->get('search');
        $vouchers = Promotions::searchVouchers($keyword)->paginate(7); // Tìm kiếm theo promotion_code

        return view('admin.search_results_voucher', compact('vouchers')); // Trả về một view phần chứa dữ liệu
    }

    public function destroy(Request $request, $promotion_id)
    {
        Validator::make($request->all(), [
            'updated_at' => 'required|date',
        ])->validate();

        $decodedId = IdEncoder::decodeId($promotion_id);

        $voucher = Promotions::find($decodedId);
        if (!$voucher) {
            return response()->json(['error' => 'VOUCHER CÓ THỂ ĐÃ BỊ XOÁ VUI LÒNG CẬP NHẬT LẠI'], 404);
        }

        if ($voucher->updated_at != $request->updated_at) {
            return response()->json(['error' => 'VOUCHER CÓ THỂ ĐÃ BỊ XOÁ VUI LÒNG CẬP NHẬT LẠI'], 409);
        }

        $voucher->delete();

        return response()->json(['success' => 'XOÁ VOUCHER THÀNH CÔNG']);
    }




}
