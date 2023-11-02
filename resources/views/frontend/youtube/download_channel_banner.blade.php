@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Youtube Channel Banner Downloader'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Enter Youtube Channel URL</label>
                        <input type="text" required name="link" value="{{empty($_GET['link']) ? '' : $_GET['link']}}" class="form-control text-field">
                    </div>

                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Search</button>
                </div>
            </form>

            @if(!empty($dataArray))
            <div class="m-4">
                <div class="mt-3 mb-3">
                    <div class="m-3">
                        <a href="{{$dataArray['download']}}" class="btn btn-sm bg-success col-3 text-white rounded-5 px-sm-3">Download</a>
                        <img src="{{$dataArray['preview']}}" class="img-thumbnail mt-3">
                    </div>
                </div>
                
            </div>
            @endif
        </div>
    </div>
</div>

@endsection