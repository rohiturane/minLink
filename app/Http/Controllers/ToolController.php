<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::get();

        $section = [
            '1' => 'Youtube section',
            '2' => 'SEO Section',
            '3' => 'Image Section',
            '4' => 'Developer Section'
        ];

        return view('admin.tools.index', compact('tools','section'));
    }

    public function create()
    {
        return view('admin.tools.create');
    }

    public function store(Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'name' => 'required',
            'image' => 'required',
            'section' => 'required',
            'link' => 'required',
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $path = NULL;
        if(!empty($request->file('image')))
        {
            $imageName = time().'.'.$request->image->extension();
            $path = '/img/'.$imageName;
            dd($path);
            $request->image->move(public_path('img'), $imageName);
        }

        Tool::create([
            'name' => $input_array['name'],
            'link' => $input_array['link'],
            'section' => $input_array['section'],
            'status' => $input_array['status'],
            'image' => $path,
        ]);

        session()->flash('status','success');
        session()->flash('message','Tool saved successfully');
        return redirect('/admin/tools');
    }

    public function edit($id)
    {
        $tool = Tool::find($id);

        return view('admin.tools.create', compact('tool'));
    }

    public function update($id, Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'name' => 'required',
            'image' => 'required',
            'section' => 'required',
            'link' => 'required',
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $tool = Tool::find($id);

        if(!empty($request->file('image')))
        {
            $ad_image = empty($tool->image) ? '' : $tool->image;
            if(File::exists(public_path($ad_image))) {
                File::delete(public_path($ad_image));
            } 
            $imageName = time().'.'.$request->image->extension();
            $path = '/img/'.$imageName;
            
            $request->image->move(public_path('img'), $imageName);
            $tool->image = $path;
        }

        $tool->name = $input_array['name'];
        $tool->section = $input_array['section'];
        $tool->link = $input_array['link'];
        $tool->status = $input_array['status'];
        $tool->save();

        session()->flash('status','success');
        session()->flash('message','Tool updated successfully');
        return redirect('/admin/tools');
    }

    public function delete($id)
    {
        $tool = Tool::find($id);

        if($tool)
        {
            session()->flash('status','error');
            session()->flash('message','Cannot find any tools');
            return redirect('/tools');
        }

        $tool->delete();

        session()->flash('status','success');
        session()->flash('message','Tool deleted successfully');

        return redirect('/admin/tools');
    }

}
