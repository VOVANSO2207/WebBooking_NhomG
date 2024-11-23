<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Payments;
use App\Models\Promotions;
use App\Services\VNPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class PaymentsController extends Controller
{
    protected $vnPayService;

    public function __construct(VNPayService $vnPayService)
    {
        $this->vnPayService = $vnPayService;
    }
    public function payment_vnpay(Request $request)
    {
        $totalAmount = $request->total_amount;
        $daterange = $request->input('daterange') ?? session('daterange');
        
        if (!$daterange) {
            return back()->with('error', 'Invalid date range');
        }
        
        // Split the date range
        list($checkIn, $checkOut) = explode(' - ', $daterange);
        
        // Convert dates to Carbon instances
        $checkInDay = \Carbon\Carbon::createFromFormat('d/m/Y', trim($checkIn));
        $checkOutDay = \Carbon\Carbon::createFromFormat('d/m/Y', trim($checkOut));

        $promotionId = $request->promotion_id ?? 0;
        $promotion = null;

        // Check if there's a valid promotion
        if ($promotionId > 0) {
            $promotion = Promotions::where('promotion_id', $promotionId)->first();
            if (!$promotion) {
                return back()->with('error', 'Mã giảm giá không hợp lệ');
            }
            if ($promotion->start_date > Carbon::now()) {
                return back()->with('error', 'Mã giảm giá chưa tới ngày áp dụng.');
            }
            if ($promotion->end_date < Carbon::now()) {
                return back()->with('error', 'Mã giảm giá đã hết hạn.');
            }
        }

        $finalPromotionId = $promotion ? $promotionId : 0;

        // Create the booking
        $booking = Booking::create([
            'user_id' => auth()->id(), // Assuming user is logged in
            'room_id' => $request->room_id,
            'promotion_id' => $finalPromotionId,
            'check_in' => $checkInDay->format('Y-m-d'),
            'check_out' => $checkOutDay->format('Y-m-d'),
            'total_price' => $totalAmount,
            'status' => 'pending'
        ]);

        // Create payment record
        $payment = Payments::create([
            'booking_id' => $booking->booking_id,
            'payment_status' => 'pending',
            'payment_method' => 'vnpay',
            'amount' => $request->total_amount,
            'payment_date' => now()
        ]);

        // Call the VNPay service to create the URL
        $vnpayUrl = $this->vnPayService->createVNPayUrl($request, $booking);

        // Store the VNPay transaction reference in session for verification
        session(['vnpay_booking_id' => $booking->booking_id]);
        session(['vnpay_payment_id' => $payment->payment_id]);

        // Redirect to VNPay payment gateway
        return redirect($vnpayUrl);
    }
    public function paymentReturn(Request $request)
    {
        $inputData = $request->all();
        $booking_id = session('vnpay_booking_id');
        $payment_id = session('vnpay_payment_id');

        // Xóa session
        session()->forget(['vnpay_booking_id', 'vnpay_payment_id']);

        if ($inputData['vnp_ResponseCode'] == '00') {
            // Thanh toán thành công
            $emailSent = $this->vnPayService->handleSuccessfulPayment($booking_id, $payment_id, $inputData);
            return view('booking.return', [
                'success' => true,
                'message' => 'Thanh toán thành công',
                'inputData' => $inputData,
                'emailSent' => $emailSent,
            ]);
        } else {
            // Thanh toán thất bại
            $this->vnPayService->handleFailedPayment($booking_id, $payment_id, $inputData);
            return view('booking.return', [
                'success' => false,
                'message' => 'Thanh toán thất bại',
                'inputData' => $inputData
            ]);
        }
    }
    public function processPayment(Request $request)
    {
        try {
            // Validate required fields
            $request->validate([
                'payment_method' => 'required|in:vnpay,momo,cod',
            ], [
                'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
                'payment_method.in' => 'Phương thức thanh toán không hợp lệ.'
            ]);

            // Determine payment method and route accordingly
            switch ($request->payment_method) {
                case 'vnpay':
                    return $this->payment_vnpay($request);

                    // case 'momo':
                    //     return $this->payment_momo($request);

                    // case 'banking':
                    //     return $this->payment_banking($request);

                case 'cod':
                    return $this->payment_on_checkin($request);

                default:
                    return back()->with('error', 'Phương thức thanh toán không hợp lệ');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function payment_on_checkin(Request $request)
    {
        $totalAmount = $request->total_amount;
        $daterange = $request->input('daterange') ?? session('daterange');

        // Validate daterange exists
        if (!$daterange) {
            return back()->with('error', 'Invalid date range');
        }

        // Split the date range
        list($checkIn, $checkOut) = explode(' - ', $daterange);

        // Convert dates to Carbon instances
        $checkInDay = \Carbon\Carbon::createFromFormat('d/m/Y', trim($checkIn));
        $checkOutDay = \Carbon\Carbon::createFromFormat('d/m/Y', trim($checkOut));

        // Check promotion validity
        $promotion = Promotions::where('promotion_id', $request->promotion_id)
            // ->where('start_date', '<=', Carbon::now())
            // ->where('end_date', '>=', Carbon::now())
            ->first();
        $promotionId = $request->promotion_id ?? 0;

        $promotion = null;
        // Chỉ truy vấn mã giảm giá nếu promotion_id khác 0
        if ($promotionId > 0) {
            $promotion = Promotions::where('promotion_id', $promotionId)->first();

            if (!$promotion) {
                return back()->with('error', 'Mã giảm giá không hợp lệ');
            }

            if ($promotion->start_date > Carbon::now()) {
                return back()->with('error', 'Mã giảm giá chưa tới ngày áp dụng.');
            }

            if ($promotion->end_date < Carbon::now()) {
                return back()->with('error', 'Mã giảm giá đã hết hạn.');
            }
        }
        $finalPromotionId = $promotion ? $promotionId : 0;

        // Create booking record with pending status
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'room_id' => $request->room_id,
            'promotion_id' => $finalPromotionId,
            'check_in' => $checkInDay->format('Y-m-d'),
            'check_out' => $checkOutDay->format('Y-m-d'),
            'total_price' => $totalAmount,
            'status' => 'pending',
            'payment_method' => 'check_in'
        ]);

        // Create a payment record with pending status
        $payment = Payments::create([
            'booking_id' => $booking->booking_id,
            'payment_status' => 'pending',
            'payment_method' => 'check_in', 
            'amount' => $totalAmount,
            'payment_date' => now()
        ]);
        session(['booking_id' => $booking->booking_id]);
        // Redirect to a confirmation or room selection page
        return redirect()->route('booking.return_cod', ['booking' => $booking])
            ->with('success', 'Đặt phòng thành công. Thanh toán sẽ được thực hiện khi nhận phòng.');
    }
    public function codPaymentReturn(Request $request)
    {
        // Validate booking ID
        $booking_id = session('booking_id');
        if (!$booking_id) {
            return back()->with('error', 'Không tìm thấy thông tin đặt phòng');
        }

        // Find booking
        $booking = Booking::findOrFail($booking_id);
        $user = $booking->user;

        // Check if email was sent successfully
        $emailSent = false;
        try {
            Mail::to($user->email)->send(new BookingConfirmationMail($booking, null, $user));
            $emailSent = true;
        } catch (\Exception $e) {
            // \Log::error('Failed to send COD booking confirmation email: ' . $e->getMessage());
        }

        // Update booking status (optional - depends on your business logic)
        $booking->update([
            'status' => 'confirmed'
        ]);

        // Render return view
        return view('booking.return_cod', [
            'success' => true,
            'message' => 'Thanh toán thành công',
            'booking' => $booking,
            'user' => $user,
            'emailSent' => $emailSent
        ]);
    }
   

    public function viewPay()
    {
        return view('pages.pay');
    }
    public function getInfoPayment($hotel_id)
    {
        $hotels = Hotel::with('images', 'city', 'rooms')->findOrFail($hotel_id);
        $room = $hotels->rooms()->get();
        return view('pages.pay', compact('hotels', 'room'));
    }
}
