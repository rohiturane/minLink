@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Password Generator'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Password Length</label>
                        <input type="text" name="password_length" class="form-control" value="{{ empty($_GET['password_length']) ? '': $_GET['password_length']}}">
                    </div>
                    <div class="col-md-4">
                        <input class="form-check-input" type="checkbox" name="include_number" value="1" {{ empty($_GET['include_number']) ? '': 'checked'}} id="include_number">
                        <label class="form-check-label" for="include_number">
                            Include Numbers
                        </label>
                    </div>
                    <div class="col-md-4">
                        <input class="form-check-input" type="checkbox" name="include_symbol" value="1" {{ empty($_GET['include_symbol']) ? '': 'checked'}} id="include_symbol">
                        <label class="form-check-label" for="include_symbol">
                            Include Symbol
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Generate</button>
                </div>
            </form>

            @if(!empty($randomString))
            <div class="mt-3">
                <div class="mt-3 mb-3">
                    <textarea class="form-control" rows="5" id="password_text">{{$randomString}}</textarea>
                </div>
                <button type="button" class="btn btn-sm bg-success text-white rounded-5 px-sm-3" onclick="copyToClipboard('password_text')">Copy to Clipboard</button>
                <button type="button" class="btn btn-sm bg-danger text-white rounded-5 px-sm-3" onclick="resetForm()">Reset</button>
            </div>
            @endif
            <div class="related_tools">
                {!! related_tools('4') !!}
            </div>
        </div>
        <div class="col-lg-3 col-12">
          {!! show_ads('developer_vertical') !!}
        </div>
    </div>
</div>
<div class="row px-5 py-4">
    <div class="page-information">
      {!! empty($page_info['html_content']) ? '' : $page_info['html_content'] !!}
    </div>
</div>
@endsection
