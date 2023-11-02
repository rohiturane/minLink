@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'CSS Minify'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form method="post" enctype="multipart/form-data">
                {{ @csrf_field()}}
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Enter your CSS page</label>
                        <textarea class="form-control" name="content" rows="8">{{empty($content)? '': $content}}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Minify</button>
                </div>
            </form>
            @if(!empty($data))
            <div class="mt-3">
                <div class="mt-3 mb-3">
                    <label for="lang" class="form-label">Minified CSS</label>
                    <textarea class="form-control" rows="10" id="css_result">{{$data}}</textarea>
                </div>
                <button type="button" class="btn btn-sm bg-success text-white rounded-5 px-sm-3" onclick="copyToClipboard('css_result')">Copy to Clipboard</button>
                <button type="button" class="btn btn-sm bg-danger text-white rounded-5 px-sm-3" onclick="resetForm()">Reset</button>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
