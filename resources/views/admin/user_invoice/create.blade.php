@extends('admin.layouts.app')
@section('admin_content')
<link rel="stylesheet" href="{{asset('/css/bootstrap-datepicker.min.css')}}">
<style>
    .subtotalarea {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }
</style>
@php
if(!empty($invoice)) {
    $payloads = json_decode($invoice->payload);
    
}
@endphp
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="p-3">
                <h5 class="card-title fw-semibold mb-4">{{ empty($invoice) ? 'Create Invoice': 'Update Invoice'}}</h5>
                @if(empty($invoice))
                <form action="{{url('/user/invoice/store')}}" method="post" id="invoiceForm" enctype="multipart/form-data">
                @else
                <form action="{{url('/user/invoice/'.$invoice->uuid.'/update')}}" id="invoiceForm" method="post" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="invoice_no" class="form-label">Invoice Number</label>
                            <input type="text" class="form-control" id="invoice_no" value="{{ empty($invoice) ? '' : $invoice->invoice_no }}" name="invoice_no" aria-describedby="emailHelp">
                            @if($errors->has('invoice_no'))
                                <span class="text-danger">{{ $errors->first('invoice_no');}}</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="invoice_no" class="form-label">Invoice Date</label>
                            <input type="text" class="form-control datepicker" id="date" value="{{ empty($invoice) ? '' : date('d-m-Y', strtotime($invoice->date)) }}" name="date" aria-describedby="emailHelp">
                            @if($errors->has('date'))
                                <span class="text-danger">{{ $errors->first('date');}}</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="customer_mobile" class="form-label">Customer Mobile</label>
                            <input type="text" class="form-control " id="customer_mobile" value="{{ empty($invoice) ? '' : $invoice->customer_mobile }}" name="customer_mobile" aria-describedby="emailHelp">
                            @if($errors->has('customer_mobile'))
                                <span class="text-danger">{{ $errors->first('customer_mobile');}}</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" value="{{ empty($invoice) ? '' : $invoice->customer_name }}" name="customer_name" aria-describedby="emailHelp">
                            @if($errors->has('customer_name'))
                                <span class="text-danger">{{ $errors->first('customer_name');}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <button id="add_row" type="button" class="btn btn-info">+</button>                
                        </div>
                    </div>
                    <input type="hidden" id="row_number" value="{{empty($invoice) ? 1: count($payloads->particular)}}">
                    <div class="table-responsive">
                        <table class="table" id="product_table">
                            <thead>
                                <tr>
                                    <th>Particulars</th>
                                    <th>Quantity</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($invoice))
                                    @foreach($payloads->particular as $key => $payload)
                                    <tr>
                                        <td><input type="text" name="particular[{{$key}}]" class="form-control" value="{{$payload}}"></td>
                                        <td><input type="text" name="qty[{{$key}}]" class="form-control qty" value="{{$payloads->qty[$key]}}"></td>
                                        <td><input type="text" name="rate[{{$key}}]" class="form-control rate" value="{{$payloads->rate[$key]}}"></td>
                                        <td><input type="text" name="total[{{$key}}]" class="form-control total" value="{{$payloads->total[$key]}}"></td>
                                    </tr>
                                    @endforeach
                                @else 
                                <tr>
                                    <td><input type="text" name="particular[0]" class="form-control"></td>
                                    <td><input type="text" name="qty[0]" class="form-control qty"></td>
                                    <td><input type="text" name="rate[0]" class="form-control rate"></td>
                                    <td><input type="text" name="total[0]" class="form-control total"></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8 subtotalarea">
                            <label for="invoice_no" class="form-label text-right">Sub Total</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="subtotal" id="subtotal" class="form-control" value="{{ empty($invoice) ? '' : $payloads->subtotal}}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8 subtotalarea">
                            <label for="invoice_no" class="form-label text-right">Sub Tax</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="subtax" id="subtax" class="form-control" value="{{ empty($invoice)? '' : $payloads->subtax}}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8 subtotalarea">
                            <label for="invoice_no" class="form-label text-right">Total Amount</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="final_total" id="final_total" class="form-control" value="{{ empty($invoice)? '': $payloads->final_total}}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Note:</label>
                        <textarea class="form-control" name="note" rows="3">{{ empty($invoice) ? '' : $payloads->note}}</textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="exampleInputEmail1" class="form-label">Status</label>    
                        </div>
                        <div class="col-md-6">
                            <select name="status" id="status" class="form-select">
                                <option value="0" @php if(!empty($invoice)) { if($invoice->status == 0){ echo 'selected'; } } @endphp>Draft</option>
                                <option value="1" @php if(!empty($invoice)) { if($invoice->status == 1){ echo 'selected'; } } @endphp>Paid</option>
                                <option value="2" @php if(!empty($invoice)) { if($invoice->status == 2){ echo 'selected'; } } @endphp>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary"> {{ empty($invoice) ? 'Save' : 'Update'}}</button>
                        <button type="button" onclick="window.history.go(-1); return false;" class="btn btn-secondary">Back</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom-scripts')
<script src="{{ asset('/js/bootstrap-datepicker.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
        });
    });
    $('#product_table tbody').on('keyup change', function() {
        calc();
    });
    function calc()
    {
        $('#product_table tbody tr').each(function(i, element) {
            var html = $(this).html();
            if(html != '')
            {
                var qty = $(this).find('.qty').val();
                var price = $(this).find('.rate').val();
                $(this).find('.total').val(qty * price);
                calc_total();
            }
        });
    }
    function calc_total()
    {
        var total = 0;
        tax_sum = 0;
        $('.total').each(function() {
            total += parseFloat($(this).val());
        });
        $('#subtotal').val(total.toFixed(2));
        $('#subtax').val();
        $('#final_total').val(Math.round(tax_sum + total).toFixed(2));
    }
    $('#add_row').click(function() {
        var s = $('#row_number').val();

        var pro = '<input type="text" class="form-control" name="particular['+s+']">';
        var row_html = $('<tr><td>' + pro +
            '</td><td><input type="number" class="form-control qty" min="1" value="1" autocomplete="off" name="qty[' +
            s +
            ']"></td><td><input type="text" class="form-control rate numberformat" autocomplete="off" name="rate[' +
            s +
            ']" value="0"></td><td><input type="text" class="form-control total numberformat" name="total[' +
            s +
            ']"><span class="taxable" style="color:red;font-size:small;" ></span><input type="hidden" class="post_tax" name="tax[' +
            s + ']"></td><td><a href="#" class="remove_row btn btn-danger" onclick="remove_row(' + s +
            ')">X</a></td></tr>');
        $('#row_number').val(++s);
        $('#product_table > tbody').append(row_html);
    });
    $('#product_table').on('click', '.remove_row', function() {
        $(this).closest('tr').remove();
        var s = $('#row_number').val();
        calc();
        $('#pointer').val(--s);
    });
</script>
@endpush