@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Youtube Channel Statistics'])
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
            <div class="mt-3">
                <p>Below are list of statistics of channel</p>
                <div class="mt-3 mb-3">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Channel ID</td>
                                <td>{{$dataArray['channelId']}}</td>
                            </tr>
                            <tr>
                                <td>Channel Title</td>
                                <td>{{$dataArray['channelTitle']}}</td>
                            </tr>
                            <tr>
                                <td>Thumbnail</td>
                                <td><img src="{{$dataArray['thumbnail']}}"  class="img-thumbnail"/></td>
                            </tr>
                            <tr>
                                <td>Published at</td>
                                <td>{{$dataArray['publishedAt']}}</td>
                            </tr>
                            <tr>
                                <td>Total Views</td>
                                <td>{{$dataArray['viewCount']}}</td>
                            </tr>
                            <tr>
                                <td>Total Subscribers</td>
                                <td>{{$dataArray['subscriberCount']}}</td>
                            </tr>
                            <tr>
                                <td>Total Videos</td>
                                <td>{{$dataArray['videoCount']}}</td>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td>{{$dataArray['country']}}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>{{$dataArray['description']}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <button type="button" onclick="copyToClipboard()">Copy to Clipboard</button>
                <button type="button" onclick="resetForm()">Reset</button> -->
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
