@extends('frontend.layouts.app')
@section('content')
<style>
    .card {
        height: auto;
        pointer-events:none;
    }
</style>
<div style="height: 100px;"></div>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-12 card">
            <div class="">
                <h1>{{ $post->title }}</h1>
            </div>
            <div class="mb-3">
            <small class="text-body-secondary">Published on {{ date('F j, Y', strtotime($post->updated_at)) }} by {{ $post->user->name }}</small>
            </div>
            <img src="{{$post->featured_image}}" alt="{{$post->title}}" class="img-fluid">
            <div class="post-content mt-4">
                {!! $post->html !!}
            </div>
        </div>
        <div class="col-lg-3 col-md-12 card ml-2" style="margin-left: 30px;">
            {!! show_ads('youtube_vertical') !!}
        </div>
    </div>
</div>
@endsection