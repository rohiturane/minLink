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
                                    <img class="avatar rounded-0 lazyloaded" src="{{ asset($tool->image)}}">
                                    <div class="name ps-3">
                                        <div class="font-weight-medium tool-name">{{ $tool->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/youtube-trends')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/trending (1).png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Trends</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/youtube-extract-tags')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                            <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/price-tag (1).png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Tags Extractor</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/youtube-generate-tags')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                            <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/tag (1).png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Tags Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/youtube-extract-hashtag')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/hashtag.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Hashtag Extractor</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/youtube-generate-hashtag')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/hashtag.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Hashtag Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/youtube-extract-title')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/title.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Video Title Extractor</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/youtube-generate-video-title')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{asset('img/title.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Video Title Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/youtube-extract-description')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/job-seeking.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Video Description Extractor</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/youtube-embed-video')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/code.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Embed Code Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/youtube-channel-id')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/television.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Channel ID</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/youtube-video-statistics')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/video-player.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Video Statistics</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/youtube-channel-statistics')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                            <img class="avatar rounded-0 lazyload" src="{{ asset('img/video-player.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Channel Statistics</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/youtube-money-calculator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/calculator.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Money Calculator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/youtube-logo-download')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/file (1).png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Channel Logo Downloader</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ urL('/youtube-banner-download')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/file (1).png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Channel Banner Downloader</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/youtube-channel-search')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/search.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">YouTube Channel Search</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
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
                                    <img class="avatar rounded-0 lazyloaded" src="{{ asset($tool->image)}}">
                                    <div class="name ps-3">
                                        <div class="font-weight-medium tool-name">{{ $tool->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                <!-- <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/google-page-speed')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/rush.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Google PageSpeed Checker</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> -->
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/lorem-ipsum-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                            <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/headline.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Lorem Ipsum Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/google-index-checker')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/diagram.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Google Index Checker</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/google-cache-checker')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/cache.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Google Cache Checker</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/domain-age-checker')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/anti-age.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Domain Age Checker</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/terms-of-service-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{asset('img/document.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Terms Of Service Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/privacy-policy-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/document.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Privacy Policy Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/domain-lookup')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/job-seeking.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Whois Domain Lookup</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/keyword-density-checker')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/keyword.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Keyword Density Checker</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/robot-txt-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/robot.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Robots.txt Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/meta-tag-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                            <img class="avatar rounded-0 lazyload" src="{{ asset('img/meta.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Meta tag Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/meta-tag-checker')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/meta (1).png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Meta Tag Checker</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/open-graph-checker')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/diagram.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Open Graph Checker</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ urL('/open-graph-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/diagram.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Open Graph Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/keyword-suggestion')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/sem.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Keywords Suggestion Tool</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/adsence-calculator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/adsense.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Adsense Calculator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/gzip-enabled-checker')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/arrows.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">GZIP Compression Checker</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
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
                                    <img class="avatar rounded-0 lazyloaded" src="{{ asset($tool->image)}}">
                                    <div class="name ps-3">
                                        <div class="font-weight-medium tool-name">{{ $tool->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/jpg-to-png-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/png-file.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">JPG to PNG Converter</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/jpg-to-webp-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                            <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/webp.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">JPG to WEBP Converter</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/png-to-jpg-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                            <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/jpg-file.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">PNG To JPG Converter</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/png-to-webp-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/webp.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">PNG to WEBP Converter</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/webp-to-jpg-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/jpg-file.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">WEBP to JPG Converter</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/webp-to-png-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/png-file.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">WEBP to PNG Converter</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/jpg-to-psd-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{asset('img/title.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">JPG to PSD Converter</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/png-to-psd-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{asset('img/title.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">PNG to PSD Converter</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> -->
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/image-compressor')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/file compress.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Image Compressor</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/image-resizer')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/resolution.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Image Resizer</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/image-to-base64')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/upc-searching.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Image to Base64</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
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
                                    <img class="avatar rounded-0 lazyloaded" src="{{ asset($tool->image)}}">
                                    <div class="name ps-3">
                                        <div class="font-weight-medium tool-name">{{ $tool->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/csv-to-json-converter')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/json-file.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">CSV to JSON Converter</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/json-to-csv-converter')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                            <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/csv.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">JSON to CSV Converter</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/json-beautifier')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/beautify.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">JSON Beautifier</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/json-validator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/validation.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">JSON Validator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/html-minifier')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/minimize.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">HTML Minifier</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/css-minifier')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{asset('img/minimize.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">CSS Minifier</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{url('/js-minifier')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyloaded" src="{{ asset('img/minimize.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">JS Minifier</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/password-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 ls-is-cached lazyloaded" src="{{ asset('img/reset-password.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Password Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/md5-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/md5.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">MD5 Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/sha-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/sha-256.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">SHA Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/bcrypt-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                            <img class="avatar rounded-0 lazyload" src="{{ asset('img/padlock.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Bcrypt Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a class="card text-decoration-none cursor-pointer item-box" href="{{ url('/hash-generator')}}">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-0 lazyload" src="{{ asset('img/hashtag.png')}}">
                                <div class="name ps-3">
                                    <div class="font-weight-medium tool-name">Hash Generator</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
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