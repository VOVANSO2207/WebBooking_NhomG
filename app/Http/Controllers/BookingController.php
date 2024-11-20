<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Rooms;
use App\Models\Promotions;
use Illuminate\Http\Request;
use App\Helpers\IdEncoder;
use App\Models\Payments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class BookingController extends Controller
{
    public function viewBooking()
    {
        $bookings = Booking::getAllBookings();
        return view('admin.booking', compact('bookings'));
    }
    public function showBookingBill()
    {
        $bookings = Booking::where('user_id', auth()->id())->paginate(2);

        return view('pages.account', compact('bookings'));
    }

    public function bookingAdd()
    {
        return view('admin.booking_add');
    }

    public function getBookingDetail($booking_id)
    {
        // Giải mã ID
        $decodedId = IdEncoder::decodeId($booking_id);
        $booking = Booking::findBookingById($decodedId);

        if (!$booking) {
            return response()->json(['error' => 'Đặt phòng không tồn tại'], 404);
        }

        return response()->json([
            'user_id' => $booking->user->username ?? 'N/A',
            'room_id' => $booking->room->name ?? 'N/A',
            'promotion_id' => $booking->promotion->promotion_code ?? 'N/A',
            'check_in' => $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') : 'N/A',
            'check_out' => $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') : 'N/A',
            'total_price' => $booking->total_price !== null ? number_format($booking->total_price, 0, ',', '.') . ' VNĐ' : 'N/A',
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
        return redirect()->route('admin.viewbooking')->with('success', 'Thêm đơn đặt phòng thành công.');
    }

    public function deleteBooking($id)
    {
        // Giải mã ID
        $bookingId = IdEncoder::decodeId($id);
        $booking = Booking::find($bookingId);

        if ($booking) {
            // Xóa Đặt phòng
            $booking->delete();

            // Gửi thông báo thành công vào session
            return redirect()->route('admin.viewbooking')->with('success', 'Đơn đặt phòng đã được xóa thành công.');
        }

        // Nếu không tìm thấy Đặt phòng, gửi thông báo lỗi vào session
        return redirect()->route('admin.viewbooking')->with('error', 'Đơn đặt phòng không tồn tại.');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('search');

        // Gọi phương thức searchBooking trong Model Booking
        $bookings = Booking::searchBooking($keyword)->paginate(7);

        return view('admin.search_results_booking', compact('bookings'));
    }

    public function editBooking($booking_id)
    {
        // Tìm booking theo ID
        // Giải mã ID
        $decodedId = IdEncoder::decodeId($booking_id);
        $booking = Booking::findBookingById($decodedId);

        // Kiểm tra nếu booking không tồn tại
        if (!$booking) {
            return redirect()->route('admin.viewbookings')->with('error', 'Đơn đặt phòng không tồn tại.');
        }

        // Lấy danh sách người dùng, phòng, và khuyến mãi
        $users = User::all(); // Lấy tất cả người dùng
        $rooms = Rooms::all(); // Lấy tất cả phòng
        $promotions = Promotions::all(); // Lấy tất cả khuyến mãi

        // Truyền booking và danh sách dữ liệu vào view
        return view('admin.booking_edit', compact('booking', 'users', 'rooms', 'promotions'));
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
            return redirect()->route('admin.viewbooking')->with('error', 'Đơn đặt phòng không tồn tại.');
        }

        $booking->user_id = $request->user_id;
        $booking->room_id = $request->room_id;
        $booking->promotion_id = $request->promotion_id;
        $booking->check_in = $request->check_in;
        $booking->check_out = $request->check_out;
        $booking->total_price = $request->total_price;
        $booking->status = $request->status;

        $booking->save();

        return redirect()->route('admin.viewbooking')->with('success', 'Cập nhật đơn đặt phòng thành công.');
    }


}
