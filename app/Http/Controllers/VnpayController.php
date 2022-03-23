<?php

namespace App\Http\Controllers;

use App\Models\cv;
use App\Models\Region;
use App\Models\Test;
use App\Models\vnpay_payment;
use Illuminate\Http\Request;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;

class VnpayController extends Controller
{
    //
    function showReturn()
    {
       // return request()->all();
        return Region::find(1);
    }

    function ipn()
    {

        $vnp_HashSecret = "FBGISFQZIIMKBARPZOLWYNZKEDJMTKEO"; //Secret key
        $inputData = array();
        $returnData = array();
        foreach (request()->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi

        $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
        $orderId = $inputData['vnp_TxnRef'];

        try {
            //Check Orderid    
            //Kiểm tra checksum của dữ liệu
            foreach (vnpay_payment::get() as $payment) {
                if ($payment->order_id == $orderId) {
                    $returnData['RspCode'] = '11';
                    return $returnData;
                }
            }
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);   
                if (request()->input('vnp_ResponseCode') == '00' || request()->input('vnp_TransactionStatus') == '00') {
                    $Status = 1; // Trạng thái thanh toán thành công
                } else {
                    $Status = 2; // Trạng thái thanh toán thất bại / lỗi
                }
                //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
                //
                //
                //
                //Trả kết quả về cho VNPAY: Website/APP TMĐT ghi nhận yêu cầu thành công                
                $returnData['RspCode'] = '00';
                $returnData['Message'] = 'Confirm Success';
                vnpay_payment::create([
                    "order_id" => $orderId,
                    "vnp_TransactionNo" => request()->vnp_TransactionNo,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_BankCode" => $vnp_BankCode,
                    "vnp_CardType" => request()->vnp_CardType,
                    "vnp_OrderInfo" => request()->vnp_OrderInfo,
                ]);
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
        } catch (Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        return $returnData;
    }
}
