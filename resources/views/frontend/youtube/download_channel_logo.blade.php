@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Youtube Channel Logo Downloader'])
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
                <ul class="nav nav-pills" id="myTab">
                    @foreach($dataArray as $key => $logo)
                    <li class="nav-item">
                        <a href="#home{{$key}}" class="nav-link @if($key == 0) active @endif">{{$logo['resolution']}}</a>
                    </li>
                    @endforeach
                    
                </ul>
                <div class="tab-content">
                    @foreach($dataArray as $key => $logo)
                    <div class="tab-pane fade @if($key == 0) show active @endif " id="home{{$key}}">
                        <div class="m-3">
                            <a class="btn btn-success" href="{{$logo['download']}}">Download</a>
                            <img src="{{$logo['preview']}}" alt="" class="img-fluid mt-3">
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
            @endif
            <div class="related_tools">
                {!! related_tools('1') !!}
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
<script>
$(document).ready(function(){
    $("#myTab a").click(function(e){
        e.preventDefault();
        $(this).tab("show");
    });
});
</script>
@endsection