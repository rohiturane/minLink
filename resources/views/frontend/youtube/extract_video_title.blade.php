@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Youtube Video Title Extractor'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                    <label for="lang" class="form-label">Enter Youtube Video URL</label>
                    <input type="text" required name="link" value="{{empty($_GET['link']) ? '' : $_GET['link']}}" class="form-control text-field">
                    </div>
                    
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Extract</button>
                </div>
            </form>

            @if(!empty($dataArray))
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
        </div>
    </div>
</div>

@endsection
