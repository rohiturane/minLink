@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Domain Age Calculator'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                    <label for="lang" class="form-label">Enter URL</label>
                    <input type="text" required name="link" value="{{empty($_GET['link']) ? '' : $_GET['link']}}" class="form-control text-field">
                    </div>
                    
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Extract</button>
                </div>
            </form>

            @if(!empty($data))
            <div class="mt-3">
                <p>Below are the domain information.</p>
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
                                <td>Domain Name</td>
                                <td>{{$data['domain_name']}}</td>
                            </tr>
                            <tr>
                                <td>Age</td>
                                <td>{{$data['age']}}</td>
                            </tr>
                            <tr>
                                <td>Creation Date</td>
                                <td>{{$data['creation_date']}}</td>
                            </tr>
                            <tr>
                                <td>Updated Date</td>
                                <td>{{$data['updated_date']}}</td>
                            </tr>
                            <tr>
                                <td>Expiration Date</td>
                                <td>{{$data['expiration_date']}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection