<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MomoPaymentService
{
    protected $endpoint;
    protected $partnerCode;
    protected $accessKey;
    protected $secretKey;

    public function __construct()
    {
        $this->endpoint = config('services.momo.endpoint');
        $this->partnerCode = config('services.momo.partner_code');
        $this->accessKey = config('services.momo.access_key');
        $this->secretKey = config('services.momo.secret_key');
    }

    public function createPaymentUrl(array $data)
    {
        $requestId = time() . "";
        $requestType = "captureWallet";
        
        $rawHash = "accessKey=" . $this->accessKey .
            "&amount=" . $data['amount'] .
            "&extraData=" .
            "&ipnUrl=" . $data['notifyUrl'] .
            "&orderId=" . $data['orderId'] .
            "&orderInfo=" . $data['orderInfo'] .
            "&partnerCode=" . $this->partnerCode .
            "&redirectUrl=" . $data['returnUrl'] .
            "&requestId=" . $requestId .
            "&requestType=" . $requestType;

        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);

        $requestData = [
            'partnerCode' => $this->partnerCode,
            'requestId' => $requestId,
            'amount' => $data['amount'],
            'orderId' => $data['orderId'],
            'orderInfo' => $data['orderInfo'],
            'redirectUrl' => $data['returnUrl'],
            'ipnUrl' => $data['notifyUrl'],
            'requestType' => $requestType,
            'extraData' => '',
            'signature' => $signature,
            'lang' => 'vi'
        ];

        $response = Http::post($this->endpoint . '/create', $requestData);
        
        if ($response->successful()) {
            $result = $response->json();
            if ($result['resultCode'] == 0) {
                return $result['payUrl'];
            }
            throw new \Exception($result['message']);
        }

        throw new \Exception('Không thể kết nối đến MoMo');
    }

    public function verifyPayment(array $data)
    {
        $rawHash = "accessKey=" . $this->accessKey .
            "&amount=" . $data['amount'] .
            "&extraData=" . $data['extraData'] .
            "&message=" . $data['message'] .
            "&orderId=" . $data['orderId'] .
            "&orderInfo=" . $data['orderInfo'] .
            "&orderType=" . $data['orderType'] .
            "&partnerCode=" . $data['partnerCode'] .
            "&payType=" . $data['payType'] .
            "&requestId=" . $data['requestId'] .
            "&responseTime=" . $data['responseTime'] .
            "&resultCode=" . $data['resultCode'] .
            "&transId=" . $data['transId'];

        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);

        if ($signature != $data['signature']) {
            throw new \Exception('Invalid signature');
        }

        return [
            'success' => $data['resultCode'] == 0,
            'message' => $data['message'],
            'orderId' => $data['orderId'],
            'transId' => $data['transId'],
            'amount' => $data['amount']
        ];
    }
}