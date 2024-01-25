<?php

namespace App\Http\Controllers;

use App\Services\UserInvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserInvoiceController extends Controller
{
    protected $service;

    public function __construct(UserInvoiceService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $userinvoices = $this->service->index();

        return view('admin.user_invoice.index', compact('userinvoices'));
    }

    public function create()
    {
        return view('admin.user_invoice.create');
    }

    public function store(Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'customer_name' => 'required',
            'customer_mobile' => 'required',
            'invoice_no' => 'required',
            'date' => 'required',
            // 'invoice_id' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $invoice = $this->service->store($input_array);

        session()->flash('status','success');
        session()->flash('message', 'Invoice created Successfully');

        return redirect('/user/invoice');
    }

    public function edit($uuid)
    {
        $invoice = $this->service->get($uuid);

        return view('admin.user_invoice.create', compact('invoice'));
    }

    public function update($uuid, Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'customer_name' => 'required',
            'customer_mobile' => 'required',
            'invoice_no' => 'required',
            'date' => 'required',
            // 'invoice_id' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $invoice = $this->service->update($uuid, $input_array);

        session()->flash('status','success');
        session()->flash('message', 'Invoice updated Successfully');

        return redirect('/user/invoice');
    }

    public function destory($uuid)
    {
        $invoice = $this->service->destory($uuid);
        
        session()->flash('status','success');
        session()->flash('message', 'Invoice deleted Successfully');
        return redirect('/user/invoice');
    }
}
