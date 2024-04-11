<?php
namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Log;
use Laravelcm\Subscriptions\Models\Plan;

class RazorPayController extends Controller
{
    protected $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $orderData = [
            'receipt'         => 'rcptid_11',
            'amount'          => 1000,
            'currency'        => 'INR',
            "notes" => [
                "customer_id" => auth()->user()->id,
                "user_invoice_id" => 2,
            ],
        ];
        
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
        $razorpayOrder = $api->order->create($orderData);
        return view('admin.razorpay',compact('razorpayOrder'));
    }

    public function handlePayment(Request $request)
    {
        $input = $request->all();
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
        $payment = $api->payment->fetch($input['response']['razorpay_payment_id']);
        if (count($input) && !empty($input['response']['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['response']['razorpay_payment_id'])->capture([
                    'amount' => $payment['amount']
                ]);
                $data = [
                    'user_id' => $response['notes']['customer_id'],
                    //'user_invoice_id' => $response['notes']['user_invoice_id'],
                    'payment_platform' => 'razorpay',
                    'payment_platform_ref_no' => $response['order_id'],
                    'status' => $response['status'],
                    'amount' => $response['amount']/100,
                    'payment_payload' => json_encode($response)
                ];
                $result = $this->service->store($data);
                // old subscription expire on this month and new subscription start from next month
                $user = User::find(auth()->id());
                $plan = Plan::where('slug', $response['notes']['slug'])->first();
                $user->newPlanSubscription('primary', $plan);

                session()->flash('status','success');
                session()->flash('message', 'The payment has been successfully processed.');

                return response()->json(['status' => true,'redirectTo' => '/admin/dashboard']);

            } catch (\Exception $e) {
                Log::info($e->getMessage());
                session()->flash('status','error');
                session()->flash('message', $e->getMessage());

                return response()->json(['status' => false,'redirectTo' => '/admin/dashboard']);
            }
        } else {
            session()->flash('status','error');
            session()->flash('message', 'Signature not matched');
            return response()->json(['status'=>false, 'message'=>'something went wrong!!']);
        }
    }

}