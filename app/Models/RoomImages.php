<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
class RoomImages extends Model
{
    use HasFactory;
    protected $table = 'room_images';
    protected $fillable = ['image_id', 'room_id', 'image_url', 'uploaded_at'];
    protected $primaryKey = 'image_id';
    public $timestamps = false;
    // Một hình ảnh thuộc về một phòng
    public function room()
    {   
        return $this->belongsTo(Rooms::class, 'room_id', 'room_id');
    }
    public static function uploadImages($roomId, $images)
    {
        foreach ($images as $image) {
            $filename = $image->getClientOriginalName();
            $newFileName = time() . '_' . $filename;

            $image->move(public_path('storage/images'), $newFileName);
            self::create([
                'room_id' => $roomId,
                'image_url' => $newFileName,
                'uploaded_at' => now(),
            ]);
        }
    }
      /**
     * Xóa hình ảnh và dữ liệu liên quan.
     */
    public static function deleteImage($id)
    {
        try {
            $image = self::find($id);

            if (!$image) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy ảnh'
                ], 404);
            }

            // Xóa file từ storage
            $filePath = public_path('storage/images/' . $image->image_url);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            // Xóa record từ database
            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa ảnh thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa ảnh: ' . $e->getMessage()
            ], 500);
        }
    }
}
