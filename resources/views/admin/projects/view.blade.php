@extends('admin.layouts.app')
@section('admin_content')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">{{ $project->name }} Project's Details @can('add_license')<button class="btn btn-sm btn-primary m-1" data-bs-toggle="modal" data-bs-target="#exampleModal">Generate License</a>@endcan</h5>
                <div class="card-body p-4">
                    <div class="m-3">
                        <h6 class="fw-bolder">Project ID: </h6>
                        <p>{{ $project->uuid }} &nbsp;
                            <input type="hidden" id="project_id" value="{{ $project->uuid }}">
                            <span type="button" onclick="copyToClipboardProject()" class="btn btn-light">
                            <i class="ti ti-file-invoice"></i>
                        </span></p>
                    </div>
                    <div class="table-responsive">
                        @if(!$project->license->isEmpty())
                        <table id="example" class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Sr.No.</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Host</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Access Code</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Action</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($project->license as $key => $license)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ ++$key }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $license->host }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-1 text-wrap">{{ $license->access_code }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex align-items-center gap-2">
                                            @if($license->status==1)
                                            <span class="badge bg-danger rounded-3 fw-semibold">Used</span>
                                            @else 
                                            <span class="badge bg-primary rounded-3 fw-semibold">Not Used</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border-bottom-0">
                                        <span type="button" onclick="copyToClipboardText('{{ $license->access_code }}')" class="btn btn-light btn-sm text-primary">
                                            <i class="ti ti-file-invoice"></i>
                                        </span>&nbsp;
                                        @can('send_email')
                                        <button onclick="sendEmail('{{$license->uuid}}')" class="btn btn-light btn-sm text-primary"><span>
                                            <i class="ti ti-send"></i>
                                            </span>
                                        </button>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else 
                        <div>
                            <div class="alert alert-info" role="alert">
                               <p>No Record Found!!</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Create a License</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form action="{{ url('/license/store')}}" method="post">
            <input type="hidden" name="project_id" value="{{$project->id}}">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Host</label>
                    <input type="text" class="form-control" name="host" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <span class="text-danger" id="host_error"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
  </div>
</div>
<div class="modal fade" id="sendModal" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="sendModalLabel">Send Email To User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <input type="hidden" id="license_id">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" id="email" aria-describedby="emailHelp">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="sendEmail" class="btn btn-primary">Send</button>
        </div>
    </div>
  </div>
</div>
@endsection
@push('custom-scripts')
<script src="{{ asset('/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/js/dataTables.bootstrap5.min.js')}}"></script>
<script>
    $(function(){
        new DataTable('#example');
    });
    function copyToClipboardProject() {
            // Get the text field
            var copyText = document.getElementById("project_id");
            copyText.type = 'text';
            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);
            copyText.type = 'hidden';
            // Alert the copied text
            //alert("Copied the text: " + copyText.value);
            generateToast("text-bg-primary", "Text Copied");
    }
    function copyToClipboardText(val)
    {
        // Copy the text inside the text field
        navigator.clipboard.writeText(val);
        
        // Alert the copied text
        generateToast("text-bg-primary", "Text Copied");
    }
    function sendEmail(uuid){
        $(document).find('#license_id').val(uuid);
        $('#sendModal').modal('show');
    }
    $('#sendEmail').click(function(){
        let email = $('#email').val();
        let license = $('#license_id').val();
        $.ajax({
            url: '/send/mail',
            method: 'post',
            data:{
                email: email,
                license: license,
                '_token': "{{ csrf_token() }}",
            },
            success: function(response){
                $('#sendModal').modal('hide');
                if(response.status) {
                    generateToast("text-bg-primary", response.message);
                } else {
                    generateToast("text-bg-danger", "Something went wrong! try again.");
                }
            }
        })
    });
</script>
@endpush