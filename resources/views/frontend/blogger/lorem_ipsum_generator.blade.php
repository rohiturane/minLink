@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Lorem Ipsum Generator'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="lang" class="form-label">Count</label>
                        <input type="text" name="count" class="form-control" id="count" value="{{empty($_GET['count']) ? '' : $_GET['count']}}">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="lang" class="form-label">Type</label>
                        <select name="type" id="type" class="form-select">
                            <option value="paragraphs" {{empty($_GET['type']) ? '' : ($_GET['type']=='paragraphs' ? 'selected': '')}}>Paragraphs</option>
                            <option value="sentences" {{empty($_GET['type']) ? '' : ($_GET['type']=='sentences' ? 'selected': '')}}>Sentence</option>
                            <option value="words" {{empty($_GET['type']) ? '' : ($_GET['type']=='words' ? 'selected': '')}}>Words</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Generate</button>
                </div>
            </form>
            @if(!empty($data))
            <div class="mt-3">
                <div class="mt-3 mb-3">
                    <div class="col-md-12">
                        <p class="bolder">Generated Text</p>
                        <textarea class="form-control" rows="10" id="meta_tags">{{ implode(PHP_EOL, $data) }}</textarea>
                    </div>
                    
                </div>
                <button type="button" class="btn btn-sm bg-success text-white rounded-5 px-sm-3" onclick="copyToClipboard('meta_tags')">Copy Code to Clipboard</button>
                <button type="button" class="btn btn-sm bg-danger text-white rounded-5 px-sm-3" onclick="resetForm()">Reset</button>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
