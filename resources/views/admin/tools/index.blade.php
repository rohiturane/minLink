@extends('admin.layouts.app')
@section('admin_content')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Tools <a class="btn btn-sm btn-primary m-1" href="{{ url('/admin/tool/create')}}">Add New</a></h5>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        @if(!$tools->isEmpty())
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Id</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Name</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Section</h6>
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
                                @foreach($tools as $key => $tool)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ ++$key }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-1">{{ $tool->name }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $section[$tool->section] }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex align-items-center gap-2">
                                            @if($tool->status==1)
                                            <span class="badge bg-primary rounded-3 fw-semibold">Active</span>
                                            @else 
                                            <span class="badge bg-danger rounded-3 fw-semibold">InActive</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border-bottom-0">
                                        <a href="{{ url('/admin/tool/'.$tool->id.'/edit')}}"><span>
                                            <i class="ti ti-pencil"></i>
                                            </span></a>
                                        <a href="{{ url('/admin/tool/'.$tool->id.'/delete')}}"><span>
                                            <i class="ti ti-trash"></i>
                                            </span></a>
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