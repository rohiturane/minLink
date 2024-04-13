@extends('admin.layouts.app')
@section('admin_content')
<div class="container-fluid">
    <div class="container-fluid">
        <!-- <div class="card">
            <div class="card-body">
                <button id="rzp-button1" class="btn btn-primary">Pay</button>
            </div>
        </div> -->
    </div>
</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "{{ env('RAZORPAY_KEY_ID') }}", // Enter the Key ID generated from the Dashboard
    "amount": "{{ $plan->amount*100 }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    "currency": "INR",
    "name": "{{ env('APP_NAME') }}",
    "order_id": "{{$razorpayOrder['id']}}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
    "handler": function (response){
        console.log(response);
        $.ajax({
            url: "{{url('/admin/transaction-success')}}",
            method: 'post',
            data: { "_token": "{{ csrf_token() }}", response: response},
            success: function(result){
                window.location.href= result.redirectTo;
            }
        });
    },
    "theme": {
        "color": "#8100ed"
    }
};
var rzp1 = new Razorpay(options);
rzp1.on('payment.failed', function (response){
        $.ajax({
            url: "{{url('/admin/transaction-failed')}}",
            method: 'post',
            data: response,
            success: function(response){
                console.log(response);
            }
        });
});
document.addEventListener('DOMContentLoaded', function(e) {
    rzp1.open();
    e.preventDefault();
}, false);
</script>
@endsection
