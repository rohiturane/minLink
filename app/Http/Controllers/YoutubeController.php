<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\YoutubeService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;


class YoutubeController extends Controller
{
    public $service;

    public function __construct(YoutubeService $service)
    {
        $this->service = $service;    
    }
    
    public function getTrends(Request $request)
    {
        $languages = Config::get('constant.languages');
        $countries = Config::get('constant.countries');
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-trends');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'lang' => 'required',
                'country' => 'required',
                'result' => 'required|numeric|min:1|max:100'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $dataArray = $this->service->getTrendingData($input_array);

            return view('frontend.youtube.trends', compact('languages','countries','page_info','page_meta','dataArray'));
        }

        return view('frontend.youtube.trends', compact('languages','countries','page_info','page_meta'));
    }

    public function extractTags(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-extract-tags');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'link' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $dataArray = $this->service->getTagExtractor($input_array);

            return view('frontend.youtube.tag_extractor', compact('dataArray', 'page_info','page_meta'));
        }

        return view('frontend.youtube.tag_extractor', compact('page_info','page_meta'));
    }

    public function generateTags(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-generate-tags');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        $languages = Config::get('constant.languages');

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'keywords' => 'required',
                'lang' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $dataArray = $this->service->generateTag($input_array);
            
            return view('frontend.youtube.generate_tags', compact('languages','dataArray','page_info','page_meta'));
        }
        else {
            return view('frontend.youtube.generate_tags', compact('languages','page_info','page_meta'));
        }
    }

    public function extractHashtag(Request $request)
    {
        $input_array = $request->all();

        $page_meta = [];
        $page_info = fetch_meta_information('youtube-extract-hashtag');
        
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

            $dataArray = $this->service->extractHashtag($input_array);

            return view('frontend.youtube.hashtag_extractor',compact('dataArray','page_info','page_meta'));
        }
        return view('frontend.youtube.hashtag_extractor',compact('page_info','page_meta'));
    }

    public function generateHashtag(Request $request)
    {
        $input_array = $request->all();
        $languages = Config::get('constant.languages');
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-generate-hashtag');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }

        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'keywords' => 'required',
                'lang' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $dataArray = $this->service->generateHashtag($input_array);

            return view('frontend.youtube.generate_hashtags', compact('languages','dataArray','page_info','page_meta'));
        }
        return view('frontend.youtube.generate_hashtags', compact('languages','page_info','page_meta'));
    }

    public function extractVideoTitle(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-extract-title');
        
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

            $dataArray = $this->service->extractVideoTitle($input_array);
            
            return view('frontend.youtube.extract_video_title', compact('dataArray','page_info','page_meta'));
        }

        return view('frontend.youtube.extract_video_title',compact('page_info','page_meta'));
    }

    public function generateVideoTitle(Request $request)
    {
        $input_array = $request->all();
        $countries = Config::get('constant.countries');
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-generate-video-title');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'keywords' => 'required',
                'country' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $dataArray = $this->service->generateVideoTitle($input_array);


            return view('frontend.youtube.generate_video_title', compact('countries','dataArray','page_info','page_meta'));
        }

        return view('frontend.youtube.generate_video_title',compact('countries','page_info','page_meta'));
    }

    public function extractVideoDecription(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-extract-description');
        
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

            $data = $this->service->extractVideoDescription($input_array);
            
            return view('frontend.youtube.extract_video_description', compact('data','page_info','page_meta'));
        }

        return view('frontend.youtube.extract_video_description',compact('page_info','page_meta'));
    }

    public function makeEmbedVideo(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-embed-video');
        
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

            $check = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $input_array['link'], $videoId);
            $data = '';
            if ( $check ) {

                $info = array(
                    'start'          => ( ( !empty($input_array['start_min']) ? $input_array['start_min'] * 60 : 0 ) + ( !empty($input_array['start_sec']) ? $input_array['start_sec'] : 0 ) ) ?: null,
                    'end'            => ( ( !empty($input_array['end_min']) ? $input_array['end_min'] * 60 : 0 ) + ( !empty($input_array['end_sec']) ? $input_array['end_sec'] : 0 ) ) ?: null,
                    'loop'           => empty($input_array['loop_video'] ) ? '': $input_array['loop_video'],
                    'autoplay'       => empty( $input_array['auto_play_video'] ) ? '': $input_array['auto_play_video'],
                    'fs'             => empty( $input_array['hide_full_screen_button'] ) ? 0 : null,
                    'controls'       => empty( $input_array['hide_player_controls'] ) ? 0 : null,
                    'modestbranding' => empty( $input_array['hide_youtube_logo'] ) ? 0 : $input_array['hide_youtube_logo'],
                );

                $query = http_build_query( array_filter($info, 'strlen') );

                $embed_link = ( !empty($input_array['no_cookie']) && $input_array['no_cookie'] == true) ? 'https://www.youtube-nocookie.com/embed/' . $videoId[1] : 'https://www.youtube.com/embed/' . $videoId[1];

                $embed_link .= ($query) ? '?' : '';

                if (!empty($input_array['responsive'])) {
                    
                    $data = '<div style="position:relative;height:0;overflow:hidden;padding-bottom:56.25%;border-style:none"><iframe style="position:absolute;top:0;left:0;width:100%;height:100%" src="'.$embed_link . $query.'"></iframe></div>';
                      
                }
                else $data = '<iframe width="'.$input_array['size_width'].'" height="'.$input_array['size_height'].'" src="'.$embed_link . $query.'"></iframe>';
                
                return view('frontend.youtube.embed_video_code', compact('data','page_info','page_meta'));
            } else {

                session()->flash('status', 'error');
                session()->flash('message', __('Invalid Video URL!'));
                return;
            }
        }

        return view('frontend.youtube.embed_video_code', compact('page_info','page_meta'));
    }

    public function extractChannelId(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-channel-id');
        
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

            $data = $this->service->extractChannelId($input_array);
            
            return view('frontend.youtube.get_channel_id',compact('data','page_info','page_meta'));
        }

        return view('frontend.youtube.get_channel_id',compact('page_info','page_meta'));
    }

    public function getVideoStatistics(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-video-statistics');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'link' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $dataArray = $this->service->getVideoStatistics($input_array);

            return view('frontend.youtube.get_video_statistics', compact('dataArray','page_info','page_meta'));
        }

        return view('frontend.youtube.get_video_statistics',compact('page_info','page_meta'));
    }

    public function getChannelStatistics(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-channel-statistics');
        
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

            $dataArray = $this->service->getChannelStatistics($input_array);

            return view('frontend.youtube.get_channel_statistics', compact('dataArray','page_info','page_meta'));
        }

        return view('frontend.youtube.get_channel_statistics',compact('page_info','page_meta'));
    }

    public function getChannelLogo(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-logo-download');
        
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

            $dataArray = $this->service->getChannelLogo($input_array);

            return view('frontend.youtube.download_channel_logo', compact('dataArray','page_info','page_meta'));
        }

        return view('frontend.youtube.download_channel_logo',compact('page_info','page_meta'));
    }

    public function getChannelBanner(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-banner-download');
        
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

            $dataArray = $this->service->getChannelBanner($input_array);
            
            return view('frontend.youtube.download_channel_banner', compact('dataArray','page_info','page_meta'));
        }

        return view('frontend.youtube.download_channel_banner', compact('page_info','page_meta'));
    }

    public function moneyCalculator(Request $request)
    {
        $input_array = $request->all();
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-money-calculator');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array, [
                'daily_views' => 'required',
                'amount'     => 'required',
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }
            preg_match_all('!\d+\.*\d*!', $input_array['amount'], $matches);
            
            $min_cpm = $matches[0][0];
            $max_cpm = $matches[0][1];

            $earnings_min = ( intval($input_array['daily_views']) / 1000) * $min_cpm;
            $earnings_max = ( intval($input_array['daily_views']) / 1000) * $max_cpm;

            $data['cpm_min'] = number_format( $earnings_min, 2);
            $data['cpm_max'] = number_format( $earnings_max, 2);

            $data['cpm_min_monthly'] = number_format( $earnings_min * 30, 2);
            $data['cpm_max_monthly'] = number_format( $earnings_max * 30, 2);

            $data['cpm_min_yearly'] = number_format( $earnings_min * 30 * 12, 2);
            $data['cpm_max_yearly'] = number_format( $earnings_max * 30 * 12, 2);

            return view('frontend.youtube.money_calculator',compact('data','page_info','page_meta'));
        }

        return view('frontend.youtube.money_calculator',compact('page_info','page_meta'));
    }

    public function searchChannel(Request $request)
    {
        $input_array = $request->all();
        $countries = Config::get('constant.countries');
        $page_meta = [];
        $page_info = fetch_meta_information('youtube-channel-search');
        
        if(!empty($page_info)) {
            $page_meta = generate_meta_information($page_info);
        }
        if(!empty($input_array))
        {
            $validate = Validator::make($input_array,[
                'query' => 'required',
                'country' => 'required',
                'result' => 'required'
            ]);

            if($validate->fails())
            {
                return back()->withErrors($validate)->withInput();
            }

            $dataArray = $this->service->searchChannel($input_array);
            
            return view('frontend.youtube.search_channel',compact('dataArray','countries','page_info','page_meta'));
        }

        return view('frontend.youtube.search_channel', compact('countries','page_info','page_meta'));
    }
}
