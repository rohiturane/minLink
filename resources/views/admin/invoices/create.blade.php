@extends('admin.layouts.app')
@section('admin_content')
<link rel="stylesheet" href="{{asset('/css/grapes.min.css')}}">
<style>
    .gjs-one-bg {
        background-color: #7c7a7a; 
    }
</style>
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="p-3">
                <h5 class="card-title fw-semibold mb-4">{{ empty($invoice) ? 'Create Invoice': 'Update Invoice'}}</h5>
                @if(empty($invoice))
                <form action="{{url('/invoice/store')}}" method="post" id="invoiceForm" enctype="multipart/form-data">
                @else
                <form action="{{url('/invoice/'.$invoice->uuid.'/update')}}" id="invoiceForm" method="post" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" value="{{ empty($invoice) ? '' : $invoice->title }}" name="title" aria-describedby="emailHelp">
                        @if($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title');}}</span>
                        @endif
                    </div>
                    <input type="hidden" name="html_content" id="html_content" value="{{ empty($invoice) ? '' : $invoice->html_content }}" >              
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">HTML Content</label><br/>
                        <span class="fw-bold">Use the following variable <br/>{logo}, {business_name}, {address}, {mobile}, {email}, {note}, {total_in_words}, {customer_name}, {customer_mobile}, {customer_email}, {customer_taxid}, {taxid}, {products}, {invoice_id}, {date}, {rates}, {qtys}, {product_totals}, {subtotal}, {subtax}, {final_total}</span>
                        <div id="gjs"></div>
                        @if($errors->has('html_content'))
                            <span class="text-danger">{{ $errors->first('html_content');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="0" @php if(!empty($invoice)) { if($invoice->status == 0){ echo 'selected'; } } @endphp>Draft</option>
                            <option value="1" @php if(!empty($invoice)) { if($invoice->status == 1){ echo 'selected'; } } @endphp>Published</option>
                            <option value="2" @php if(!empty($invoice)) { if($invoice->status == 2){ echo 'selected'; } } @endphp>Inactive</option>
                        </select>
                    </div>
                    <button type="button" id="btnSubmit" class="btn btn-primary"> {{ empty($invoice) ? 'Save' : 'Update'}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom-scripts')
<script src="{{ asset('/js/grapes.min.js')}}"></script>
<script src="{{ asset('/js/basic.js')}}"></script>
<script src="{{ asset('/js/preset-webpage.js')}}"></script>
<script>
    $(document).ready(function(){
        var editor = grapesjs.init({
            container : '#gjs',
            storageManager: false,
            plugins: ["gjs-blocks-basic",'grapesjs-preset-webpage'],
            components: $('#html_content').val(),
        });
        $("#btnSubmit").click(function(){
            // Let's find the input to check
            var input = $("#html_content");
            var Html = editor.getHtml();
            var Css = editor.getCss();
            input.val('<html><head><style>'+Css+'</style></head><body>'+Html+'</body></html>');
            // editor.runCommand('canvas-clear');
            $('#invoiceForm').submit();
        });
    });
    
</script>
@endpush