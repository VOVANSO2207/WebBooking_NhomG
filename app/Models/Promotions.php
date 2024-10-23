<?php

namespace App\Models;

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
    protected $primaryKey = 'promotion_id';
    public $timestamps = true;

    public static function getAllVouchers($perPage = 7)
    {
        return self::orderBy('created_at', 'DESC')->paginate($perPage);
    }
    public static function findVouchersById($promotion_id)
    {
        return self::where('promotion_id', $promotion_id)->first();
    }
    public static function searchVouchers($keyword)
    {
       
        if (empty($keyword)) {
            return self::query(); 
        }

        return self::where('promotion_code', 'LIKE', "%{$keyword}%");
    }
}
