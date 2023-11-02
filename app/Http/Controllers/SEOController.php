<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Services\SEOService;
use App\Services\CountryService;
use Iodev\Whois\Factory as Whois;
use Html2Text\Html2Text;

class SEOController extends Controller
{
    public $service;
    public $country;

    public function __construct(SEOService $service, CountryService $country)
    {
        $this->service = $service;
        $this->country = $country;
    }

    public function googlePageSpeed(Request $request)
    {
        $input_array = $request->all();

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'link' => 'required|url'
            ]);
            
            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $dataArray = $this->service->googlePageSpeed($input_array);
            dd($dataArray);
            return view('frontend.blogger.google_page_speed', compact('data'));
        }

        return view('frontend.blogger.google_page_speed');
    }

    public function domainAgeChecker(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('domain-age-checker');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'link' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $data = $this->service->getDomainInfo($input_array);

            return view('frontend.blogger.domain_age_checker', compact('data','page_info','page_meta'));
        }

        return view('frontend.blogger.domain_age_checker',compact('page_info','page_meta'));
    }

    public function googleCacheChecker(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('google-cache-checker');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'link' => 'required|url'
            ]);
            
            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $data = $this->service->googleCacheChecker($input_array);
            
            return view('frontend.blogger.google_cache_checker', compact('data','page_info','page_meta'));
        }

        return view('frontend.blogger.google_cache_checker',compact('page_info','page_meta'));
    }

    public function googleIndexChecker(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('google-index-checker');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $data = [];

            $validate = Validator::make($input_array, [
                'link' => 'required|url',
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }
            $data = [];
            $url = 'https://webcache.googleusercontent.com/search?q=cache:' . urlencode($input_array['link']);
            $get_source = get_index_status($url);

            $data['status'] = $get_source;
            $data['domain_name'] = $input_array['link'];
            
            return view('frontend.blogger.google_index_checker',compact('data','page_info','page_meta'));
        }

        return view('frontend.blogger.google_index_checker', compact('page_info','page_meta'));
    }

    public function keywordDensityChecker(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('keyword-density-checker');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'link' => 'required|url'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }
            
            $data = $this->service->keywordDensityChecker($input_array);

            return view('frontend.blogger.keyword_density_checker', compact('data','page_info','page_meta'));
        }

        return view('frontend.blogger.keyword_density_checker', compact('page_info','page_meta'));
    }


    public function keywordSuggestionTool(Request $request)
    {
        $input_array = $request->all();

        $page_meta = [];
        $page_info = fetch_meta_information('keyword-suggestion');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {

            $validate = Validator::make($input_array,[
                'query' => 'required',
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $data = $this->service->keywordSuggestionTool($input_array);
            
            return view('frontend.blogger.keyword_suggestion_tool', compact('data','page_info','page_meta'));
        }

        return view('frontend.blogger.keyword_suggestion_tool',compact('page_info','page_meta'));
    }

    public function metaTagsAnalyzer(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('meta-tag-checker');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'link' => 'required|url'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $dataArray = $this->service->metaTagsAnalyzer($input_array, array ('title','description' ,'keywords', 'viewport', 'robots', 'author'));

            return view('frontend.blogger.meta_tags_analyzer', compact('dataArray','page_info','page_meta'));
        }

        return view('frontend.blogger.meta_tags_analyzer', compact('page_info','page_meta'));
    }

    public function openGraphChecker(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('open-graph-checker');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'link' => 'required|url'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $dataArray = $this->service->openGraphChecker($input_array, [
                'og:url',
                'og:title',
                'og:type',
                'og:description',
                'og:site_name',
                'og:image',
                'fb:app_id',
                'og:locale',
                'og:video',
                'og:video:url',
                'og:video:secure_url',
                'og:video:type',
                'og:video:width',
                'og:video:height',
                'og:image',
                'og:image:url',
                'og:image:secure_url',
                'og:image:type',
                'og:image:width',
                'og:image:height'
            ]);

            return view('frontend.blogger.open_graph_checker', compact('dataArray','page_info','page_meta'));
        }
        return view('frontend.blogger.open_graph_checker',compact('page_info','page_meta'));
    }

    public function domainLookup(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('domain-lookup');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'link' => 'required',
            ]);
            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $dataArray = $this->service->domainLookup($input_array);

            return view('frontend.blogger.domain_lookup', compact('dataArray','page_info','page_meta'));
        }

        return view('frontend.blogger.domain_lookup',compact('page_info','page_meta'));
    }

    public function adsenceCalculator(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('adsence-calculator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'ctr' => 'required|numeric',
                'cpc' => 'required|numeric',
                'impressions' => 'required|numeric'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $daily_earnings                = $input_array['impressions'] * ($input_array['ctr'] / 100) * $input_array['cpc'];
            $daily_clicks                  = $input_array['impressions'] * ($input_array['ctr'] / 100);

            $data['daily_earnings']  = $daily_earnings;
            $data['daily_clicks']    = $daily_clicks;

            $data['mothly_earnings'] = $daily_earnings * 30;
            $data['mothly_clicks']   = $daily_clicks *30;

            $data['yearly_earnings'] = $daily_earnings * 360;
            $data['yearly_clicks']   = $daily_clicks * 360;

            return view('frontend.blogger.adsence_calculator', compact('data','page_info','page_meta'));
        }

        return view('frontend.blogger.adsence_calculator',compact('page_info','page_meta'));
    }

    public function robotTxtGenerator(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('robot-txt-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'all_robots' => 'required',
                'delay'   => 'required',
                'sitemap' => 'required'
            ]);

            $data = '';

            $data .= 'User-agent: *' . PHP_EOL . 'Disallow:' . $input_array['all_robots'] . PHP_EOL;

            $data .= ($input_array['delay'] != "") ? 'Crawl-delay: ' . $input_array['delay'] . PHP_EOL : null;

            $data .= ($input_array['sitemap'] != "") ? 'Sitemap: ' .  $input_array['sitemap'] . PHP_EOL : null;

            $data .= ($input_array['google'] != "") ? 'User-agent: Googlebot' . PHP_EOL . 'Disallow:' . $input_array['google'] . PHP_EOL : null;

            $data .= ($input_array['google_image'] != "") ? 'User-agent: googlebot-image' . PHP_EOL . 'Disallow:' . $input_array['google_image'] . PHP_EOL : null;

            $data .= ($input_array['google_mobile'] != "") ? 'User-agent: googlebot-mobile' . PHP_EOL . 'Disallow:' . $input_array['google_mobile'] . PHP_EOL : null;

            $data .= ($input_array['msn_search'] != "") ? 'User-agent: MSNBot' . PHP_EOL . 'Disallow:' . $input_array['msn_search'] . PHP_EOL : null;

            $data .= ($input_array['yahoo'] != "") ? 'User-agent: Slurp' . PHP_EOL . 'Disallow:' . $input_array['yahoo'] . PHP_EOL : null;

            $data .= ($input_array['yahoo_mm'] != "") ? 'User-agent: yahoo-mmcrawler' . PHP_EOL . 'Disallow:' . $input_array['yahoo_mm'] . PHP_EOL : null;

            $data .= ($input_array['yahoo_blogs'] != "") ? 'User-agent:  yahoo-blogs/v3.9' . PHP_EOL . 'Disallow:' . $input_array['yahoo_blogs'] . PHP_EOL : null;

            $data .= ($input_array['ask_teoma'] != "") ? 'User-agent: Teoma' . PHP_EOL . 'Disallow:' . $input_array['ask_teoma'] . PHP_EOL : null;

            $data .= ($input_array['gigablast'] != "") ? 'User-agent: Gigabot' . PHP_EOL . 'Disallow:' . $input_array['gigablast'] . PHP_EOL : null;

            $data .= ($input_array['dmoz_checker'] != "") ? 'User-agent: Robozilla' . PHP_EOL . 'Disallow:' . $input_array['dmoz_checker'] . PHP_EOL : null;

            $data .= ($input_array['nutch'] != "") ? 'User-agent: Nutch' . PHP_EOL . 'Disallow:' . $input_array['nutch'] . PHP_EOL : null;

            $data .= ($input_array['alexa'] != "") ? 'User-agent: ia_archiver' . PHP_EOL . 'Disallow:' . $input_array['alexa'] . PHP_EOL : null;

            $data .= ($input_array['baidu'] != "") ? 'User-agent: baiduspider' . PHP_EOL . 'Disallow:' . $input_array['baidu'] . PHP_EOL : null;

            $data .= ($input_array['naver'] != "") ? 'User-agent: naverbot' . PHP_EOL . 'User-agent: yeti' . PHP_EOL . 'Disallow:' . $input_array['naver'] . PHP_EOL : null;

            $data .= ($input_array['msb_picpearch'] != "") ? 'User-agent: psbot' . PHP_EOL . 'Disallow:' . $input_array['msb_picpearch'] . PHP_EOL : null;

            if ( $input_array['folders'] != null) {
                $folder = preg_split('/\r\n|[\r\n]/', $input_array['folders']);
                foreach ($folder as $key => $value) {

                    $data .= 'Disallow: ' . $value . PHP_EOL;
                }

            }

            return view('frontend.blogger.robot_txt_generator', compact('data','page_info','page_meta'));
        }

        return view('frontend.blogger.robot_txt_generator',compact('page_info','page_meta'));
    }

    public function openGraphGenerator(Request $request)
    {
        $input_array = $request->all();

        $page_meta = [];
        $page_info = fetch_meta_information('open-graph-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $data = '';
            $data .= ($input_array['title'] != "") ? '<meta property="og:title" content="' . $input_array['title'] . '">' . PHP_EOL : null;

            $data .= ($input_array['site_name'] != "") ? '<meta property="og:site_name" content="' . $input_array['site_name'] . '">' . PHP_EOL : null;

            $data .= ($input_array['site_url'] != "") ? '<meta property="og:url" content="' . $input_array['site_url'] . '">' . PHP_EOL : null;

            $data .= ($input_array['description'] != "") ? '<meta property="og:description" content="' . $input_array['description'] . '">' . PHP_EOL : null;

            $data .= ($input_array['type'] != "") ? '<meta property="og:type" content="' . $input_array['type'] . '">' . PHP_EOL : null;

            if ( $input_array['images'] != null) {

                foreach ($input_array['images'] as $key => $value) {

                    $data .= '<meta property="og:image" content="'.$value.'">' . PHP_EOL;
                }

            }

            return view('frontend.blogger.open_graph_generator', compact('data','page_info','page_meta'));
        }

        return view('frontend.blogger.open_graph_generator',compact('page_info','page_meta'));
    }

    public function metaTagsGenerator(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('meta-tag-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $data = '';
            $data .= ($input_array['title'] != "") ? '<meta name="title" content="' . $input_array['title'] . '">' . PHP_EOL : null;

            $data .= ($input_array['description'] != "") ? '<meta name="description" content="' . $input_array['description'] . '">' . PHP_EOL : null;

            $data .= ($input_array['keywords'] != "") ? '<meta name="keywords" content="' . $input_array['keywords'] . '">' . PHP_EOL : null;

            $data .= '<meta name="robots" content="' . $input_array['robots_index'] . ', '.$input_array['robots_links'].'">' . PHP_EOL;

            $data .= ($input_array['content_type'] != "") ? '<meta http-equiv="Content-Type" content="' . $input_array['content_type'] . '">' . PHP_EOL : null;

            $data .= ($input_array['revisit_days'] != "") ? '<meta name="revisit-after" content="' . $input_array['revisit_days'] . '">' . PHP_EOL : null;

            $data .= ($input_array['language'] != "") ? '<meta name="description" content="' . $input_array['language'] . '">' . PHP_EOL : null;

            $data .= ($input_array['author'] != "") ? '<meta name="author" content="' . $input_array['author'] . '">' . PHP_EOL : null;

            return view('frontend.blogger.meta_tags_generator', compact('data','page_info','page_meta'));
        }

        return view('frontend.blogger.meta_tags_generator',compact('page_info','page_meta'));
    }

    public function privacyPolicyGenerator(Request $request)
    {
        $input_array = $request->all();
        $countries = $this->country->countryList();
        $page_meta = [];
        $page_info = fetch_meta_information('privacy-policy-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'company_name' => 'required',
                'site_name' => 'required',
                'site_url' => 'required',
                'country' => 'required',
                'state' => 'required',
                'email' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $data = $this->service->privacyPolicyGenerator($input_array);

            return view('frontend.blogger.privacy_policy_generator', compact('countries','data','page_info','page_meta'));
        }
        return view('frontend.blogger.privacy_policy_generator',compact('countries','page_info','page_meta'));
    }

    public function getStateList(Request $request)
    {
        $input_array = $request->all();

        $states = $this->country->stateList($input_array);

        return response()->json($states);
    }

    public function termsOfServiceGenerator(Request $request)
    {
        $input_array = $request->all();
        $countries = $this->country->countryList();
        $page_meta = [];
        $page_info = fetch_meta_information('terms-of-service-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'company_name' => 'required',
                'site_name' => 'required',
                'site_url' => 'required',
                'country' => 'required',
                'state' => 'required',
                'email' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $data = $this->service->termsOfServiceGenerator($input_array);

            return view('frontend.blogger.terms_of_service_generator', compact('countries','data','page_info','page_meta'));
        }

        return view('frontend.blogger.terms_of_service_generator', compact('countries','page_info','page_meta'));
    }

    public function loremIpsumGenerator(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('lorem-ipsum-generator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'count' => 'required|numeric',
                'type' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $data = $this->service->loremIpsumGenerator($input_array);
            
            return view('frontend.blogger.lorem_ipsum_generator', compact('data','page_info','page_meta'));
        }
        return view('frontend.blogger.lorem_ipsum_generator', compact('page_info','page_meta'));
    }

    public function gzipCompressionChecker(Request $request)
    {
        $input_array = $request->all();

        $page_meta = [];
        $page_info = fetch_meta_information('gzip-enabled-checker');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'link' => 'required',
            ]);
            
            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }
            
            $ch = curl_init($input_array['link']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // follow redirects
            curl_setopt($ch, CURLOPT_HEADER, 1); // include headers in curl response
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Encoding: gzip, deflate', 
                'Accept-Language: en-US,en;q=0.5',
                'Connection: keep-alive',
                'SomeBull: BeingIgnored',
                'User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:16.0) Gecko/20100101 Firefox/16.0'
              )
            );
            $response = curl_exec($ch);
            if ($response === false) {
                die('Error fetching page: ' . curl_error($ch));
            }
            
            $info = curl_getinfo($ch);
            
            for ($i = 0; $i <= $info['redirect_count']; ++$i) {
                // split request and headers into separate vars for as many times 
                // as there were redirects
                list($headers, $response) = explode("\r\n\r\n", $response, 2);
            }
            
            curl_close($ch);

            $headers = explode("\r\n", $headers); // split headers into one per line
            $hasGzip = 'disabled';

            foreach($headers as $header) { // loop over each header
                if (stripos($header, 'Content-Encoding') !== false) { // look for a Content-Encoding header
                    if (strpos($header, 'gzip') !== false) { // see if it contains gzip
                        $hasGzip = 'enabled';
                    }
                }
            }

            return view('frontend.blogger.gzip_enabled_checker',compact('hasGzip','page_info','page_meta'));
        }

        return view('frontend.blogger.gzip_enabled_checker',compact('page_info','page_meta'));
    }

    public function malwareChecker(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('malware-checker');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'link' => 'required'
            ]);
            
            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $data = '{
                "client": {
                  "clientId": "licensys",
                  "clientVersion": "1.0"
                },
                "threatInfo": {
                  "threatTypes":      ["MALWARE", "SOCIAL_ENGINEERING"],
                  "platformTypes":    ["LINUX"],
                  "threatEntryTypes": ["URL"],
                  "threatEntries": [
                    {"url": "'.$request->input('link').'"}
                  ]
                }
              }';
            $str_data = json_encode(json_decode($data),JSON_UNESCAPED_SLASHES);
            //dd($str_data);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key='.env('SAFE_GOOGLE_API'));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", 'Content-Length: ' . strlen($str_data)));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $str_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            dd($result);
            return view('frontend.blogger.malware_checker',compact('page_info','page_meta'));
        }

        return view('frontend.blogger.malware_checker', compact('page_info','page_meta'));
    }
}
