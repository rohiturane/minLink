@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Youtube Channel Search'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                    <label for="query" class="form-label">Enter Channel Name</label>
                    <input type="text" required name="query" value="{{ empty($_GET['query']) ? '' : $_GET['query']}}" class="form-control text-field">
                    </div>
                    <div class="col-md-12">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-select text-field" name="country" id="country" required="">
                        @foreach($countries as $key => $country)
                            <option value="{{$key}}" @if(!empty($_GET['country']) && $key == $_GET['country']) selected @endif>{{$country}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid country.
                    </div>
                    </div>
                    <div class="col-md-12">
                    <label for="result" class="form-label">No. of Result</label>
                    <input type="text" required name="result" value="{{ empty($_GET['result']) ? '' : $_GET['result']}}" class="form-control text-field">
                    </div>
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Generate</button>
                </div>
            </form>

            @if(!empty($dataArray))
            <div class="m-4">
                <h2>Results</h2>
                <div class="row">
                    @foreach($dataArray as $data)
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <div class="card text-decoration-none cursor-pointer item-box" href="www.youtub.com/channel/{{$data['channelId']}}">
                            <div class="card-body align-items-center d-flex justify-content-center" style="padding: 0;">
                                <div class="d-flex align-items-center">
                                    <img class="avatar rounded-0 lazyloaded"src="{{$data['thumbnail']}}" style="width: 100px;" alt="{{$data['channelTitle']}}">
                                    <div class="name ps-3">
                                        <a class="font-weight-medium" href="www.youtub.com/channel/{{$data['channelId']}}">{{$data['channelTitle']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            <div class="related_tools">
                {!! related_tools('1','Youtube Channel Search') !!}
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
