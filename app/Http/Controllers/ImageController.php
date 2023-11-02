<?php

namespace App\Http\Controllers;

use Google\Service\Datastream\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;

class ImageController extends Controller
{
    public function jpgToPngGenerator(Request $request)
    {
        $input_array = $request->all();

        $page_meta = [];
        $page_info = fetch_meta_information('jpg-to-png-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'image' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $image = $request->file('image');
            $fileName = time() . '.png';
            
            $image = Image::make($image->getRealPath())->encode('png');

            $headers = [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'attachment; filename='. $fileName,
            ];

            return response()->stream(function() use ($image) {
                echo $image;
            }, 200, $headers);
        }
        return view('frontend.images.jpg_to_png_generator', compact('page_info','page_meta'));
    }

    public function jpgToWebpGenerator(Request $request)
    {
        $input_array = $request->all();

        $page_meta = [];
        $page_info = fetch_meta_information('jpg-to-webp-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'image' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $image = $request->file('image');
            $fileName = time() . '.webp';
            
            $image = Image::make($image->getRealPath())->encode('webp');

            $headers = [
                'Content-Type' => 'image/webp',
                'Content-Disposition' => 'attachment; filename='. $fileName,
            ];

            return response()->stream(function() use ($image) {
                echo $image;
            }, 200, $headers);
        }

        return view('frontend.images.jpg_to_webp_generator', compact('page_info','page_meta'));
    }

    public function pngToJpgGenerator(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('png-to-jpg-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'image' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $image = $request->file('image');
            $fileName = time() . '.jpg';
            
            $image = Image::make($image->getRealPath())->encode('jpg');

            $headers = [
                'Content-Type' => 'image/jpg',
                'Content-Disposition' => 'attachment; filename='. $fileName,
            ];

            return response()->stream(function() use ($image) {
                echo $image;
            }, 200, $headers);
        }

        return view('frontend.images.png_to_jpg_generator', compact('page_info','page_meta'));
    }

    public function pngToWebpGenerator(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('png-to-webp-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'image' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $image = $request->file('image');
            $fileName = time() . '.webp';
            
            $image = Image::make($image->getRealPath())->encode('webp');

            $headers = [
                'Content-Type' => 'image/webp',
                'Content-Disposition' => 'attachment; filename='. $fileName,
            ];

            return response()->stream(function() use ($image) {
                echo $image;
            }, 200, $headers);
        }

        return view('frontend.images.png_to_webp_generator', compact('page_info','page_meta'));
    }

    public function webpToJpgGenerator(Request $request)
    {
        $input_array = $request->all();

        $page_meta = [];
        $page_info = fetch_meta_information('webp-to-jpg-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'image' => 'required',
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $image = $request->file('image');
            $fileName = time() . '.jpg';
            
            $image = Image::make($image->getRealPath())->encode('jpg');

            $headers = [
                'Content-Type' => 'image/jpg',
                'Content-Disposition' => 'attachment; filename='. $fileName,
            ];

            return response()->stream(function() use ($image) {
                echo $image;
            }, 200, $headers);
        }

        return view('frontend.images.webp_to_jpg_generator', compact('page_info','page_meta'));
    }

    public function webpToPngGenerator(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('webp-to-png-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'image' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $image = $request->file('image');
            $fileName = time() . '.png';
            
            $image = Image::make($image->getRealPath())->encode('png');

            $headers = [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'attachment; filename='. $fileName,
            ];

            return response()->stream(function() use ($image) {
                echo $image;
            }, 200, $headers);
        }

        return view('frontend.images.webp_to_png_generator',compact('page_info','page_meta'));
    }

    /*public function jpgToPSDGenerator(Request $request)
    {
        $input_array = $request->all();

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'image' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }


            $image = $request->file('image');
            $fileName = time() . '.psd';
            
            $image = Image::make($image->getRealPath())->encode('psd');

            $headers = [
                'Content-Type' => 'image/psd',
                'Content-Disposition' => 'attachment; filename='. $fileName,
            ];

            return response()->stream(function() use ($image) {
                echo $image;
            }, 200, $headers);
        }

        return view('frontend.images.jpg_to_psd_generator');
    }

    public function pngToPSDGenerator(Request $request)
    {
        $input_array = $request->all();

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'image' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }


            $image = $request->file('image');
            $fileName = time() . '.psd';
            
            $image = Image::make($image->getRealPath())->encode('psd');

            $headers = [
                'Content-Type' => 'image/psd',
                'Content-Disposition' => 'attachment; filename='. $fileName,
            ];

            return response()->stream(function() use ($image) {
                echo $image;
            }, 200, $headers);
        }

        return view('frontend.images.png_to_psd_generator');
    }*/

    public function imageCompressor(Request $request)
    {
        $input_array = $request->all();

        $page_meta = [];
        $page_info = fetch_meta_information('image-compressor');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'image' => 'required',
                'quality' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName = time() . '.'. $extension;
            
            $image = Image::make($image->getRealPath())->encode($extension, $input_array['quality']);

            $headers = [
                'Content-Type' => 'image/'.$extension,
                'Content-Disposition' => 'attachment; filename='. $fileName,
            ];

            return response()->stream(function() use ($image) {
                echo $image;
            }, 200, $headers);
        }

        return view('frontend.images.image_compressor', compact('page_info','page_meta'));
    }

    public function imageResizer(Request $request)
    {
        $input_array = $request->all();

        $page_meta = [];
        $page_info = fetch_meta_information('image-resizer');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'image' => 'required',
                'width' => 'required',
                'height' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName = time() . '.'. $extension;
            
            $image = Image::make($image->getRealPath())
                ->resize($input_array['width'], $input_array['height'])
                ->encode($extension);

            $headers = [
                'Content-Type' => 'image/'.$extension,
                'Content-Disposition' => 'attachment; filename='. $fileName,
            ];

            return response()->stream(function() use ($image) {
                echo $image;
            }, 200, $headers);
        }

        return view('frontend.images.image_resizer', compact('page_info','page_meta'));
    }

    public function convertBase64(Request $request)
    {
        $input_array = $request->all();

        $page_meta = [];
        $page_info = fetch_meta_information('image-to-base64');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'image' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }
            $image = $request->file('image');
            
            $data = (string) Image::make($image->getRealPath())->encode('data-url');

            return view('frontend.images.image_base64_generator', compact('data'));    
        }

        return view('frontend.images.image_base64_generator',compact('page_meta','page_info'));
    }
}