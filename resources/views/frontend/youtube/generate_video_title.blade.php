@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Youtube Video Title Generator'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Enter your keyword</label>
                        <input type="text" required name="keywords" value="{{ empty($_GET['keywords']) ? '' : $_GET['keywords']}}" class="form-control text-field">
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Country</label>
                        <select class="form-select text-field" name="country" id="country" required="">
                            @foreach($countries as $key => $country)
                                <option value="{{$key}}" @if(!empty($_GET['country']) && $key == $_GET['country']) selected @endif>{{$country}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid country.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Generate</button>
                </div>
            </form>

            @if(!empty($dataArray))
            <div class="mt-3">
                <p>Below are the generated title for above keywords</p>
                <div class="mt-3 mb-3">
                    @foreach($dataArray as $tag)
                        <span class="badge rounded-pill text-bg-secondary m-1">{{$tag}}</span>
                    @endforeach
                    <input type="hidden" id="video_tags" value="{{implode(',', $dataArray)}}">
                </div>
                <button type="button" class="btn btn-sm bg-success text-white rounded-5 px-sm-3" onclick="copyToClipboard('video_tags')">Copy to Clipboard</button>&nbsp;&nbsp;
                <button type="button" class="btn btn-sm bg-danger text-white rounded-5 px-sm-3" onclick="resetForm()">Reset</button>
            @endif
            <div class="related_tools">
                {!! related_tools('1', 'Youtube Video Title Generator') !!}
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
