<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Payments;
use App\Models\Promotions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class PaymentsController extends Controller
{
    public function payment_vnpay(Request $request)
    {
        $totalAmount = $request->total_price;
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
        $promotion = Promotions::where('promotion_id', $request->promotion_id)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->first();
        if (!$promotion && $request->promotion_id) {
            return back()->with('error', 'Mã giảm giá không hợp lệ');
        }
        // Nếu promotion không tồn tại hoặc không hợp lệ, sử dụng giá trị mặc định
        $finalPromotionId = $promotion ? $request->promotion_id : 0;
        // First create the booking record
        $booking = Booking::create([
            'user_id' => auth()->id(), // Assuming user is logged in
            'room_id' => $request->room_id,
            'promotion_id' => $finalPromotionId,
            'check_in' => $checkInDay->format('Y-m-d'),
            'check_out' => $checkOutDay->format('Y-m-d'),
            'total_price' => $totalAmount,
            'status' => 'pending'
        ]);

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('booking.return');
        $vnp_TmnCode = "YY5IYYIV";
        $vnp_HashSecret = "2UEZR23L1UAY6JMGEA7H1SS96JW6NV0S";
        $vnp_TxnRef = $booking->booking_id . '_' . time();
        $vnp_OrderInfo = "Thanh Toán Đặt Phòng #" . $booking->booking_id;
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $request->total_amount * 100;
        $vnp_Locale = "VN";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $payment = Payments::create([
            'booking_id' => $booking->booking_id,
            'payment_status' => 'pending',
            'payment_method' => 'vnpay',
            'amount' => $request->total_amount,
            'payment_date' => now()
        ]);

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        // Store the VNPay URL and transaction reference in session for verification
        session(['vnpay_booking_id' => $booking->booking_id]);
        session(['vnpay_payment_id' => $payment->payment_id]);

        return redirect($vnp_Url);
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
        $totalAmount = $request->total_price;
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
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->first();

        if (!$promotion && $request->promotion_id) {
            return back()->with('error', 'Mã giảm giá không hợp lệ');
        }
        $finalPromotionId = $promotion ? $request->promotion_id : 0;

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
            'amount' => $request->total_amount,
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
    public function paymentReturn(Request $request)
    {
        $inputData = $request->all();
        // Retrieve booking and payment IDs from session
        $booking_id = session('vnpay_booking_id');
        $payment_id = session('vnpay_payment_id');
        // Clear the session data
        session()->forget(['vnpay_booking_id', 'vnpay_payment_id']);
        // Verify the payment response
        if ($inputData['vnp_ResponseCode'] == '00') {
            // Payment successful
            // Update booking status
            $booking = Booking::find($booking_id);
            if ($booking) {
                $booking->update([
                    'status' => 'confirmed'
                ]);
                // Get related user data
                $user = $booking->user;
                // Update payment status
                $payment = Payments::find($payment_id);
                if ($payment) {
                    $payment->update([
                        'payment_status' => 'completed',
                        'payment_date' => now()
                    ]);
                    // Send confirmation email
                    try {
                        Mail::to($user->email)->send(new BookingConfirmationMail($booking, $payment, $user));
                        $emailSent = true; // Set to true if email is sent successfully
                    } catch (\Exception $e) {
                        // Log email sending error but don't interrupt the process
                        // \Log::error('Failed to send confirmation email: ' . $e->getMessage());
                        $emailSent = false;
                    }
                }
            }
            return view('booking.return', [
                'success' => true,
                'message' => 'Thanh toán thành công',
                'inputData' => $inputData,
                'emailSent' => $emailSent,
            ]);
        } else {
            // Payment failed logic remains the same
            $booking = Booking::find($booking_id);
            if ($booking) {
                $booking->update([
                    'status' => 'cancelled'
                ]);
            }
            $payment = Payments::find($payment_id);
            if ($payment) {
                $payment->update([
                    'payment_status' => 'failed',
                    'payment_date' => now()
                ]);
            }

            return view('booking.return', [
                'success' => false,
                'message' => 'Thanh toán thất bại',
                'inputData' => $inputData
            ]);
        }
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
