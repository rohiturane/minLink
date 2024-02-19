@extends('admin.layouts.app')
@section('admin_content')
@php
//dd(find_object($settings, 'custom_footer')->isEmpty() );
@endphp
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Setting</h5>
                <form action="{{url('/setting/store')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Google RECAPTCHA SITE KEY </label>
                        <input type="text" class="form-control" id="google_capatch_site_key" name="google_capatch_site_key" value="{{ empty($settings) ? '' : (find_object($settings, 'google_capatch_site_key')->isEmpty() ? '' :find_object($settings, 'google_capatch_site_key')->first()->value) }}" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Google RECAPTCHA SECRET KEY </label>
                        <input type="text" class="form-control" id="google_capatch_secret_key" name="google_capatch_secret_key"  value="{{ empty($settings) ? '' : (find_object($settings, 'google_capatch_secret_key')->isEmpty() ? '' :find_object($settings, 'google_capatch_secret_key')->first()->value) }}" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Google API KEY </label>
                        <input type="text" class="form-control" id="google_api_key" name="google_api_key"  value="{{ empty($settings) ? '' : (find_object($settings, 'google_api_key')->isEmpty() ? '' :find_object($settings, 'google_api_key')->first()->value) }}" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Add Custom Code on Header</label>
                        <textarea class="form-control" rows="4" id="custom_header" name="custom_header" >{{ empty($settings) ? '' : (find_object($settings, 'custom_footer')->isEmpty() ? '' : find_object($settings, 'custom_header')->first()->value)}}</textarea>
                    </div>            
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Add Custom Code on Footer</label>
                        <textarea class="form-control" rows="4" id="custom_footer" name="custom_footer" >{{ empty($settings) ? '' : (find_object($settings, 'custom_footer')->isEmpty() ? '' : find_object($settings, 'custom_footer')->first()->value) }}</textarea>
                    </div>            
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection