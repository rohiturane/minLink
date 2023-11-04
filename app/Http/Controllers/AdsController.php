<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdsController extends Controller
{
    public function index()
    {
        $ads = Ads::get();

        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
        return view('admin.ads.create');
    }

    public function store(Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'ads_slug' => 'required',
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }
        $path = NULL;
        if(!empty($request->file('image')))
        {
            $imageName = time().'.'.$request->image->extension();
            $path = '/advertises/'.$imageName;
            
            $request->image->move(public_path('advertises'), $imageName);
        }
        Ads::create([
            'ads_slug' => $input_array['ads_slug'],
            'image' => $path,
            'external_html' => empty($input_array['external_html']) ? NULL : $input_array['external_html'],
            'status' => $input_array['status']
        ]);

        session()->flash('status','success');
        session()->flash('message','Ads Created Successfully');

        return redirect('/admin/advertise');
    }

    public function edit($id)
    {
        $ad = Ads::find($id);
        
        return view('admin.ads.create', compact('ad'));
    }

    public function update(Request $request, $id)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array,[
            'ads_slug' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }
        
        $ads = Ads::find($id);
        $path = '';
        if($request->file('image'))
        {
            $ad_image = empty($ads->image) ? '' : $ads->image;
            if(File::exists(public_path($ad_image))) {
                File::delete(public_path($ad_image));
            } 
            $imageName = time().'.'.$request->image->extension();
            $path = '/advertises/'.$imageName;
            
            $request->image->move(public_path('advertises'), $imageName);
            $ads->image = $path;
        }
        
        $ads->ads_slug = $input_array['ads_slug'];
        $ads->external_html = empty($input_array['external_html']) ? NULL: $input_array['external_html'];
        $ads->status = $input_array['status'];
        $ads->save();

        session()->flash('status','success');
        session()->flash('message','Ads Updated Successfully');

        return redirect('/admin/advertise');
    }

    public function delete($id)
    {
        $ads = Ads::find($id);

        $ads->delete();

        session()->flash('status','message');
        session()->flash('message','Ads Deleted Successfully');

        return redirect('/admin/advertise');
    }
}
