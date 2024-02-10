<?php

namespace App\Http\Controllers;

use App\Models\PageInformation;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscription;
use App\Models\Setting;
use Melbahja\Seo\Sitemap;
use Melbahja\Seo\Ping;
use App\Models\Post;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    public function __construct()
    {
    }

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
        $input_array = $request->all();
        unset($input_array['_token']);
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
            $expectRoute = ['sanctum','_ignition','api','auth','admin', 'post'];
        
            $res = collect($routes)->map(function ($item) use($expectRoute) {
                foreach($expectRoute as $substring)
                if(strpos($item->uri, $substring) !== FALSE) return 1;
                return $item->uri;
            });
    
            $array_list = array_slice(array_values(array_unique($res->toArray())),2);

            $blogs = Post::where('status','1')->get();
            $sitemap->links(['name' => 'blog.xml', 'images' => true], function($map) use ($blogs)
            {
                $map->loc('/posts')->freq('daily')->priority('0.8');
                foreach($blogs as $blog)
                {
                    $map->loc('/post/'.$blog->slug)->freq('weekly')->lastMod($blog->updated_at)->image(asset($blog->featured_image), ['caption' => $blog->title]);
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
            session()->flash('status','success');
            session()->flash('message', 'Sitemap generated successfully');
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

    public function privacyPolicy()
    {
        $page_meta = [];
        $page_info = fetch_meta_information('privacy-policy');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        return view('frontend.privacy-policy', compact('page_meta','page_info'));
    }

    public function termsService()
    {
        $page_meta = [];
        $page_info = fetch_meta_information('terms-of-service');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        return view('frontend.terms-of-service', compact('page_meta','page_info'));
    }

    public function contactUs(Request $request)
    {
        $page_meta = [];
        $page_info = fetch_meta_information('contact-us');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        return view('frontend.contact-us', compact('page_meta','page_info'));
    }

    public function permissions()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::get();
        return view('admin.permissions',compact('roles','permissions'));
    }

    public function storePermissions(Request $request)
    {
        $input_array = $request->all();
        // dd($input_array);
        foreach($input_array as $key => $field) {
            
            if (strpos($key, '_admin') !== false && $field == 'on') {
                $permission = str_replace("_admin", "",$key);
                $check = Permission::where('name', $permission)->first();
                if($check) {
                    $role = Role::where('name','admin')->first();
                    $role->givePermissionTo($permission);
                }
            }
            if (strpos($key, '_user') !== false && $field == 'on') {
                $permission = str_replace("_user", "",$key);
                $check = Permission::where('name', $permission)->first();
                if($check) {
                    $role = Role::where('name','user')->first();
                    $role->givePermissionTo($permission);
                }
            }
        }        

        session()->flash('status','success');
        session()->flash('message', 'Permission assigned to respective Role Successfully');

        return redirect('/permissions');
    }
}
