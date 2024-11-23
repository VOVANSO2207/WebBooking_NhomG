<?php

namespace App\Services;

use App\Mail\BookingConfirmationMail;
use Carbon\Carbon;
use App\Models\Promotions;
use App\Models\Booking;
use App\Models\Payments;
use Illuminate\Support\Facades\Mail;

class VNPayService
{
    protected $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    protected $vnp_TmnCode = "ILUA2M7T";
    protected $vnp_HashSecret = "JMCFDKLIECIUW02PETZH7U4OJN66EZ2P";
    protected $vnp_Locale = "VN";
    protected $vnp_CurrCode = "VND";
    protected $vnp_BankCode = "NCB"; // Default bank code

    public function createVNPayUrl($request, $booking)
    {
        // Extract the necessary data
        $vnp_TxnRef = $booking->booking_id . '_' . time();
        $vnp_OrderInfo = "Thanh Toán Đặt Phòng #" . $booking->booking_id;
        $vnp_Amount = $request->total_amount * 100; // Convert to VND (100 to apply currency factor)
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnp_Returnurl = route('booking.return');

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => $this->vnp_CurrCode,
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $this->vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        if (!empty($this->vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $this->vnp_BankCode;
        }

        ksort($inputData);  // Sort the data
        $query = "";
        $hashdata = "";
        $i = 0;
        
        // Prepare hash data and query string
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $this->vnp_Url . "?" . $query;

        if (isset($this->vnp_HashSecret)) {
            // Generate secure hash for the URL
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $this->vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }
    public function handleSuccessfulPayment($booking_id, $payment_id, $inputData)
    {
        // Cập nhật trạng thái đặt phòng
        $booking = Booking::find($booking_id);
        if ($booking) {
            $booking->update(['status' => 'confirmed']);
        }

        // Cập nhật trạng thái thanh toán
        $payment = Payments::find($payment_id);
        if ($payment) {
            $payment->update([
                'payment_status' => 'completed',
                'payment_date' => now()
            ]);
        }

        // Gửi email xác nhận
        return $this->sendBookingConfirmationEmail($booking, $payment);
    }

    public function handleFailedPayment($booking_id, $payment_id, $inputData)
    {
        // Cập nhật trạng thái đặt phòng thành "cancelled"
        $booking = Booking::find($booking_id);
        if ($booking) {
            $booking->update(['status' => 'cancelled']);
        }

        // Cập nhật trạng thái thanh toán thành "failed"
        $payment = Payments::find($payment_id);
        if ($payment) {
            $payment->update([
                'payment_status' => 'failed',
                'payment_date' => now()
            ]);
        }

        return false;
    }

    private function sendBookingConfirmationEmail($booking, $payment)
    {
        try {
            $user = $booking->user;
            Mail::to($user->email)->send(new BookingConfirmationMail($booking, $payment, $user));
            return true;
        } catch (\Exception $e) {
            // \Log::error('Failed to send confirmation email: ' . $e->getMessage());
            return false;
        }
    }
}
