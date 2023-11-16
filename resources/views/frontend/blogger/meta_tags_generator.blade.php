@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Meta Tags Generator'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Site Title (Characters left: 60)</label>
                        <input type="text" name="title" class="form-control" value="{{empty($_GET['title']) ? '' : $_GET['title']}}">
                    </div>
                    <div class="col-md-6">
                        <label for="lang" class="form-label">Site Description (Characters left: 150)</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="lang" class="form-label">Site Keywords (Separate with commas)</label>
                        <textarea name="keywords" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="lang" class="form-label">Allow robots to index your website?</label>
                        <select name="robots" id="robots" class="form-select">
                            <option value="index">Yes</option>
                            <option value="noindex">No</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="lang" class="form-label">Allow robots to follow all links?</label>
                        <select name="robots_links" id="robots_links" class="form-select">
                            <option value="follow">Yes</option>
                            <option value="nofollow">No</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="lang" class="form-label">What type of content will your site display?</label>
                        <select name="content_type" id="content_type" class="form-select">
                            <option value="text/html; charset=utf-8">UTF-8</option>
                            <option value="text/html; charset=utf-16">UTF-16</option>
                            <option value="text/html; charset=iso-8859-1">ISO-8859-1</option>
                            <option value="text/html; charset=windows-1252">WINDOWS-1252</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="lang" class="form-label">What is your site's primary language?</label>
                        <select name="language" id="language" class="form-select">
                            <option value="">No Language Tag</option>
                            <option value="English">English</option>
                            <option value="French">French</option>
                            <option value="Spanish">Spanish</option>
                            <option value="Russian">Russian</option>
                            <option value="Arabic">Arabic</option>
                            <option value="Japanese">Japanese</option>
                            <option value="Korean">Korean</option>
                            <option value="Hindi">Hindi</option>
                            <option value="Portuguese">Portuguese</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="lang" class="form-label">Search engines should revisit this page after</label>
                        <select name="revisit_days" id="revisit_days" class="form-select">
                            <option value="">Select Days</option>
                            <option value="1 day">1 day</option>
                            <option value="2 days">2 days</option>
                            <option value="3 days">3 days</option>
                            <option value="4 days">4 days</option>
                            <option value="5 days">5 days</option>
                            <option value="6 days">6 days</option>
                            <option value="7 days">7 days</option>
                            <option value="8 days">8 days</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="">Author</label>
                        <input type="text" name="author" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Generate</button>
                </div>
            </form>

            @if(!empty($data))
            <div class="mt-3">
                <div class="mt-3 mb-3">
                    <textarea class="form-control" rows="5" id="meta_tags">{{$data}}</textarea>
                </div>
                <button type="button" class="btn btn-sm bg-success text-white rounded-5 px-sm-3" onclick="copyToClipboard('meta_tags')">Copy to Clipboard</button>
                <button type="button" class="btn btn-sm bg-danger text-white rounded-5 px-sm-3" onclick="resetForm()">Reset</button>
            </div>
            @endif
            <div class="related_tools">
                {!! related_tools('2') !!}
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
@endsection
