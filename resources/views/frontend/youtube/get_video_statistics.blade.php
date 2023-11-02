@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Youtube Video Statistics'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Enter Youtube Video URL</label>
                        <input type="text" required name="link" value="{{empty($_GET['link']) ? '' : $_GET['link']}}" class="form-control text-field">
                    </div>
                    
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Search</button>
                </div>
            </form>

            @if(!empty($dataArray))
            <div class="mt-3">
                <p>Below are list of statistics of video</p>
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
                                <td>Video Title</td>
                                <td>{{$dataArray['title']}}</td>
                            </tr>
                            <tr>
                                <td>Video Views</td>
                                <td>{{$dataArray['viewCount']}}</td>
                            </tr>
                            <tr>
                                <td>Video Likes</td>
                                <td>{{$dataArray['likeCount']}}</td>
                            </tr>
                            <tr>
                                <td>Video Comments</td>
                                <td>{{$dataArray['commentCount']}}</td>
                            </tr>
                            <tr>
                                <td>Published at</td>
                                <td>{{$dataArray['publishedAt']}}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>{{$dataArray['description']}}</td>
                            </tr>
                            <tr>
                                <td>Thumbnails</td>
                                <td>
                                    @foreach($dataArray['thumbnails'] as $thumb) 
                                        <span class="badge bg-gradient-secondary text-lowercase">
                                            <a class="text-white" target="_blank" href="https://i.ytimg.com/vi/2XGsq64Z-XA/mqdefault.jpg">medium (320x180)</a>
                                        </span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>Tags</td>
                                <td>
                                    @foreach($dataArray['tags'] as $tag)
                                        <span class="badge badge-success">{{$tag}}</span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td>{{$dataArray['channelId']}}</td>
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
