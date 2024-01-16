@extends('admin.layouts.app')
@section('admin_content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Permissions</h5>
            <form action="{{url('/permissions/store')}}" method="post">
                @csrf
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td class="fw-bold">Permission</td>
                            @foreach($roles as $role)
                            <td class="fw-bold">{{ucwords($role->name)}}</td>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td>{{ ucwords(str_replace("_", " ", $permission->name)) }}</td>
                            @foreach($roles as $role)
                            @php
                                $currentValue = $role->permissions->filter(function($role_permission) use($permission){
                                    return $role_permission->name == $permission->name;
                                })->first();
                            @endphp
                            <td><input type="checkbox" class="form-check-input" name="{{$permission->name.'_'.$role->name}}" {{ empty($currentValue) ? '' : 'checked' }} /></td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary"> {{'Save'}}</button>
            </form>
        </div>
    </div>
</div>
@endsection