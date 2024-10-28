<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelAmenities;
use Illuminate\Http\Request;

class HotelAmenitiesController extends Controller
{
    public function store(Request $request, $hotel_id)
    {
        $request->validate([
            'amenity_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        HotelAmenities::create([
            'hotel_id' => $hotel_id,
            'amenity_name' => $request->input('amenity_name'),
            'description' => $request->input('description'),
        ]);

        return back()->with('success', 'Amenity added successfully');
    }

    public function destroy($amenity_id)
    {
        $amenity = HotelAmenities::findOrFail($amenity_id);
        $amenity->delete();
        return back()->with('success', 'Amenity deleted successfully');
    }
}
