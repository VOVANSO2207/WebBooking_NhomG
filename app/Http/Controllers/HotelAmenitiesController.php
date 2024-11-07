<?php

namespace App\Http\Controllers;

use App\Models\HotelAmenities;
use Illuminate\Http\Request;
use App\Helpers\IdEncoder;

class HotelAmenitiesController extends Controller
{
    public function index()
    {
        $amenities = HotelAmenities::getAllAmenities();
        
        // Mã hóa ID cho mỗi tiện ích trước khi hiển thị
        foreach ($amenities as $amenity) {
            $amenity->encoded_id = IdEncoder::encodeId($amenity->amenity_id);
        }
        
        return view('admin.hotel_amenities', compact('amenities'));
    }

    public function create()
    {
        return view('admin.hotel_amenities_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amenity_name' => 'required|string|max:100|unique:hotel_amenities,amenity_name',
            'description' => 'required|string|max:255',
        ], [
            'amenity_name.required' => 'Vui lòng nhập tên tiện ích.',
            'amenity_name.string' => 'Tên tiện ích phải là chuỗi ký tự.',
            'amenity_name.max' => 'Tên tiện ích không được vượt quá 100 ký tự.',
            'amenity_name.unique' => 'Tên tiện ích này đã tồn tại.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',
        ]);
    
        HotelAmenities::create($request->only(['amenity_name', 'description']));
    
        return redirect()->route('admin.hotel_amenities.index')->with('success', 'Thêm tiện ích thành công.');
    }    

    public function showDetail($id)
    {
        // Giải mã ID nếu cần
        $decodedId = IdEncoder::decodeId($id);
        $amenity = HotelAmenities::find($decodedId);
        
        if (!$amenity) {
            return response()->json(['error' => 'Tiện ích không tồn tại'], 404);
        }

        return response()->json([
            'amenity_name' => $amenity->amenity_name,
            'description' => $amenity->description
            // Không bao gồm created_at và updated_at nếu không có
        ], 200);
    }



    public function edit($encodedId)
    {
        // Giải mã ID
        $amenity_id = IdEncoder::decodeId($encodedId);
        $amenity = HotelAmenities::findAmenityById($amenity_id);

        if (!$amenity) {
            return redirect()->route('admin.hotel_amenities.index')->with('error', 'Tiện ích không tồn tại.');
        }

        return view('admin.hotel_amenities_edit', compact('amenity'));
    }

    public function update(Request $request, $amenity_id)
    {
        $request->validate([
            'amenity_name' => 'required|string|max:100',
            'description' => 'required|string|max:255',
        ], [
            'amenity_name.required' => 'Vui lòng nhập tên tiện ích.',
            'amenity_name.string' => 'Tên tiện ích phải là chuỗi ký tự.',
            'amenity_name.max' => 'Tên tiện ích không được vượt quá 100 ký tự.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',
        ]);
    
        $amenity = HotelAmenities::find($amenity_id);
        if (!$amenity) {
            return redirect()->route('admin.hotel_amenities.index')->with('error', 'Tiện ích không tồn tại.');
        }
    
        $amenity->amenity_name = $request->input('amenity_name');
        $amenity->description = $request->input('description');
        $amenity->save();
    
        return redirect()->route('admin.hotel_amenities.index')->with('success', 'Cập nhật tiện ích thành công.');
    }
    
    public function destroy($amenity_id)
    {
        // Giải mã ID trước khi thao tác
        $decodedId = IdEncoder::decodeId($amenity_id);
        $amenity = HotelAmenities::find($decodedId);
        if ($amenity) {
            $amenity->delete();
            return response()->json(['success' => true, 'message' => 'Tiện ích đã được xóa.']);
        }

        return response()->json(['success' => false, 'message' => 'Tiện ích không tồn tại.'], 404);
    }


    public function search(Request $request)
    {
        $keyword = $request->get('search');
    
        // Kiểm tra nếu từ khóa tìm kiếm rỗng, hiển thị tất cả kết quả
        if (empty($keyword)) {
            $results = HotelAmenities::getAllAmenities();
        } else {
            // Sử dụng full-text search trên các cột trong bảng HotelAmenities
            $results = HotelAmenities::whereRaw('MATCH(amenity_name, description) AGAINST(? IN BOOLEAN MODE)', [$keyword])
                ->paginate(5);
        }
    
        return view('admin.search_results_hotel_amenities', compact('results'));
    }

    public function encodeId($id)
    {
        $encodedId = IdEncoder::encodeId($id);
        return response()->json(['encoded_id' => $encodedId]);
    }

    public function decodeId($encodedId)
    {
        $decodedId = IdEncoder::decodeId($encodedId);
        return response()->json(['decoded_id' => $decodedId]);
    }

}
