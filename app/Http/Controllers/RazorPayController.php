<?php
namespace App\Http\Controllers;

use Exception;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RazorPayController extends Controller
{
    public function index()
    {
        $orderData = [
            'receipt'         => 'rcptid_11',
            'amount'          => 500, // 39900 rupees in paise
            'currency'        => 'INR'
        ];
        
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
        $razorpayOrder = $api->order->create($orderData);
        return view('admin.razorpay',compact('razorpayOrder'));
    }

    public function handlePayment(Request $request)
    {
        $input = $request->all();
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture([
                    'amount' => $payment['amount']
                ]);
            } catch (Exception $e) {
                Log::info($e->getMessage());
                return back()->withError($e->getMessage());
            }
        }
        return back()->withSuccess('Payment done.');
    }

}