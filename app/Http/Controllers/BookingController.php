<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function viewBooking()
    {
        $bookings = Booking::getAllBookings();
        return view('admin.booking', compact('bookings'));
    }

    public function bookingAdd()
    {
        return view('admin.booking_add');
    }

    public function getBookingDetail($booking_id)
    {
        $booking = Booking::findBookingById($booking_id);

        if (!$booking) {
            return response()->json(['error' => 'Đặt phòng không tồn tại'], 404);
        }

        return response()->json([
            'user_id' => $booking->user_id,
            'room_id' => $booking->room_id,
            'promotion_id' => $booking->promotion_id,
            'check_in' => $booking->check_in,
            'check_out' => $booking->check_out,
            'total_price' => $booking->total_price,
            'status' => $booking->status,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'room_id' => 'required|integer',
            'promotion_id' => 'nullable|integer',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'total_price' => 'required|numeric',
            'status' => 'required|in:confirmed,cancelled,pending',
        ], [
            'user_id.required' => 'Vui lòng nhập ID người dùng.',
            'room_id.required' => 'Vui lòng nhập ID phòng.',
            'check_in.required' => 'Ngày nhận phòng là bắt buộc.',
            'check_out.required' => 'Ngày trả phòng là bắt buộc.',
            'check_out.after' => 'Ngày trả phòng phải sau ngày nhận phòng.',
            'total_price.required' => 'Tổng giá là bắt buộc.',
            'status.required' => 'Trạng thái là bắt buộc.',
        ]);

        $booking = new Booking();
        $booking->user_id = $request->user_id;
        $booking->room_id = $request->room_id;
        $booking->promotion_id = $request->promotion_id;
        $booking->check_in = $request->check_in;
        $booking->check_out = $request->check_out;
        $booking->total_price = $request->total_price;
        $booking->status = $request->status;

        Booking::createBooking($booking->toArray());
        return redirect()->route('admin.viewbookings')->with('success', 'Thêm đặt phòng thành công.');
    }

    public function deleteBooking($id)
    {
        $booking = Booking::find($id);
        if ($booking) {
            $booking->delete();
            return response()->json(['success' => true, 'message' => 'Đặt phòng đã được xóa.']);
        }

        return response()->json(['success' => false, 'message' => 'Đặt phòng không tồn tại.'], 404);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('search');
        $results = Booking::searchBooking($keyword)->paginate(5);

        return view('admin.search_results_booking', compact('results'));
    }

    public function editBooking($booking_id)
    {
        $booking = Booking::findBookingById($booking_id);

        if (!$booking) {
            return redirect()->route('admin.viewbookings')->with('error', 'Đặt phòng không tồn tại.');
        }

        return view('admin.booking_edit', compact('booking'));
    }

    public function update(Request $request, $booking_id)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'room_id' => 'required|integer',
            'promotion_id' => 'nullable|integer',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'total_price' => 'required|numeric',
            'status' => 'required|in:confirmed,cancelled,pending',
        ], [
            'user_id.required' => 'Vui lòng nhập ID người dùng.',
            'room_id.required' => 'Vui lòng nhập ID phòng.',
            'check_in.required' => 'Ngày nhận phòng là bắt buộc.',
            'check_out.required' => 'Ngày trả phòng là bắt buộc.',
            'check_out.after' => 'Ngày trả phòng phải sau ngày nhận phòng.',
            'total_price.required' => 'Tổng giá là bắt buộc.',
            'status.required' => 'Trạng thái là bắt buộc.',
        ]);

        $booking = Booking::findBookingById($booking_id);
        if (!$booking) {
            return redirect()->route('admin.viewbookings')->with('error', 'Đặt phòng không tồn tại.');
        }

        $booking->user_id = $request->user_id;
        $booking->room_id = $request->room_id;
        $booking->promotion_id = $request->promotion_id;
        $booking->check_in = $request->check_in;
        $booking->check_out = $request->check_out;
        $booking->total_price = $request->total_price;
        $booking->status = $request->status;

        $booking->save();

        return redirect()->route('admin.viewbookings')->with('success', 'Cập nhật đặt phòng thành công.');
    }
}
