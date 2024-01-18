@extends('admin.layouts.app')
@section('admin_content')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">{{ empty($business) ? 'Create Business': 'Update Business'}}</h5>
                @if(empty($business))
                <form action="{{url('/business/store')}}" method="post" id="invoiceForm" enctype="multipart/form-data">
                @else
                <form action="{{url('/business/'.$business->uuid.'/update')}}" id="invoiceForm" method="post" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ empty($business) ? '' : $business->name }}" name="name" aria-describedby="emailHelp">
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" aria-describedby="emailHelp">
                        @if($errors->has('logo'))
                            <span class="text-danger">{{ $errors->first('logo');}}</span>
                        @endif
                        @if(!empty($business->logo))
                            <img src="{{asset($business->logo)}}" style="width: 120px;">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" rows="4" class="form-control">{{empty($business) ? '' : $business->address}}</textarea>
                        @if($errors->has('address'))
                            <span class="text-danger">{{ $errors->first('address');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="{{ empty($business) ? '' : $business->email }}" name="email" aria-describedby="emailHelp">
                        @if($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input type="text" class="form-control" id="mobile" value="{{ empty($business) ? '' : $business->mobile }}" name="mobile" aria-describedby="emailHelp">
                        @if($errors->has('mobile'))
                            <span class="text-danger">{{ $errors->first('mobile');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea name="note" id="note" rows="4" class="form-control">{{empty($business) ? '' : $business->note}}</textarea>
                        @if($errors->has('note'))
                            <span class="text-danger">{{ $errors->first('note');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="0" @php if(!empty($business)) { if($business->status == 0){ echo 'selected'; } } @endphp>Draft</option>
                            <option value="1" @php if(!empty($business)) { if($business->status == 1){ echo 'selected'; } } @endphp>Active</option>
                            <option value="2" @php if(!empty($business)) { if($business->status == 2){ echo 'selected'; } } @endphp>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"> {{ empty($business) ? 'Save' : 'Update'}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom-scripts')
<script>
       
</script>
@endpush