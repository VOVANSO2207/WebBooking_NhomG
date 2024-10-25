<?php

namespace App\Helpers;

class IdEncoder
{
    // Hàm mã hóa ID
    public static function encodeId($id) {
        // Mã hoá theo quy ước
        $encodingMap = [
            '0' => 'ABC',
            '1' => 'DEF',
            '2' => '*&BUYG',
            '3' => ')(*YH',
            '4' => 'XYZ',
            '5' => 'PQR',
            '6' => 'LMN',
            '7' => 'JKL',
            '8' => 'TUV',
            '9' => 'WXY'
        ];
                                    
        // Mã hóa ID
        $encodedId = '';
        foreach (str_split($id) as $digit) {
            if (isset($encodingMap[$digit])) {
                // Mã hóa chữ số và thêm ký tự ngẫu nhiên
                $encodedId .= $encodingMap[$digit] . self::generateRandomString(15);
            }
        }

        return $encodedId;
    }

    // Hàm giải mã ID
    public static function decodeId($encodedId) {
        // Giải mã mã hoá để có thể truy cập id
        $decodingMap = [
            'ABC' => '0',
            'DEF' => '1',
            '*&BUYG' => '2',
            ')(*YH' => '3',
            'XYZ' => '4',
            'PQR' => '5',
            'LMN' => '6',
            'JKL' => '7',
            'TUV' => '8',
            'WXY' => '9'
        ];

        $decodedId = '';
        while ($encodedId) {
            $found = false;
            foreach ($decodingMap as $key => $digit) {
               
                if (strpos($encodedId, $key) === 0) {
                    $decodedId .= $digit;
                    $encodedId = substr($encodedId, strlen($key));
                   
                    $encodedId = substr($encodedId, 15);
                    $found = true;
                    break; 
                }
            }
            if (!$found) {
                
                break;
            }
        }

        return $decodedId;
    }

    // Hàm tạo chuỗi ngẫu nhiên
    private static function generateRandomString($length = 15) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
