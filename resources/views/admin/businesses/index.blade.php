@extends('admin.layouts.app')
@section('admin_content')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Business @can('add_business')<a class="btn btn-sm btn-primary m-1" href="{{ url('/business/create')}}">Add New</a>@endcan</h5>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        @if(!$businesses->isEmpty())
                        <table id="example" class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Id</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Name</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Address</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Action</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($businesses as $key => $business)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ ++$key }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-1 text-wrap">{{ $business->name }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex align-items-center gap-2">
                                            @if($business->status == 1)
                                            <span class="badge bg-primary rounded-3 fw-semibold">Active</span>
                                            @elseif($business->status == 0)
                                            <span class="badge bg-info rounded-3 fw-semibold">Draft</span>
                                            @else
                                                <span class="badge bg-danger rounded-3 fw-semibold">InActive</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 fs-4">{{$business->address}}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        @can('edit_business')
                                        <a href="{{ url('/business/'.$business->uuid.'/edit')}}"><span>
                                            <i class="ti ti-pencil"></i>
                                            </span>
                                        </a>
                                        @endcan
                                        @can('delete_business')
                                        <a href="{{ url('/business/'.$business->uuid.'/delete')}}"><span>
                                            <i class="ti ti-trash"></i>
                                            </span>
                                        </a>
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
@endsection
@push('custom-scripts')
<script src="{{ asset('/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/js/dataTables.bootstrap5.min.js')}}"></script>
<script>
    $(function(){
        new DataTable('#example');
    });
</script>
@endpush