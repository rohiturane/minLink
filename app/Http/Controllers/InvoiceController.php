<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    protected $service;

    public function __construct(InvoiceService $service)
    {
        $this->service = $service;    
    }

    public function index()
    {
        $invoices = $this->service->index();

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('admin.invoices.create');
    }

    public function store(Request $request)
    {
        $input_array = $request->all();
        
        $validate = Validator::make($input_array,[
            'title' => 'required',
            'html_content' => 'required',
            'status' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $invoice = $this->service->save($input_array);

        session()->flash('status','success');
        session()->flash('message', 'Invoice saved Successfully');

        return redirect('/invoices');
    }

    public function edit($uuid)
    {
        $invoice = $this->service->get($uuid);

        return view('admin.invoices.create', compact('invoice'));
    }

    public function update($uuid, Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array,[
            'title' => 'required',
            'html_content' => 'required',
            'status' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $invoice = $this->service->update($uuid, $input_array);

        session()->flash('status','success');
        session()->flash('message', 'Invoice updated Successfully');

        return redirect('/invoices');
    }

    public function destory($uuid)
    {
        $invoice = $this->service->destory($uuid);
        session()->flash('status','success');
        session()->flash('message', 'Invoice deleted Successfully');

        return redirect('/invoices');
    }
}
