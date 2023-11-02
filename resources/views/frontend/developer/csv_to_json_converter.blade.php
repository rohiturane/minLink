@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'CSV To JSON Converter'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form method="post" enctype="multipart/form-data">
                {{ @csrf_field()}}
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Select CSV</label>
                        <input type="file" required name="image" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="form-control text-field">
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">CSV keys</label>
                        <select name="type" id="type" class="form-select">
                            <option value="1">Don't use Keys</option>
                            <option value="2">Use First Row as Keys</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Extract</button>
                    
                    
                </div>
            </form>

            @if(!empty($data))
            <div class="mt-3">
                <div class="mt-3 mb-3">
                    <label for="lang" class="form-label">Resulted JSON</label>
                    <textarea class="form-control" rows="10" id="json_result">{{$data}}</textarea>
                </div>
                <button type="button" class="btn btn-sm bg-success text-white rounded-5 px-sm-3" onclick="copyToClipboard('json_result')">Copy to Clipboard</button>
                <button type="button" class="btn btn-sm bg-danger text-white rounded-5 px-sm-3" onclick="resetForm()">Reset</button>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
