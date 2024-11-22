<?php 
namespace App\Services;

use App\Models\Booking;
use App\Models\Payments;
use App\Models\Promotions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;

class PaymentService
{
    public function handleVnpayPayment($data)
    {
        $totalAmount = $data['total_amount'];
        $daterange = $data['daterange'];
        $promotionId = $data['promotion_id'] ?? 0;

        if (!$daterange) {
            return ['success' => false, 'message' => 'Invalid date range'];
        }

        // Xử lý date range
        list($checkIn, $checkOut) = explode(' - ', $daterange);
        $checkInDay = Carbon::createFromFormat('d/m/Y', trim($checkIn));
        $checkOutDay = Carbon::createFromFormat('d/m/Y', trim($checkOut));

        // Validate promotion
        $promotion = null;
        if ($promotionId > 0) {
            $promotion = Promotions::where('promotion_id', $promotionId)->first();

            if (!$promotion) return ['success' => false, 'message' => 'Mã giảm giá không hợp lệ'];
            if ($promotion->start_date > Carbon::now()) return ['success' => false, 'message' => 'Mã giảm giá chưa tới ngày áp dụng.'];
            if ($promotion->end_date < Carbon::now()) return ['success' => false, 'message' => 'Mã giảm giá đã hết hạn.'];
        }

        // Tạo booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'room_id' => $data['room_id'],
            'promotion_id' => $promotion ? $promotionId : 0,
            'check_in' => $checkInDay->format('Y-m-d'),
            'check_out' => $checkOutDay->format('Y-m-d'),
            'total_price' => $totalAmount,
            'status' => 'pending',
        ]);

        // Tạo payment record
        $payment = Payments::create([
            'booking_id' => $booking->booking_id,
            'payment_status' => 'pending',
            'payment_method' => 'vnpay',
            'amount' => $totalAmount,
            'payment_date' => now(),
        ]);

        return ['booking' => $booking, 'payment' => $payment];
    }

    public function generateVnpayUrl($booking, $payment, $amount)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('booking.return');
        $vnp_TmnCode = "ILUA2M7T";
        $vnp_HashSecret = "JMCFDKLIECIUW02PETZH7U4OJN66EZ2P";
        $vnp_TxnRef = $booking->booking_id . '_' . time();
        $vnp_OrderInfo = "Thanh Toán Đặt Phòng #" . $booking->booking_id;

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale" => "VN",
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $hashdata = urldecode(http_build_query($inputData));
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $inputData['vnp_SecureHash'] = $vnpSecureHash;

        return $vnp_Url . '?' . http_build_query($inputData);
    }

    public function handlePaymentReturn($inputData, $bookingId, $paymentId)
    {
        $booking = Booking::find($bookingId);
        $payment = Payments::find($paymentId);

        if ($inputData['vnp_ResponseCode'] == '00') {
            // Cập nhật trạng thái
            if ($booking) $booking->update(['status' => 'confirmed']);
            if ($payment) $payment->update(['payment_status' => 'completed', 'payment_date' => now()]);

            // Gửi email xác nhận
            $user = $booking->user ?? null;
            try {
                if ($user) {
                    Mail::to($user->email)->send(new BookingConfirmationMail($booking, $payment, $user));
                }
                return ['success' => true, 'message' => 'Thanh toán thành công', 'emailSent' => true];
            } catch (\Exception $e) {
                return ['success' => true, 'message' => 'Thanh toán thành công', 'emailSent' => false];
            }
        } else {
            // Thanh toán thất bại
            if ($booking) $booking->update(['status' => 'cancelled']);
            if ($payment) $payment->update(['payment_status' => 'failed', 'payment_date' => now()]);

            return ['success' => false, 'message' => 'Thanh toán thất bại'];
        }
    }
}
