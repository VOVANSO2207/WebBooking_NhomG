<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
class RoomType extends Model
{
    use HasFactory;
    protected $table = 'room_types';
    protected $primaryKey = 'room_type_id';
    protected $fillable = ['name'];
    public $timestamps = false;

    // Một loại phòng có nhiều phòng
    public function rooms()
    {
        return $this->hasMany(Rooms::class, 'room_type_id'); // Liên kết về phòng
    }
    public static function getAllRoomType($perPage = 5)
    {
        return self::query()->paginate($perPage);
    }
    public static function createRoomType($data)
    {
        // Validate dữ liệu
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u',
        ], [
            'name.required' => 'Vui lòng nhập tên loại phòng.',
            'name.regex' => 'Tên chỉ được chứa chữ cái và khoảng trắng.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        // Kiểm tra sự tồn tại của loại phòng
        if (self::where('name', $data['name'])->exists()) {
            return ['errors' => ['name' => 'Dữ liệu này đã tồn tại.']];
        }

        // Tạo loại phòng nếu không có lỗi
        return self::create($data);
    }
    public static function deleteRoomType($roomType_id)
    {
        $roomType = self::find($roomType_id);
        if ($roomType) {
            return $roomType->delete();
        }

        return false;
    }
    public static function updateRoomType($roomType_id, $data)
    {
        $roomType = self::find($roomType_id);

        if ($roomType) {
            $roomType->update([
                'name' => $data['name']
            ]);
            return $roomType;
        }

        return false;
    }
    public static function searchByName($keyword, $perPage = 5)
    {
        $query = self::query();

        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhereRaw('MATCH(name) AGAINST (? IN BOOLEAN MODE)', [$keyword]);
            });
        }

        return $query->paginate($perPage); // Sử dụng paginate thay vì get
    }


}
