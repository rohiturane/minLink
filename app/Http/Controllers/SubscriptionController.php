<?php

namespace App\Http\Controllers;

use App\Models\User;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use LucasDotVin\Soulbscription\Models\Plan;

class SubscriptionController extends Controller
{
    public function cancelPlan()
    {
        $user = User::find(auth()->id());

        $user->subscription->cancel();

        session()->flash('status','success');
        session()->flash('message', 'Your Plan is cancelled successfully!');

        return redirect('/admin/profile');
    }

    public function plans()
    {
        $plans = Plan::get();

        return view('admin.plans', compact('plans'));
    }

    public function selectPlan($id)
    {
        $id = decode($id);
        $plan = Plan::where('id', $id)->first();
        
        $orderData = [
            'receipt'         => 'receipt-'.randomString(6),
            'amount'          => $plan->amount*100,
            'currency'        => 'INR',
            "notes" => [
                "customer_id" => auth()->user()->id,
                "plan_id" => $id
            ],
        ];
        
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
        $razorpayOrder = $api->order->create($orderData);
        return view('admin.razorpay',compact('razorpayOrder', 'plan'));
    }


}
