@extends('admin.layouts.app')
@section('admin_content')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Page Information @can('add_page_information')<a class="btn btn-sm btn-primary m-1" href="{{ url('/page_information/create')}}">Add New</a>@endcan</h5>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        @if(!$metas->isEmpty())
                        <table id="example" class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Id</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Page Slug</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Meta Title</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Action</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($metas as $key => $meta)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ ++$key }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-1">{{ $meta->page_slug }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal text-wrap">{{ $meta->meta_title }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        @can('edit_page_information')
                                        <a href="{{ url('/page_information/'.$meta->id.'/edit')}}"><span>
                                            <i class="ti ti-pencil"></i>
                                            </span></a>
                                            @endcan
                                        @can('delete_page_information')
                                        <a href="{{ url('/page_information/'.$meta->id.'/delete')}}"><span>
                                            <i class="ti ti-trash"></i>
                                            </span></a>
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