@extends('admin.layouts.app')
@section('admin_content')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Profile</h5>
                <form action="{{url('/admin/profile/store')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" aria-describedby="emailHelp">
                        @if($errors->has('name'))
                            <span class="text-danger ">{{ $errors->first('name');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email </label>
                        <input type="text" class="form-control" readonly name="email"  value="{{ auth()->user()->email }}" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Client ID</label>
                        <span type="button" onclick="copyToClipboard()" class="btn btn-light">
                            <i class="ti ti-file-invoice"></i>
                        </span>
                        <input type="text" class="form-control " readonly id="client_id" name="client_id"  value="{{ auth()->user()->client_id }}" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">New Password </label>
                        <input type="password" class="form-control" id="new_password" name="new_password" aria-describedby="emailHelp">
                        @if($errors->has('new_password'))
                            <span class="text-danger ">{{ $errors->first('new_password');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Re-type New Password </label>
                        <input type="password" class="form-control" id="retype_password" name="retype_password" >
                        @if($errors->has('retype_password'))
                            <span class="text-danger ">{{ $errors->first('retype_password');}}</span>
                        @endif
                    </div>            
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function copyToClipboard() {
    // Get the text field
    var copyText = document.getElementById("client_id");

    // Select the text field
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices

    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText.value);

    // Alert the copied text
    //alert("Copied the text: " + copyText.value);
    generateToast("text-bg-primary", "Text Copied");
    }
</script>
@endsection