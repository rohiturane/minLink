@extends('admin.layouts.app')
@section('admin_content')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Transactions</h5>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        @if(!$transactions->isEmpty())
                        <table id="example" class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">id</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Transaction No.</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Amount</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Created By</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Action</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $key => $transaction)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $transaction->uuid }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-1 text-wrap">{{ $transaction->transaction_no }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-1 text-wrap">{{ $transaction->amount }}</p>
                                    </td>
                                    
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 fs-4">{{date('d-M-Y H:i:s', strtotime($transaction->created_at))}}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        @can('edit_transaction')
                                        <a target="_blank" href="{{ url('/admin/transaction/'.$transaction->uuid.'/view')}}"><span>
                                            <i class="ti ti-printer"></i>
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