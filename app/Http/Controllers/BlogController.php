<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::get();

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::pluck('name');
        $tags = Tag::pluck('name');
        return view('admin.posts.create',compact('categories','tags'));
    }

    public function store(Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array,[
            'title'=> 'required',
            'html' => 'required',
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $path = '';
        if(!empty($request->file('featured_image')))
        {
            $imageName = time().'.'.$request->featured_image->extension();
            $path = '/blog/'.$imageName;
            
            $request->featured_image->move(public_path('blog'), $imageName);
        }
        foreach($input_array['category'] as $category) {
            $existCategory = Category::where('name','like',$category)->first();
            if(!$existCategory) {
                Category::create([
                    'name' => $category
                ]);
            }
        }

        foreach($input_array['tags'] as $tag) {
            $existTag = Tag::where('name','like',$tag)->first();
            if(!$existTag) {
                Tag::create([
                    'name' => $tag
                ]);
            }
        }

        $post = Post::create([
            'title' => $input_array['title'],
            'status' => $input_array['status'],
            'category' => implode(',', $input_array['category']),
            'html' => $input_array['html'],
            'tags' => implode(',', $input_array['tags']),
            'featured_image' => $path,
            'meta_title' => $input_array['meta_title'],
            'meta_description' => $input_array['meta_description'],
            'author_id' => auth()->user()->id,
        ]);

        session()->flash('status','success');
        session()->flash('message', 'Post saved Successfully');

        return redirect('/admin/posts');
    }

    public function edit($id)
    {
        $categories = Category::pluck('name');
        $tags = Tag::pluck('name');
        $post = Post::find($id);
        if(!$post) {
            session()->flash('status','error');
            session()->flash('message','Post not found!');
            return redirect()->back();
        }
        return view('admin.posts.create',compact('categories','tags','post'));
    }

    public function update($id, Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array,[
            'title' => 'required',
            'html' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $post = Post::find($id);

        if(!empty($request->file('featured_image')))
        {
            $imageName = time().'.'.$request->featured_image->extension();
            $path = '/blog/'.$imageName;
            
            $request->featured_image->move(public_path('blog'), $imageName);
            $post->featured_image = $path;
        }

        foreach($input_array['category'] as $category) {
            $existCategory = Category::where('name','like',$category)->first();
            if(!$existCategory) {
                Category::create([
                    'name' => $category
                ]);
            }
        }

        foreach($input_array['tags'] as $tag) {
            $existTag = Tag::where('name','like',$tag)->first();
            if(!$existTag) {
                Tag::create([
                    'name' => $tag
                ]);
            }
        }

        $post->title = $input_array['title'];
        $post->status = $input_array['status'];
        $post->category = implode(',', $input_array['category']);
        $post->tags = implode(',', $input_array['tags']);
        $post->html = $input_array['html'];
        $post->meta_title = $input_array['meta_title'];
        $post->meta_description = $input_array['meta_description'];
        $post->save();

        session()->flash('status','success');
        session()->flash('message', 'Post updated Successfully');

        return redirect('/admin/posts');
    }

    public function delete($id)
    {
        $post = Post::find($id);

        if(!$post) {
            session()->flash('status','success');
            session()->flash('message', 'Something went Wrong!! try again');

            return redirect('/admin/posts');
        }
        $post->delete();

        session()->flash('status','success');
        session()->flash('message', 'Post Deleted Successfully');

        return redirect('/admin/posts');
    }

    public function frontendBlogList(Request $request)
    {
        $page_meta = [];
        $page_info = fetch_meta_information('blog-page');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        $posts = Post::where('status',1)->orderBy('id','desc')->simplePaginate(9);
        return view('frontend.blog', compact('posts','page_info','page_meta'));
    } 

    public function postDetails($slug)
    {
        $post = Post::where('slug', 'like', $slug)->first();

        $page_meta = generate_meta_information($post);

        return view('frontend.blog_details',compact('post','page_meta'));
    }
}
