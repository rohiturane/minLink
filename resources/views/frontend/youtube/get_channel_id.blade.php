@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Youtube Channel ID'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Enter Youtube Channel URL</label>
                        <input type="text" required name="link" value="{{empty($_GET['link']) ? '' : $_GET['link']}}" class="form-control text-field">
                    </div>
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Find Now</button>
                </div>
            </form>

            @if(!empty($data))
            <div class="mt-3">
                <p>Below are the Youtube Channel</p>
                <div class="mt-3 mb-3">
                    Channel ID: <span class="badge rounded-pill text-bg-success">{{$data}}</span>
                </div>
                <!-- <button type="button" onclick="copyToClipboard()">Copy to Clipboard</button>
                <button type="button" onclick="resetForm()">Reset</button> -->
            </div>
            @endif
            <div class="related_tools">
                {!! related_tools('1', 'Youtube Channel ID') !!}
            </div>
        </div>
        <div class="col-lg-3 col-12">
          {!! show_ads('youtube_vertical') !!}
        </div>
    </div>
</div>
<div class="row px-5 py-4">
    <div class="page-information">
      {!! empty($page_info['html_content']) ? '' : $page_info['html_content'] !!}
    </div>
</div>
@endsection
