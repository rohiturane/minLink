@extends('admin.layouts.app')
@section('admin_content')

@php
$plan;$flag=false;
$currentPlan = auth()->user()->planSubscriptions->whereNull('cancels_at')->first();
$pastPlan =auth()->user()->planSubscriptions->whereNotNull('cancels_at')->first();
if(!empty($currentPlan->plan)){
    $plan = json_decode($currentPlan->plan);
} else {
    $plan = json_decode($pastPlan->plan);
    $flag = true;
}
@endphp
<style>
    .pricing-content {
        position: relative;
    }

    .pricing_design {
        position: relative;
        margin: 0px 15px;
    }

    .pricing_design .single-pricing {
        background: #8100ed;
        padding: 60px 40px;
        border-radius: 30px;
        box-shadow: 0 10px 40px -10px rgba(0, 64, 128, .2);
        position: relative;
        z-index: 1;
    }

    .pricing_design .single-pricing:before {
        content: "";
        background-color: #fff;
        width: 100%;
        height: 100%;
        border-radius: 18px 18px 190px 18px;
        border: 1px solid #eee;
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: -1;
    }

    .price-head {}

    .price-head h2 {
        margin-bottom: 20px;
        font-size: 26px;
        font-weight: 600;
    }

    .price-head h1 {
        font-weight: 600;
        margin-top: 30px;
        margin-bottom: 5px;
    }

    .price-head span {}

    .single-pricing ul {
        list-style: none;
        margin-top: 30px;
    }

    .single-pricing ul li {
        line-height: 36px;
    }

    .single-pricing ul li i {
        background: #554c86;
        color: #fff;
        width: 20px;
        height: 20px;
        border-radius: 30px;
        font-size: 11px;
        text-align: center;
        line-height: 20px;
        margin-right: 6px;
    }

    .pricing-price {}

    .price_btn {
        background: #554c86;
        padding: 10px 30px;
        color: #fff;
        display: inline-block;
        margin-top: 20px;
        border-radius: 2px;
        -webkit-transition: 0.3s;
        transition: 0.3s;
    }

    .price_btn:hover {
        background: #0aa1d6;
    }

    a {
        text-decoration: none;
    }

    .section-title {
        margin-bottom: 60px;
    }

    .text-center {
        text-align: center !important;
    }

    .section-title h2 {
        font-size: 45px;
        font-weight: 600;
        margin-top: 0;
        position: relative;
        text-transform: capitalize;
    }
</style>
<section id="pricing" class="pricing-content section-padding pt-5 pb-5">
    <div class="container pt-4">
        <div class="section-title text-center">
            <h2>Pricing Plans</h2>
            <p>Choose a plan that works best for you and your teams</p>
        </div>
        <div class="row text-center">
            @foreach($plans as $plan)
            <div class="col-lg-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s" data-wow-offset="0" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInUp;">
                <div class="pricing_design">
                    <div class="single-pricing">
                        <div class="price-head">
                            <h2>{{$plan->name}}</h2>
                            <h1>{{$plan->price}}</h1>
                            <span>/Monthly</span>
                        </div>
                        <ul>
                            @foreach($plan->features as $feature)
                            <li><b>{{$feature->value}}</b> {{$feature->name}}</li>
                            @endforeach
                        </ul>
                        <div class="pricing-price">

                        </div>
                        @if($currentPlan->plan_id == $plan->id)
                            <p class="btn btn-primary">{{'Current Package'}}</p>
                        @else 
                            <a href="{{ url('/admin/plan/'.$plan->slug)}}" class="btn btn-primary">{{'Change Package'}}</a>
                        @endif
                    </div>
                </div>
            </div><!--- END COL -->
            @endforeach
            
            <!-- <div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s" data-wow-offset="0" style="visibility: visible; animation-duration: 1s; animation-delay: 0.3s; animation-name: fadeInUp;">
                <div class="pricing_design">
                    <div class="single-pricing">
                        <div class="price-head">
                            <h2>Ultimate</h2>
                            <h1 class="price">$49</h1>
                            <span>/Monthly</span>
                        </div>
                        <ul>
                            <li><b>15</b> website</li>
                            <li><b>50GB</b> Disk Space</li>
                            <li><b>50</b> Email</li>
                            <li><b>50GB</b> Bandwidth</li>
                            <li><b>10</b> Subdomains</li>
                            <li><b>Unlimited</b> Support</li>
                        </ul>
                        <div class="pricing-price">

                        </div>
                        <a href="#" class="price_btn">Order Now</a>
                    </div>
                </div>
            </div> -->
        </div><!--- END ROW -->
    </div><!--- END CONTAINER -->
</section>
@endsection