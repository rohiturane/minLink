<?php

namespace App\Http\Controllers;

use App\Models\PageInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscription;
use App\Models\Setting;
use Melbahja\Seo\Sitemap;
use Melbahja\Seo\Ping;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $page_meta = [];
        $page_info = fetch_meta_information('home-page');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        return view('frontend.home',compact('page_info','page_meta'));
    }

    public function addSubscription(Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'email' => 'required'
        ]);

        if($validate->fails())
        {
            return response()->json(['status' => false, 'error' => $validate->getMessageBag()]);
        }

        $subscription = Subscription::create([
            'email' => $input_array['email'],
            'name' => empty($input_array['name']) ? '' : $input_array['name'],
        ]);

        return response()->json(['status'=>true, 'message'=> 'Thank you for subscription our newsletters.']);
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function setting()
    {
        $settings = Setting::get();
        return view('admin.setting', compact('settings'));
    }

    public function settingStore(Request $request)
    {
        $input_array = $request->expect('_token');

        foreach($input_array as $key => $value)
        {
            Setting::updateOrCreate(['key' => $key], ['value'=> $value]);
        }

        session()->flash('status','success');
        session()->flash('message', 'Setting updated successfully');

        return redirect('/setting');
    }

    public function pageMeta()
    {
        $metas = PageInformation::get();
        return view('admin.meta_informations.index', compact('metas'));
    }

    public function pageCreate()
    {
        return view('admin.meta_informations.create');
    }

    public function pageSave(Request $request)
    {
        $input_array = $request->all();
        
        $validate = Validator::make($input_array,[
            'page_slug' => 'required',
            'html_content' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $page = PageInformation::create($input_array);

        session()->flash('status', 'success');
        session()->flash('message', 'Page Information store successfully');

        return redirect('/page_informations');
    }

    public function pageEdit($id)
    {
        $page = PageInformation::find($id);

        return view('admin.meta_informations.create', compact('page'));
    }

    public function pageUpdate($id, Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array,[
            'page_slug' => 'required',
            'html_content' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required'
        ]);

        $page = PageInformation::find($id);
        
        if(empty($page))
        {
            session()->flash('status', 'error');
            session()->flash('message', 'Cannot find the page');
            return back();
        }
        
        $page->update($input_array);

        session()->flash('status', 'success');
        session()->flash('message', 'Page Information update successfully');

        return redirect('/page_informations');
    }

    public function pageDelete($id)
    {
        $page = PageInformation::find($id);

        if(!$page)
        {
            session()->flash('status','error');
            session()->flash('message','Page not found');
            return redirect('/page_informations');
        }

        $page->delete();

        session()->flash('status','success');
        session()->flash('message','Page Information deleted Successfully');
        return redirect('/page_informations');
    }

    public function generateSiteMap()
    {
        try{
            $sitemap = new Sitemap(url('/'), ['save_path' => public_path('/')]);
            $routes = app('router')->getRoutes();
            $expectRoute = ['sanctum','_ignition','api','auth','admin'];
        
            $res = collect($routes)->map(function ($item) use($expectRoute) {
                foreach($expectRoute as $substring)
                if(strpos($item->uri, $substring) !== FALSE) return 1;
                return $item->uri;
            });
    
            $array_list = array_slice(array_values(array_unique($res->toArray())),2);

            $blogs = Post::where('status','1')->get();
            $sitemap->links('blog.xml', function($map) use ($blogs)
            {
                $map->loc('/blog')->freq('daily')->priority('0.8');
                foreach($blogs as $blog)
                {
                    $map->loc('/blog/'.$blog->slug)->freq('weekly')->lastMod($blog->updated_at)->image(asset('/blog/'.$blog->featured_image), ['caption' => $blog->title]);
                }
            });
            $sitemap->links('page.xml', function($map) use ($array_list)
            {
                $map->loc('/')->freq('daily')->priority('0.8');
                foreach ( $array_list as $key => $route )
                {
                    $map->loc($route)->freq('weekly')->priority('0.8');
                }
            });
            // return bool
            // throws SitemapException if save_path options not exists
            $sitemap->save();
            
            $ping = new Ping;
            $ping->send(url('/').'/sitemap.xml');
            return back();
        } 
        catch(\Exception $e)
        {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return;
        }   
    }

    public function optimizeApplication()
    {
        $exitCode = \Artisan::call('optimize:clear');
        session()->flash('status','success');
        session()->flash('message', 'Application Optimized');
        return back();
    }
}
