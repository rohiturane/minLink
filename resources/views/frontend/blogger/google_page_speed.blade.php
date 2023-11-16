@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Google PageSpeed Checker'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                    <label for="lang" class="form-label">Enter Website URL</label>
                    <input type="text" required name="link" value="{{empty($_GET['link']) ? '' : $_GET['link']}}" class="form-control text-field">
                    </div>
                    
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Check</button>
                </div>
            </form>

            @if(!empty($data))
            <div class="mt-3">
                <p>Below are the Title which are associated with Youtube Video.</p>
                <div class="mt-3 mb-3">
                    <span class="badge rounded-pill text-bg-secondary">{{$dataArray}}</span>
                    <input type="hidden" id="video_tags" value="{{$dataArray}}">
                </div>
                <button type="button" class="btn btn-sm bg-success text-white rounded-5 px-sm-3" onclick="copyToClipboard('video_tags')">Copy to Clipboard</button>
                <button type="button" class="btn btn-sm bg-danger text-white rounded-5 px-sm-3" onclick="resetForm()">Reset</button>
            </div>
            @endif
            <div class="related_tools">
                {!! related_tools('2') !!}
            </div>
        </div>
        <div class="col-lg-3 col-12">
          {!! show_ads('seo_vertical') !!}
        </div>
    </div>
</div>
<div class="row px-5 py-4">
    <div class="page-information">
      {!! empty($page_info['html_content']) ? '' : $page_info['html_content'] !!}
    </div>
</div>
@endsection
