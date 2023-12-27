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
@php
    $youtube_tools = $tools->filter(function($item) {
        return $item->section == 1;
    });
    $seo_tools = $tools->filter(function($item) {
        return $item->section == 2;
    });
    $image_tools = $tools->filter(function($item) {
        return $item->section == 3;
    });
    $developer_tools = $tools->filter(function($item) {
        return $item->section == 4;
    });
    $another_tools = $tools->filter(function($item) {
        return $item->section == 5;
    });
@endphp
@if(!$youtube_tools->isEmpty())
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-9 col-12">
            <div class="text-center mb-4" style="color: #1C4980;">
                <h4>Youtube SEO Tools</h4>
                <p>This is One of the greatest SEO Tools for your Business</p>
            </div>
            <div class="row">
                {!! show_ads('youtube_horizontal') !!}
                @foreach($youtube_tools as $tool)
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <a class="card text-decoration-none cursor-pointer item-box" href="{{url($tool->link)}}">
                            <div class="card-body align-items-center d-flex justify-content-center">
                                <div class="d-flex align-items-center">
                                    <img class="avatar rounded-0 lazyload" src="{{ asset($tool->image)}}">
                                    <div class="name ps-3">
                                        <div class="font-weight-medium tool-name">{{ $tool->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                
                {!! show_ads('youtube_horizontal_end') !!}
            </div>
        </div>
        <div class="col-lg-3">
            <div id="rightside-bar">
                {!! show_ads('youtube_vertical') !!}
            </div>
        </div>
    </div>
</div> 
@endif
@if(!$seo_tools->isEmpty())
<div class="main-content bg-aliceblue mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-9 col-12">
            <div class="text-center mb-4" style="color: #1C4980;">
                <h4>Blog SEO Tools</h4>
                <p>This is One of the greatest SEO Tools for your Business</p>
            </div>
            <div class="row">
                {!! show_ads('seo_horizontal') !!}
                @foreach($seo_tools as $tool)
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <a class="card text-decoration-none cursor-pointer item-box" href="{{url($tool->link)}}">
                            <div class="card-body align-items-center d-flex justify-content-center">
                                <div class="d-flex align-items-center">
                                    <img class="avatar rounded-0 lazyload" src="{{ asset($tool->image)}}">
                                    <div class="name ps-3">
                                        <div class="font-weight-medium tool-name">{{ $tool->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                {!! show_ads('seo_horizontal_end') !!}
            </div>
        </div>
        <div class="col-lg-3">
            <div id="rightside-bar">
                {!! show_ads('seo_vertical') !!}
            </div>
        </div>
    </div>
</div>  
@endif
@if(!$image_tools->isEmpty())
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-9 col-12">
            <div class="text-center mb-4" style="color: #1C4980;">
                <h4>Image Operation Tools</h4>
                <p>This is One of the greatest Image Tools for your Business</p>
            </div>
            <div class="row">
                {!! show_ads('image_horizontal') !!}
                @foreach($image_tools as $tool)
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <a class="card text-decoration-none cursor-pointer item-box" href="{{url($tool->link)}}">
                            <div class="card-body align-items-center d-flex justify-content-center">
                                <div class="d-flex align-items-center">
                                    <img class="avatar rounded-0 lazyload" src="{{ asset($tool->image)}}">
                                    <div class="name ps-3">
                                        <div class="font-weight-medium tool-name">{{ $tool->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                {!! show_ads('image_horizontal_end') !!}
            </div>
        </div>
        <div class="col-lg-3">
            <div id="rightside-bar">
                {!! show_ads('image_vertical') !!}
            </div>
        </div>
    </div>
</div>  
@endif
@if(!$developer_tools->isEmpty())
<div class="main-content bg-aliceblue mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-9 col-12">
            <div class="text-center mb-4" style="color: #1C4980;">
                <h4>Developer Tools</h4>
                <p>This is One of the greatest Developer Tools for your Business</p>
            </div>
            <div class="row">
                {!! show_ads('developer_horizontal') !!}
                @foreach($developer_tools as $tool)
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <a class="card text-decoration-none cursor-pointer item-box" href="{{url($tool->link)}}">
                            <div class="card-body align-items-center d-flex justify-content-center">
                                <div class="d-flex align-items-center">
                                    <img class="avatar rounded-0 lazyload" src="{{ asset($tool->image)}}">
                                    <div class="name ps-3">
                                        <div class="font-weight-medium tool-name">{{ $tool->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                {!! show_ads('developer_horizontal_end') !!}
            </div>
        </div>
        <div class="col-lg-3">
            <div id="rightside-bar">
                {!! show_ads('developer_vertical') !!}
            </div>
        </div>
    </div>
</div> 
@endif
@if(!$another_tools->isEmpty())
<div class="main-content bg-aliceblue mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-9 col-12">
            <div class="text-center mb-4" style="color: #1C4980;">
                <h4>Another Helpful Tools</h4>
                <p>This is One of the greatest Developer Tools for your Business</p>
            </div>
            <div class="row">
                {!! show_ads('developer_horizontal') !!}
                @foreach($another_tools as $tool)
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <a class="card text-decoration-none cursor-pointer item-box" href="{{url($tool->link)}}">
                            <div class="card-body align-items-center d-flex justify-content-center">
                                <div class="d-flex align-items-center">
                                    <img class="avatar rounded-0 lazyload" src="{{ asset($tool->image)}}">
                                    <div class="name ps-3">
                                        <div class="font-weight-medium tool-name">{{ $tool->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                {!! show_ads('developer_horizontal_end') !!}
            </div>
        </div>
        <div class="col-lg-3">
            <div id="rightside-bar">
                {!! show_ads('developer_vertical') !!}
            </div>
        </div>
    </div>
</div> 
@endif
@endsection