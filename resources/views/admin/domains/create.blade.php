@extends('admin.layouts.app')
@section('admin_content')

<link rel="stylesheet" href="{{asset('/css/select2.min.css')}}">
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">{{ empty($domain) ? 'Create Domain': 'Update Domain'}}</h5>
                @if(empty($domain))
                <form action="{{url('/admin/domain/store')}}" method="domain" enctype="multipart/form-data">
                @else
                <form action="{{url('/admin/domain/'.$domain->uuid.'/update')}}" method="domain" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="mb-3">
                        <label for="domain" class="form-label">Domain</label>
                        <input type="text" class="form-control" id="domain" value="{{ empty($domain) ? '' : $domain->domain }}" name="domain" aria-describedby="emailHelp">
                        @if($errors->has('domain'))
                            <span class="text-danger">{{ $errors->first('domain');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="redirect" class="form-label">Redirect</label>
                        <input type="text" class="form-control" id="redirect" value="{{ empty($domain) ? '' : $domain->redirect }}" name="redirect" aria-describedby="emailHelp">
                        @if($errors->has('redirect'))
                            <span class="text-danger">{{ $errors->first('redirect');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1" @php if(!empty($domain)) { if($domain->status == 1){ echo 'selected'; } } @endphp>Active</option>
                            <option value="2" @php if(!empty($domain)) { if($domain->status == 2){ echo 'selected'; } } @endphp>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"> {{ empty($domain) ? 'Save' : 'Update'}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom-scripts')
<script src="{{ asset('/js/select2.min.js')}}"></script>
<script src="{{ asset('/js/ckeditor.js')}}"></script>
<script>
    $("#category").select2({
        tags: true,
        tokenSeparators: [',', ' ']
    })
    $("#tags").select2({
        tags: true,
        tokenSeparators: [',', ' ']
    })
    ClassicEditor.create(document.getElementById('editor'))
    .then( editor => {
        editor.ui.view.editable.element.style.height = '400px';
    }  )
    .catch( error => {
            console.error( error );
    } );
</script>
@endpush