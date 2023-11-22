@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Privacy Policy Generator'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="lang" class="form-label">Company Name</label>
                        <input type="text" name="company_name" class="form-control" value="{{empty($_GET['company_name']) ? '' : $_GET['company_name']}}">
                    </div>
                    <div class="col-md-6">
                        <label for="lang" class="form-label">Website Name</label>
                        <input type="text" name="site_name" class="form-control" value="{{empty($_GET['site_name']) ? '' : $_GET['site_name']}}">
                    </div>
                    <div class="col-md-6">
                        <label for="lang" class="form-label">Website URL</label>
                        <input type="text" name="site_url" class="form-control" value="{{empty($_GET['site_url']) ? '' : $_GET['site_url']}}">
                    </div>
                    <div class="col-md-6">
                        <label for="lang" class="form-label">Country</label>
                        <select name="country" id="country" class="form-select">
                            <option value="">Select a Country</option>
                            @foreach($countries as $conutry)
                            <option value="{{$conutry->id}}">{{$conutry->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="lang" class="form-label">State</label>
                        <select name="state" id="state" class="form-select"></select>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Your Email Address</label>
                        <input type="text" name="email" class="form-control" value="{{empty($_GET['email']) ? '' : $_GET['email']}}">
                    </div>
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Generate</button>
                </div>
            </form>

            @if(!empty($data))
            <div class="mt-3">
                <div class="row mt-3 mb-3">
                    <div class="col-md-6">
                        <p class="bolder">HTML Code</p>
                        <textarea class="form-control" rows="28" id="meta_tags">{{$data}}</textarea>
                    </div>
                    <div class="col-md-6" >
                        <p class="bolder">HTML Preview</p>
                        <div id="html_content" style="height: 700px; overflow-y:scroll">
                            {!! $data !!}
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm bg-success text-white rounded-5 px-sm-3" onclick="copyToClipboard('meta_tags')">Copy Code to Clipboard</button>
                <button type="button" class="btn btn-sm bg-danger text-white rounded-5 px-sm-3" onclick="resetForm()">Reset</button>
            </div>
            @endif
            <div class="related_tools">
                {!! related_tools('2', 'Privacy Policy Generator') !!}
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
<script>
    $('#country').change(function(){
        $.ajax({
            url: '/api/states?country_id='+$(this).val(),
            method: 'get',
            success:function(response) {
                $('#state').empty();
                $('#state').append($('<option>', {
                    value: '',
                    text: 'Select a State'
                }));
                $.each(response, function (i, item) {
                    $('#state').append($('<option>', { 
                        value: item.id,
                        text : item.name 
                    }));
                });
            }
        })
    });
</script>
@endsection
