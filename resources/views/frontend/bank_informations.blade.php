@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Get Bank Information'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Bank Name</label>
                        <select class="form-select" name="bank" id="bank">
                            @foreach($data['banks'] as $bank)
                                <option value="{{$bank}}">{{$bank}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">State</label>
                        <select class="form-select" name="state" id="state">
                            @foreach($data['states'] as $state)
                                <option value="{{$state}}">{{$state}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">District</label>
                        <select class="form-select" name="district" id="district">
                            @foreach($data['districts'] as $district)
                                <option value="{{$district}}">{{$district}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Branch</label>
                        <select class="form-select" name="branch" id="branch">
                            @foreach($data['branches'] as $branch)
                                <option value="{{$branch}}">{{$branch}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Search</button>
                </div>
            </form>

            @if(!empty($dataArray))
            <div class="m-4">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                            <th scope="col">Key</th>
                            <th scope="col">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Bank</td>
                                <td>{{ $data['bank']}}</td>
                            </tr>
                            <tr>
                                <td>IFSC Details</td>
                                <td>{{ $data['ifsc']}}</td>
                            </tr>
                            <tr>
                                <td>Branch</td>
                                <td>{{ $data['branch']}}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{ $data['address']}}</td>
                            </tr>
                            <tr>
                                <td>District</td>
                                <td>{{ $data['district']}}</td>
                            </tr>
                            <tr>
                                <td>State</td>
                                <td>{{ $data['state']}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <div class="related_tools">
                {!! related_tools('1','Youtube Channel Logo Downloader') !!}
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