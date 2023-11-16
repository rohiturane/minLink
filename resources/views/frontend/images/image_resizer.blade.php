@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Image resizer'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form method="post" enctype="multipart/form-data">
                {{ @csrf_field()}}
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Select image</label>
                        <input type="file" required name="image" accept="image/jpeg,image/jpg" class="form-control text-field">
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Width (px)</label>
                        <input type="text" class="form-control text-field" name="width">
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Height (px)</label>
                        <input type="text" class="form-control text-field" name="height">
                    </div>
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Resize</button>
                    
                    <button type="reset" class="btn btn-sm bg-danger col-3 text-white rounded-5 px-sm-3">Reset</button>
                </div>
            </form>
            <div class="related_tools">
                {!! related_tools('3') !!}
            </div>
        </div>
        <div class="col-lg-3 col-12">
          {!! show_ads('image_vertical') !!}
        </div>
    </div>
</div>
<div class="row px-5 py-4">
    <div class="page-information">
      {!! empty($page_info['html_content']) ? '' : $page_info['html_content'] !!}
    </div>
</div>
@endsection
