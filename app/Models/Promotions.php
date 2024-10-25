<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
    use HasFactory;
    protected $fillable = [
        'promotion_code',
        'discount_amount',
        'start_date',
        'end_date',


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
        // Nếu không có từ khóa, trả về tất cả
        if (empty($keyword)) {
            return self::query(); // Trả về tất cả voucher
        }

        return self::where('promotion_code', 'LIKE', "%{$keyword}%");
    }
    public static function deleteVoucher($promotion_id, $currentTimestamp)
    {
        $voucher = self::find($promotion_id);

        if ($voucher) {
            if ($voucher->updated_at->ne($currentTimestamp)) {
                return false;
            }


            $voucher->delete();
            return true; 
        }

        return false; 
    }
    public static function createVoucher($data)
    {
        return self::create([
            'promotion_code' => $data['promotion_code'],
            'discount_amount' => $data['discount_amount'],
            'start_date' => Carbon::parse($data['start_date'])->format('Y-m-d'),
            'end_date' => Carbon::parse($data['end_date'])->format('Y-m-d'),
        ]);
    }

}
