<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
class Promotions extends Model
{
    use HasFactory;
    protected $fillable = [
        'promotion_code',
        'discount_amount',
        'start_date',
        'end_date',
        'pro_description',
        'pro_title',


    ];
    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];
    public function room()
    {
        return $this->belongsTo(Rooms::class, 'promotion_id', 'room_id');
    }
    protected $primaryKey = 'promotion_id';
    public $timestamps = true;
    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
    public static function getAllVouchers($perPage = 7)
    {
        return self::orderBy('promotion_id', 'DESC')->paginate($perPage);
    }
    public static function findVouchersById($promotion_id)
    {
        return self::where('promotion_id', $promotion_id)->first();
    }
    public static function searchVouchers($keyword)
    {
        $query = self::query();

        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
                $query->where('promotion_code', 'LIKE', "%{$keyword}%")
                    ->orWhereRaw('MATCH(promotion_code) AGAINST (? IN BOOLEAN MODE)', [$keyword]);
            });
        }

        return $query->get();
    }
    // public static function deleteVoucher($promotion_id, $currentTimestamp)
    // {
    //     $voucher = self::find($promotion_id);

    //     if ($voucher) {
    //         if ($voucher->updated_at->ne($currentTimestamp)) {
    //             return false;
    //         }


    //         $voucher->delete();
    //         return true;
    //     }

    //     return false;
    // }
    public static function deleteVoucher($id, $updatedAt)
    {
        try {
            // Tìm voucher dựa trên ID
            $voucher = self::findVouchersById($id);

            // Kiểm tra thời gian cập nhật có khớp không
            if ($voucher->updated_at != Carbon::parse($updatedAt)) {
                return false; // Không thể xóa
            }

            // Xóa voucher
            $voucher->delete();
            return true;
        } catch (\Exception $e) {
            // Xử lý nếu có lỗi xảy ra
            return false;
        }
    }
    // public static function createVoucher($data)
    // {
    //     return self::create([
    //         'pro_title' => $data['pro_title'],
    //         'promotion_code' => $data['promotion_code'],
    //         'discount_amount' => $data['discount_amount'],
    //         'pro_description' => $data['pro_description'],
    //         'start_date' => Carbon::parse($data['start_date'])->format('Y-m-d'),
    //         'end_date' => Carbon::parse($data['end_date'])->format('Y-m-d'),
    //     ]);
    // }
    public static function createVoucher(array $data)
    {
        $maxStartDate = Carbon::today()->addYear()->format('Y-m-d');

        // Validate dữ liệu
        $validator = Validator::make($data, [
            'promotion_code' => 'required|max:15|min:10|alpha_num|unique:promotions,promotion_code|regex:/^(?=.*[a-zA-Z])(?=.*[0-9]).+$/',
            'discount_amount' => 'required|numeric|min:0|max:99999999|not_regex:/^0\d+$/|regex:/^\d+$/',
            'start_date' => "required|date|date_format:Y-m-d|after_or_equal:today|before_or_equal:$maxStartDate",
            'end_date' => "required|date|date_format:Y-m-d|after:start_date|after_or_equal:today|before_or_equal:$maxStartDate",
            'pro_description' => 'required|string|regex:/^[^#&\'()!]*$/|max:255',
            'pro_title' => 'required|string|max:255'
        ], [
            'end_date.after' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu.',
            'end_date.required' => 'Vui lòng chọn ngày kết thúc',
            'end_date.after_or_equal' => 'Ngày kết thúc không được là ngày trong quá khứ.',
            'end_date.before_or_equal' => 'Ngày kết thúc không được chọn quá xa.',
            'start_date.required' => 'Vui lòng chọn ngày bắt đầu',
            'start_date.after_or_equal' => 'Ngày bắt đầu không được là ngày trong quá khứ.',
            'start_date.before_or_equal' => 'Ngày bắt đầu không được chọn quá xa.',
            'promotion_code.required' => 'Vui lòng nhập tên voucher.',
            'promotion_code.unique' => 'Tên voucher đã tồn tại',
            'discount_amount.required' => 'Vui lòng nhập số tiền giảm giá.',
            'discount_amount.regex' => 'Vui lòng không nhập ký tự đặc biệt.',
            'discount_amount.min' => 'Số tiền giảm giá không được là số âm.',
            'discount_amount.max' => 'Số tiền giảm giá không hợp lệ.',
            'discount_amount.not_regex' => 'Số tiền giảm giá không được bắt đầu bằng 0.',
            'pro_description.required' => 'Mô tả voucher không được để trống',
            'pro_description.regex' => 'Mô tả không hợp lệ',
            'pro_description.max' => 'Mô tả không được quá 255 kí tự',
        ]);

        // Kiểm tra lỗi validate
        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors(),
            ];
        }

        // Tạo voucher
        try {
            self::create($data);

            return [
                'success' => true,
                'message' => 'Voucher được tạo thành công',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Đã có lỗi xảy ra trong quá trình lưu.',
            ];
        }
    }


}
