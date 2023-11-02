<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\DeveloperService;
use App\Libraries\HTMLMinify;
use App\Libraries\CSSMinify;
use App\Libraries\JavaScriptMinify;

class DeveloperController extends Controller
{
    public $service;

    public function __construct(DeveloperService $service)
    {
        $this->service = $service;
    }

    public function csvToJSONConverter(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('csv-to-json-converter');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'file' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }
            $file = $request->file('file');
            if($input_array['type'] == 1)
            {
                $data = json_encode(CSVtoArray($file->getRealPath()));
            } else {
                $data = json_encode(CSVtoAssocArray($file->getRealPath()));
            }

            return view('frontend.developer.csv_to_json_converter', compact('data','page_info','page_meta'));
        }

        return view('frontend.developer.csv_to_json_converter',compact('page_info','page_meta'));
    }

    public function jsonTOCSVConverter(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('json-to-csv-converter');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'json_data' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $items = @json_decode($input_array['json_data']);

            $csv = [];
            //dd($items);
            foreach($items as $i => $item) {
                if($i == 0) {
                    
                    //if(!is_array($item)) {
                        $keys = array_keys(get_object_vars($item));
    
                        $csv[] = join(',', $keys);
                        $csv[] = join(',', array_values((array)$item));
                        continue;
                   // }
                }
                   
                $csv[] = join(',', array_values((array)$item));
            }
    
            $data = join("\n", $csv);

            return view('frontend.developer.json_to_csv_converter', compact('data','page_info','page_meta'));
        }

        return view('frontend.developer.json_to_csv_converter',compact('page_info','page_meta'));
    }

    public function jsonBeautifier(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('json-beautifier');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'json_data' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }
            //dd($input_array);
            $data = $this->pretty_json($input_array['json_data'], "\n", "\t");

            return view('frontend.developer.json_beautifier', compact('data','page_info','page_meta'));
        }

        return view('frontend.developer.json_beautifier',compact('page_info','page_meta'));
    }

    public function pretty_json($json, $ret= "\n", $ind="\t") 
    {

        $beauty_json = '';
        $quote_state = FALSE;
        $level = 0; 

        $json_length = strlen($json);

        for ($i = 0; $i < $json_length; $i++)
        {                               

            $pre = '';
            $suf = '';

            switch ($json[$i])
            {
                case '"':                               
                    $quote_state = !$quote_state;                                                           
                    break;

                case '[':                                                           
                    $level++;               
                    break;

                case ']':
                    $level--;                   
                    $pre = $ret;
                    $pre .= str_repeat($ind, $level);       
                    break;

                case '{':

                    if ($i - 1 >= 0 && $json[$i - 1] != ',')
                    {
                        $pre = $ret;
                        $pre .= str_repeat($ind, $level);                       
                    }   

                    $level++;   
                    $suf = $ret;                                                                                                                        
                    $suf .= str_repeat($ind, $level);                                                                                                   
                    break;

                case ':':
                    $suf = ' ';
                    break;

                case ',':

                    if (!$quote_state)
                    {  
                        $suf = $ret;                                                                                                
                        $suf .= str_repeat($ind, $level);
                    }
                    break;

                case '}':
                    $level--;   

                case ']':
                    $pre = $ret;
                    $pre .= str_repeat($ind, $level);
                    break;

            }

            $beauty_json .= $pre.$json[$i].$suf;

        }

        return $beauty_json;

    } 

    public function jsonValidation(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('json-validator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'json_data' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }
            $flag = true;
            $data = is_json($input_array['json_data']);
            // dd($data);
            return view('frontend.developer.json_validator', compact('data','flag','page_info','page_meta'));
        }

        return view('frontend.developer.json_validator',compact('page_info','page_meta'));
    }

    public function htmlMinify(Request $request)
    {
        $input_array = $request->all();

        $page_meta = [];
        $page_info = fetch_meta_information('html-minifier');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'content' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }
            $content = $input_array['content'];
            //$data = minify_html($content);
            $htmlminify = new HTMLMinify();
            $data = $htmlminify->minifyPHP($content);

            return view('frontend.developer.html_minify', compact('data','content','page_info','page_meta'));
        }

        return view('frontend.developer.html_minify', compact('page_info','page_meta'));
    }

    public function cssMinify(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('css-minifier');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'content' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }
            $content = $input_array['content'];
            // $data = minify_css($content);
            $cssminify = new CSSMinify();
            $data = $cssminify->minifyCSS($content);

            return view('frontend.developer.css_minify', compact('data','content','page_info','page_meta'));
        }

        return view('frontend.developer.css_minify',compact('page_info','page_meta'));
    }

    public function jsMinify(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('js-minifier');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'content' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }
            $content = $input_array['content'];
            // $data = minify_js($content);
            $javascriptminify = new JavaScriptMinify();
            $data = $javascriptminify->minifyJavascript($content);

            return view('frontend.developer.js_minify', compact('data','content','page_info','page_meta'));
        }

        return view('frontend.developer.js_minify',compact('page_info','page_meta'));
    }

    public function passwordGenerator(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('password-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'password_length' => 'required',
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }
            
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            if(!empty($input_array['include_number']))
            {
                $characters.='0123456789';
            }
            if(!empty($input_array['include_symbol']))
            {
                $characters.='!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~';
            }
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $input_array['password_length']; $i++) {
                $randomString .= $characters[random_int(0, $charactersLength - 1)];
            }
            return view('frontend.developer.password_generator', compact('randomString','page_info','page_meta'));
        }

        return view('frontend.developer.password_generator',compact('page_info','page_meta'));
    }

    public function md5Generator(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('md5-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'string' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $data = md5($input_array['string']);

            return view('frontend.developer.md5_generator', compact('data','page_info','page_meta'));
        }
        return view('frontend.developer.md5_generator',compact('page_info','page_meta'));
    }

    public function shaGenerator(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('sha-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'string' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $data = sha1($input_array['string']);

            return view('frontend.developer.sha_generator', compact('data','page_info','page_meta'));
        }

        return view('frontend.developer.sha_generator',compact('page_info','page_meta'));
    }

    public function bcryptGenerator(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('bcrypt-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'string' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $data = bcrypt($input_array['string']);

            return view('frontend.developer.bcrypt_generator', compact('data','page_info','page_meta'));
        }
        return view('frontend.developer.bcrypt_generator',compact('page_info','page_meta'));
    }

    public function hashGenerator(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('hash-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'string' => 'required'
            ]);
        
            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $data = hash('md2', $input_array['string']);

            return view('frontend.developer.hash_generator', compact('data','page_info','page_meta'));
        }

        return view('frontend.developer.hash_generator',compact('page_info','page_meta'));
    }
}

 