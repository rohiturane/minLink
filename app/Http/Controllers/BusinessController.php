<?php

namespace App\Http\Controllers;

use App\Services\BusinessService;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    protected $service;
    protected $invoice;

    public function __construct(BusinessService $service, InvoiceService $invoice)
    {
        $this->service = $service;
        $this->invoice = $invoice;
    }

    public function index()
    {
        $businesses = $this->service->index();

        return view('admin.businesses.index', compact('businesses'));
    }

    public function create()
    {
        $invoices = $this->invoice->getDropdownList();
        return view('admin.businesses.create', compact('invoices'));
    }

    public function store(Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'note' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $path = '';
        if(!empty($request->file('logo')))
        {
            $imageName = time().'.'.$request->logo->extension();
            $path = '/business/'.$imageName;
            $input_array['logo'] = $path;
            $request->logo->move(public_path('business'), $imageName);
        }

        $business = $this->service->store($input_array);

        session()->flash('status','success');
        session()->flash('message', 'Business saved Successfully');

        return redirect('/businesses');
    }

    public function edit($uuid)
    {
        $business = $this->service->get($uuid);
        $invoices = $this->invoice->getDropdownList();
        return view('admin.businesses.create', compact('invoices','business'));
    }

    public function update($uuid, Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'note' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $path = '';
        if(!empty($request->file('logo')))
        {
            $imageName = time().'.'.$request->logo->extension();
            $path = '/business/'.$imageName;
            $input_array['logo'] = $path;
            $request->logo->move(public_path('business'), $imageName);
        }

        $business = $this->service->update($uuid, $input_array);

        session()->flash('status','success');
        session()->flash('message', 'Business updated Successfully');

        return redirect('/businesses');
    }

    public function destory($uuid)
    {
        $business = $this->service->destory($uuid);
        
        session()->flash('status','success');
        session()->flash('message', 'Business updated Successfully');
        return redirect('/businesses');
    }
}
