@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Youtube Embed Code Generator'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                    <label for="lang" class="form-label">Enter Youtube Video URL</label>
                    <input type="text" required name="link" value="{{empty($_GET['link']) ? '' : $_GET['link']}}" class="form-control text-field">
                    </div>

                    <div class="row mt-3">
                        <label for="size">Size</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{empty($_GET['size_width']) ? '560' : $_GET['size_width']}}" name="size_width" id="size_width">
                        </div>
                        <div class="col-md-6"> 
                            <input type="text" class="form-control" value="{{empty($_GET['size_height']) ? '315' : $_GET['size_height']}}" name="size_height" id="size_height">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <label for="size">Start Time(Leave blank if you do not want to specify)</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{empty($_GET['start_min']) ? '' : $_GET['start_min']}}" name="start_min" id="start_min">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{empty($_GET['start_sec']) ? '' : $_GET['start_sec']}}" name="start_sec" id="start_sec">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <label for="size">End Time(Leave blank if you do not want to specify)</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{empty($_GET['end_min']) ? '' : $_GET['end_min']}}" name="end_min" id="end_min">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{empty($_GET['end_sec']) ? '' : $_GET['end_sec']}}" name="end_sec" id="end_sec">
                        </div>
                    </div>
                    <div class="badge bg-primary text-wrap" style="width: 5rem;">Options:</div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="loop_video" value="1" id="loop_video">
                        <label class="form-check-label" for="loop_video">
                            Loop video
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="auto_play_video" value="1" id="auto_play_video">
                        <label class="form-check-label" for="auto_play_video">
                            Auto play video
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="hide_full_screen_button" value="1" id="hide_full_screen_button">
                        <label class="form-check-label" for="hide_full_screen_button">
                            Hide Full-screen button
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="hide_player_controls" value="1" id="hide_player_controls">
                        <label class="form-check-label" for="hide_player_controls">
                            Hide Player Controls
                        </label>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="hide_youtube_logo" value="1" id="hide_youtube_logo">
                        <label class="form-check-label" for="hide_youtube_logo">
                            Hide Youtube Logo
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="no_cookie" value="" id="no_cookie">
                        <label class="form-check-label" for="no_cookie">
                            Privacy enhanced (only cookie when user starts video)
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="responsive" value="" id="responsive">
                        <label class="form-check-label" for="responsive">
                            Responsive (auto scale to available width)
                        </label>
                    </div>

                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Generate</button>
                </div>
            </form>

            @if(!empty($data))
            <div class="mt-3">
                <p>Below are the tags which are associated with Youtube Video.</p>
                <div class="mt-3 mb-3">
                    <textarea class="form-control" id="video_description" rows="5">{{$data}}</textarea>
                </div>
                <button type="button" class="btn btn-sm bg-success text-white rounded-5 px-sm-3" onclick="copyToClipboard('video_description')">Copy to Clipboard</button>&nbsp;&nbsp;
                <button type="button" class="btn btn-sm bg-danger text-white rounded-5 px-sm-3" onclick="resetForm()">Reset</button>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
