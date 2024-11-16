<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Rooms;
use App\Models\Promotions;
use Illuminate\Http\Request;
use App\Helpers\IdEncoder;
use App\Models\Payments;
use Illuminate\Support\Str;
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
        return redirect()->route('admin.viewbooking')->with('success', 'Thêm đặt phòng thành công.');
    }

    public function deleteBooking($id)
    {
        // Giải mã ID
        $bookingId = IdEncoder::decodeId($id);
        $booking = Booking::find($bookingId);

        if ($booking) {
            $booking->delete();
            return response()->json(['success' => true, 'message' => 'Đặt phòng đã được xóa.']);
        }

        return response()->json(['success' => false, 'message' => 'Đặt phòng không tồn tại.'], 404);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('search');
        $bookings = Booking::query()
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    // Tìm kiếm trên trường 'username' từ bảng 'users' với LIKE
                    $q->whereHas('user', function ($queryUser) use ($keyword) {
                        $queryUser->where('username', 'LIKE', "%{$keyword}%")
                                ->orWhere('email', 'LIKE', "%{$keyword}%"); // Thêm tìm kiếm email
                    })
                    // Tìm kiếm trên trường 'name' từ bảng 'rooms'
                    ->orWhereHas('room', function ($queryRoom) use ($keyword) {
                        $queryRoom->where('name', 'LIKE', "%{$keyword}%");
                    })
                    // Tìm kiếm trên trường 'promotion_code' từ bảng 'promotions'
                    ->orWhereHas('promotion', function ($queryPromo) use ($keyword) {
                        $queryPromo->where('promotion_code', 'LIKE', "%{$keyword}%");
                    });
                });
            })
            ->paginate(7);

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
            return redirect()->route('admin.viewbookings')->with('error', 'Đặt phòng không tồn tại.');
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
            return redirect()->route('admin.viewbooking')->with('error', 'Đặt phòng không tồn tại.');
        }

        $booking->user_id = $request->user_id;
        $booking->room_id = $request->room_id;
        $booking->promotion_id = $request->promotion_id;
        $booking->check_in = $request->check_in;
        $booking->check_out = $request->check_out;
        $booking->total_price = $request->total_price;
        $booking->status = $request->status;

        $booking->save();

        return redirect()->route('admin.viewbooking')->with('success', 'Cập nhật đặt phòng thành công.');
    }

    private $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    private $partnerCode = "MOMOBKUN20180529"; // Replace with your MoMo partner code
    private $accessKey = "klm05TvNBzhg7h7j"; // Replace with your MoMo access key
    private $secretKey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa"; // Replace with your MoMo secret key
    
    public function createBooking(Request $request)
    {
        // Validate the booking request
        $validated = $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'room_id' => 'required',
            'full_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'payment_method' => 'required|in:momo,card,banking,cod',
            'total_price' => 'required|numeric',
        ]);

        // Create booking record
        $booking = Booking::create([
            'user_id' => 1,
            'room_id' => 1,
            'promotion_id' => 1,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $request->total_price,
            'status' => 'pending'
        ]);

        // If payment method is MoMo, process MoMo payment
        if ($request->payment_method === 'momo') {
            return $this->processMoMoPayment($booking);
        }

        // Handle other payment methods...
        return response()->json(['message' => 'Booking created successfully']);
    }

    private function processMoMoPayment($booking)
    {
        $orderId = Str::random(32);
        $requestId = Str::random(32);
        $amount = $booking->total_price;
        $orderInfo = "Payment for booking #" . $booking->booking_id;
    
        // Create payment record
        $payment = Payments::create([
            'booking_id' => $booking->booking_id,
            'payment_status' => 'pending',
            'payment_method' => 'momo',
            'amount' => $amount,
            'payment_date' => now()
        ]);
    
        // Prepare the request to MoMo
        $rawHash = "accessKey=" . $this->accessKey .
            "&amount=" . $amount .
            "&extraData=" .
            "&ipnUrl=" . route('momo.ipn') .
            "&orderId=" . $orderId .
            "&orderInfo=" . $orderInfo .
            "&partnerCode=" . $this->partnerCode .
            "&redirectUrl=" . route('momo.return') .
            "&requestId=" . $requestId .
            "&requestType=captureWallet";
    
        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);
    
        $data = [
            'partnerCode' => $this->partnerCode,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => route('momo.return'),
            'ipnUrl' => route('momo.ipn'),
            'requestType' => 'captureWallet',
            'extraData' => '',
            'signature' => $signature
        ];
    
        // Send request to MoMo
        $ch = curl_init($this->endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($data))
        ]);
    
        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        $response = json_decode($result, true);
    
        if ($status == 200 && isset($response['payUrl'])) {
            // Store MoMo order ID for later verification
            $payment->update([
                'payment_id' => $orderId
            ]);
    
            return response()->json([
                'status' => 'success',
                'payUrl' => $response['payUrl']
            ]);
        }
    
        // Return detailed error message if available
        $errorMessage = isset($response['message']) ? $response['message'] : 'Failed to create MoMo payment';
    
        return response()->json([
            'status' => 'error',
            'message' => $errorMessage
        ], 500);
    }


    public function handleMoMoIPN(Request $request)
    {
        // Verify the signature from MoMo
        $rawHash = "accessKey=" . $this->accessKey .
            "&amount=" . $request->amount .
            "&extraData=" . $request->extraData .
            "&message=" . $request->message .
            "&orderId=" . $request->orderId .
            "&orderInfo=" . $request->orderInfo .
            "&orderType=" . $request->orderType .
            "&partnerCode=" . $request->partnerCode .
            "&payType=" . $request->payType .
            "&requestId=" . $request->requestId .
            "&responseTime=" . $request->responseTime .
            "&resultCode=" . $request->resultCode .
            "&transId=" . $request->transId;

        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);

        if ($signature !== $request->signature) {
            return response()->json([
                'message' => 'Invalid signature'
            ], 400);
        }

        // Find the payment record
        $payment = Payments::where('payment_id', $request->orderId)->first();
        
        if (!$payment) {
            return response()->json([
                'message' => 'Payment not found'
            ], 404);
        }

        // Update payment status based on MoMo response
        if ($request->resultCode == 0) {
            $payment->update([
                'payment_status' => 'completed',
                'payment_id' => $request->transId
            ]);

            // Update booking status
            $payment->booking->update([
                'status' => 'confirmed'
            ]);
        } else {
            $payment->update([
                'payment_status' => 'failed'
            ]);

            $payment->booking->update([
                'status' => 'payment_failed'
            ]);
        }

        return response()->json([
            'message' => 'IPN processed successfully'
        ]);
    }

    public function handleMoMoReturn(Request $request)
    {
        // Handle the return from MoMo payment page
        if ($request->resultCode == 0) {
            return redirect()->route('booking.success');
        }

        return redirect()->route('booking.failed');
    }   

}
