@extends('frontend.layouts.app')
@section('content')
<!-- Youtube Events -->
<div id="bodyContent" class="d-flex align-items-center">
    <div class="row mx-auto align-items-center">
        <div class="col-12 col-lg-6">
            <div class="p-2">
                <h1 class="fw-bolder maintextColor">Best Web Tool Platform</h1>
                <div class="horizontalBar my-4"></div>
                <p class="maintextColor fw-medium">With 50+ Online Tools, it will help your business to grow!.</p>
            </div>
        </div>
        <div class="col-12 col-lg-6 text-lg-center">
            <div class="p-2 text-center">
                <img class="w-100" src="{{ asset('/poster.png') }}" alt="hero-learn">
            </div>
        </div>
    </div>
</div>
@endsection