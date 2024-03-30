@extends('admin.layouts.app')
@section('admin_content')
<?php 
//dd($role);

?>
<link rel="stylesheet" href="{{asset('/css/select2.min.css')}}">
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">{{ empty($user) ? 'Create User': 'Update User'}}</h5>
                @if(empty($user))
                <form action="{{url('/admin/user/store')}}" method="post" enctype="multipart/form-data">
                @else
                <form action="{{url('/admin/user/'.$user->id.'/update')}}" method="post" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ empty($user) ? '' : $user->name }}" name="name" aria-describedby="emailHelp">
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="{{ empty($user) ? '' : $user->email }}" name="email" aria-describedby="emailHelp">
                        @if($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" autocomplete="new-password" class="form-control" id="password" name="password" aria-describedby="passwordHelp">
                        @if($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select">
                            <option value="">Select a Role</option>
                            @foreach($role as $rol)
                                <option value="{{$rol->id}}" @php if(!empty($user)) { if($user->roles->pluck('id')->implode(',') == $rol->id){ echo 'selected'; } } @endphp>{{ $rol->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary"> {{ empty($user) ? 'Save' : 'Update'}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom-scripts')
<script src="{{ asset('/js/select2.min.js')}}"></script>
<script>
    
</script>
@endpush