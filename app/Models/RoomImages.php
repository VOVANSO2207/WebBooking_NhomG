<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImages extends Model
{
    use HasFactory;
    protected $table = 'room_images';
    protected $fillable = ['image_id', 'room_id', 'image_url', 'uploaded_at'];
    public $timestamps = false;
    // Một hình ảnh thuộc về một phòng
    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
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
}
