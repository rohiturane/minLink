@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'JSON Validator'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form method="post" enctype="multipart/form-data">
                {{ @csrf_field()}}
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Enter your JSON Data</label>
                        <textarea class="form-control" name="json_data" rows="8"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Convert</button>
                    
                </div>
            </form>
            @if(!empty($flag))
                @if(!empty($data))
                <div class="mt-3">
                    <div class="mt-3 mb-3">
                        <h2>{{'JSON is Valid'}}</h2>
                    </div>
                </div>
                @else 
                <div class="mt-3">
                    <div class="mt-3 mb-3">
                        <h2>{{'JSON is Not Valid'}}</h2>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

@endsection
