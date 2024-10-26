<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelImages;
use Illuminate\Http\Request;

class HotelImageController extends Controller
{
    public function store(Request $request, $hotel_id)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('image')->store('hotel_images', 'public');
        HotelImages::create([
            'hotel_id' => $hotel_id,
            'image_path' => $imagePath,
        ]);

        return back()->with('success', 'Image added successfully');
    }

    public function destroy($image_id)
    {
        $image = HotelImages::findOrFail($image_id);
        $image->delete();
        return back()->with('success', 'Image deleted successfully');
    }
}
