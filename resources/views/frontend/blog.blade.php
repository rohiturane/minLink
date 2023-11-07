@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Latest Posts'])
<style>
    .card {
        height: 440px;
    }
</style>
<main class="my-5">
    <div class="container">
        <!--Section: Content-->
        <section class="text-center">
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card">
                            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                <img src="{{ $post->featured_image }}" class="img-fluid" />
                                
                                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                </a>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><a class="text-decoration-none" href="{{ url('/post/'.$post->slug )}}">{{ $post->title }}</a></h4>
                                <p class="card-text">
                                    {{ short_description($post->html, 20) }}
                                </p>
                                <a href="{{ url('/post/'.$post->slug )}}" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                
            </div>
        </section>
        <!--Section: Content-->
        <!-- Pagination -->
        <div class="d-flex">
            {!! $posts->links() !!}
        </div>
    </div>
</main>
@endsection