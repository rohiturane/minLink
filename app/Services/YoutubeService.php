<?php

namespace App\Services;

use Google\Client;
use Google\Service\YouTube;
use Illuminate\Support\Facades\Config;

class YoutubeService
{
    
    private function commonYoutube()
    {
        $client = new Client();
        $client->setDeveloperKey(Config::get('constant.google_api_key'));
        
        $youtube = new YouTube($client);

        return $youtube;
    }

    public function getTrendingData($data)
    {
        try {

            $dataArray = [];

            $youtube = $this->commonYoutube();

            $value = $youtube->videos->listVideos('snippet', array(
                'chart'      => 'mostPopular',
                'maxResults' => $data['result'],
                'regionCode' => $data['country'],
                'hl'         => $data['lang']
            ));
            
            if(!empty($value)) {
                
                for( $i = 0; $i < count($value['items']); $i++ ){ 
                        
                    $dataArray[$i]['thumbnail'] = $value['items'][$i]['snippet']['thumbnails']['default']['url'];

                    $dataArray[$i]['title'] = $value['items'][$i]['snippet']['title'];

                    $dataArray[$i]['link']    = 'https://youtu.be/' . $value['items'][$i]['id'];

                    $dataArray[$i]['tags'] = array();

                    array_push($dataArray[$i]['tags'], $value['items'][$i]['snippet']['tags']);
                }
                return $dataArray;
            } else {
                session()->flash('status','error');
                session()->flash('message','No Result Found');
                return ;
            }
        } catch (\Exception $e) {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }

    public function getTagExtractor($data)
    {
        try {
                $youtube = $this->commonYoutube();
                $dataArray = [];
                $check = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $data['link'], $videoId);

                if($check) 
                {
                    $value = $youtube->videos->listVideos('snippet', array(
                        'id' => $videoId[1]
                    ));
                    
                    if(count($value['items'][0]['snippet']['tags']) > 0) 
                    {
                        array_push($dataArray, $value['items'][0]['snippet']['tags']);
                    } else {
                        session()->flash('status','error');
                        session()->flash('message','No tags applied');
                        return;
                    }
                    
                    return $dataArray[0];
                } else {
                    session()->flash('status','error');
                    session()->flash('message','Invalid Video URL');
                    return ;
                }
        } catch (\Exception $e) {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }

    public function generateTag($data)
    {
        $url = 'http://suggestqueries.google.com/complete/search?callback=?&hl='.strtolower($data['lang']).'&ds=yt&jsonp=suggestCallBack&client=youtube&q='.urlencode($data['keywords']);
       
        try {
            $get_source = curl_call($url, 'get',[]);
            
            preg_match('/suggestCallBack\((.*)\)/', $get_source, $match);
            
            $deJson     = json_decode($match[1], true);
            $dataArray = array();
            
            if($deJson[1])
            {
                foreach($deJson[1] as $value)
                {
                    array_push($dataArray, $value[0]);
                }
            }
            
            return $dataArray;
        } catch(\Exception $e)
        {
            session()->flash('status','error');
            session()->flash('message',$e->getMessage());
            return;
        }
    }

    public function extractHashtag($data)
    {
        try {
            $youtube = $this->commonYoutube();

            $check = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $data['link'], $videoId);

            if($check) {
                $value = $youtube->videos->listVideos('snippet', array(
                    'id' => $videoId[1]
                ));

                if( !empty($value['items'][0]['snippet']['description'])) {

                    $data = get_hash_tags( $value['items'][0]['snippet']['description'] );
                } 
                else {
                    session()->flash('status', 'error');
                    session()->flash('message', __('No Result Found!'));
                    return;
                }
                return $data;
            } else {
                session()->flash('status','error');
                session()->flash('message','Invalid Video URL!');
                return;
            }
        } catch (\Exception $e) {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }

    public function generateHashtag($data)
    {
        $url = 'http://suggestqueries.google.com/complete/search?callback=?&hl='.strtolower($data['lang']).'&ds=yt&jsonp=suggestCallBack&client=youtube&q=' . urlencode($data['keywords']);

        try {
            $get_source = curl_call($url, 'get',[]);
            $get_source = preg_match('/suggestCallBack\((.*)\)/', $get_source, $match);

            $deJson     = json_decode($match[1], true);
            $dataArray = array();

            if($deJson[1])
            {
                $specChars = array(' ','!','"','#','$','%','&','\'','(',')','*','+',',','-','.','/',':',';','<','=','>','?','@','[','\\',']','^','_','`','{','|','}','~');
                foreach ($deJson[1] as $value) {

                    array_push($dataArray, str_replace($specChars, '', $value[0]));

                }
            }

            return $dataArray;
        } catch(\Exception $e)
        {
            session()->flash('status','error');
            session()->flash('message',$e->getMessage());
            return;
        }
    }

    public function extractVideoTitle($data)
    {
        try {
            $youtube = $this->commonYoutube();

            $check = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $data['link'], $videoId);

            if($check) {
                $value = $youtube->videos->listVideos('snippet', array(
                    'id' => $videoId[1]
                ));

                if( !empty($value['items'][0]['snippet']['title'])) {

                    $data = $value['items'][0]['snippet']['title'];
                } 
                else{

                    session()->flash('status', 'error');
                    session()->flash('message', __('No Result Found!'));
                    return;
                }

                return $data;
            } else {
                session()->flash('status','error');
                session()->flash('message','Invalid Video URL!');
                return;
            }
        } catch (\Exception $e) {
            session()->flash('status','error');
            session()->flash('message',$e->getMessage());
            return;
        }
    }

    public function generateVideoTitle($data)
    {
        try {
            $youtube = $this->commonYoutube();
            
            $dataArray = array();
            $value = $youtube->search->listSearch('id,snippet', array(
                'q'          => $data['keywords'],
                'maxResults' => 50,
                'regionCode' => $data['country']
            ));

            if( count($value['items']) != 0 ) {

                $arr = array_rand($value['items'], 10);

                foreach ($arr as $k => $v) {
                    array_push($dataArray, $value['items'][$v]['snippet']['title']);
                }

                return $dataArray;
            } 
            else{

                session()->flash('status', 'error');
                session()->flash('message', 'No Result Found!');
                return;
            }

            return $dataArray;
        } catch (\Exception $e) {
            session()->flash('status', 'error');
            session()->flash('message', $e->getMessage());
            dd($e->getMessage());
            return;
        }
    }

    public function extractVideoDescription($data)
    {
        try {
            $youtube = $this->commonYoutube();
            $check = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $data['link'], $videoId);
            $dataArray = '';
            
            if ( $check ) {

                $value = $youtube->videos->listVideos('snippet', array(
                    'id' => $videoId[1]
                ));

                if( !empty($value['items'][0]['snippet']['description'])) {

                    $dataArray = $value['items'][0]['snippet']['description'];
                } 
                else{

                    session()->flash('status', 'error');
                    session()->flash('message', __('No Result Found!'));
                    return;
                }
                
                return $dataArray;
            } else {
                session()->flash('status', 'error');
                session()->flash('message', 'No Result Found!');
                return;
            }
        } catch (\Exception $e) {
            session()->flash('status', 'error');
            session()->flash('message', $e->getMessage());
            dd($e->getMessage());
            return;
        }
    }

    public function extractChannelId($data)
    {
        try {
            
            $source = curl_call($data['link'],'get',[]);
            $data = '';
            preg_match('/"browseId":"(.*?)"/', $source, $channelId);

            if( !empty($channelId[1]) ) {

                $data = $channelId[1];

                return $data;
            } 
            else{

                session()->flash('status', 'error');
                session()->flash('message', __('No Result Found!'));
                return;
            }
        } catch (\Exception $e) {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }

    public function getVideoStatistics($data)
    {
        $check = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $data['link'], $videoId);
        $categoriesID = Config::get('constant.categories');
        if($check)
        {
            $url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet,statistics&id='.$videoId[1].'&key='.Config::get('constant.google_api_key');
            $source = curl_call($url, 'get',[]);
            $dataArray = array();
            $deJson = json_decode( $source, true );
            if( count($deJson['items'][0]['snippet']) != 0 ) {

                $dataArray['publishedAt']     = !empty( $deJson['items'][0]['snippet']['publishedAt'] ) ? $deJson['items'][0]['snippet']['publishedAt'] : 0;

                $dataArray['channelId']       = !empty( $deJson['items'][0]['snippet']['channelId'] ) ? $deJson['items'][0]['snippet']['channelId'] : 0;

                $dataArray['title']           = !empty( $deJson['items'][0]['snippet']['title'] ) ? $deJson['items'][0]['snippet']['title'] : 0;

                $dataArray['description']     = !empty( $deJson['items'][0]['snippet']['description'] ) ? $deJson['items'][0]['snippet']['description'] : 0;

                $dataArray['channelTitle']    = !empty( $deJson['items'][0]['snippet']['channelTitle'] ) ? $deJson['items'][0]['snippet']['channelTitle'] : 0;

                $dataArray['thumbnails']      = $deJson['items'][0]['snippet']['thumbnails'];

                $dataArray['tags']            = empty($deJson['items'][0]['snippet']['tags']) ? [] : $deJson['items'][0]['snippet']['tags'];

                $dataArray['category']        = !empty( $deJson['items'][0]['snippet']['categoryId'] ) ? $categoriesID[$deJson['items'][0]['snippet']['categoryId']] : 0;

                $dataArray['defaultLanguage'] = !empty( $deJson['items'][0]['snippet']['defaultLanguage'] ) ? $deJson['items'][0]['snippet']['defaultLanguage'] : 0;

                $dataArray['viewCount'] = !empty( $deJson['items'][0]['statistics']['viewCount'] ) ? $deJson['items'][0]['statistics']['viewCount'] : 0;

                $dataArray['likeCount'] = !empty( $deJson['items'][0]['statistics']['likeCount'] ) ? $deJson['items'][0]['statistics']['likeCount'] : 0;

                $dataArray['commentCount'] = !empty( $deJson['items'][0]['statistics']['commentCount'] ) ? $deJson['items'][0]['statistics']['commentCount'] : 0;

                return $dataArray;
            } else{

                session()->flash('status', 'error');
                session()->flash('message', __('No Result Found!'));
                return;
            }
        } else {
            session()->flash('status','error');
            session()->flash('message','Invalid Video URL!!');
            return;
        }
    }

    public function getChannelStatistics($data)
    {
        try 
        {
            $response = curl_call($data['link'],'get',[]);

            preg_match('/"browseId":"(.*?)"/', $response, $channelId);

            if(!empty($channelId[1]))
            {
                $url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id='.$channelId[1].'&key=' . Config::get('constant.google_api_key');
                
                $source = curl_call($url, 'get', []);
                $dataArray = [];
                $deJson = json_decode($source, true);

                if( count($deJson['items'][0]['snippet']) != 0 ) {

                    $dataArray['channelId'] = isset( $deJson['items'][0]['id'] ) ? $deJson['items'][0]['id'] : 0;

                    $dataArray['channelTitle'] = isset( $deJson['items'][0]['snippet']['title'] ) ? $deJson['items'][0]['snippet']['title'] : 0;

                    $dataArray['description'] = isset( $deJson['items'][0]['snippet']['description'] ) ? $deJson['items'][0]['snippet']['description'] : 0;

                    $dataArray['publishedAt'] = isset( $deJson['items'][0]['snippet']['publishedAt'] ) ? $deJson['items'][0]['snippet']['publishedAt'] : 0;

                    $dataArray['thumbnail'] = isset( $deJson['items'][0]['snippet']['thumbnails']['default']['url'] ) ? $deJson['items'][0]['snippet']['thumbnails']['default']['url'] : asset('assets/img/no-thumb.svg');

                    $dataArray['country'] = isset( $deJson['items'][0]['snippet']['country'] ) ? $deJson['items'][0]['snippet']['country'] : 0;

                    $dataArray['viewCount'] = !empty( $deJson['items'][0]['statistics']['viewCount'] ) ? $deJson['items'][0]['statistics']['viewCount'] : 0;

                    $dataArray['subscriberCount'] = !empty( $deJson['items'][0]['statistics']['subscriberCount'] ) ? $deJson['items'][0]['statistics']['subscriberCount'] : 0;

                    $dataArray['videoCount'] = !empty( $deJson['items'][0]['statistics']['videoCount'] ) ? $deJson['items'][0]['statistics']['videoCount'] : 0;

                    return $dataArray;
                
                } 
                else{

                    session()->flash('status', 'error');
                    session()->flash('message', 'No Result Found!');
                    return;
                }
            } else {
                session()->flash('status','error');
                session()->flash('message','Channel Link Invalid!');
                return ;
            }
        } 
        catch(\Exception $e)
        {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return ;
        }
    }

    public function getChannelLogo($data)
    {
        try {
            $response = curl_call($data['link'],'get',[]);
            preg_match('/"browseId":"(.*?)"/', $response, $channelId);

            if(!empty($channelId[1]))
            {
                $url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet&id='.$channelId[1].'&key=' . Config::get('constant.google_api_key');

                $source = curl_call($url,'get',[]);
                $dataArray =[];
                $deJson = json_decode($source, true);

                if( !empty( $deJson['items'][0]['snippet']['thumbnails'] ) ) {

                    $i = 0;

                    foreach ($deJson['items'][0]['snippet']['thumbnails'] as $key => $value) {

                        $token['url']      = $value['url'];
                        $token['filename'] = 'Supertool_' . $key;
                        $token['type']     = 'jpg';
                        $dlLink            = url('/') . '/downld.php?token=' . encode( json_encode($token) );

                        $dataArray[$i]['download']   = $dlLink;
                        $dataArray[$i]['preview']    = $value['url'];
                        $dataArray[$i]['resolution'] = ucfirst( $key . ' (' . $value['width'] . 'x' . $value['height'] . ')' );

                        $i++;
                    }

                    return $dataArray;
                } 
                else{

                    session()->flash('status', 'error');
                    session()->flash('message', __('No Result Found!'));
                    return;
                }
            }
        } catch (\Exception $e) {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }

    public function getChannelBanner($data)
    {
        try {
            $response = curl_call($data['link'], 'get',[]);
            preg_match('/"browseId":"(.*?)"/', $response, $channelId);

            if(!empty($channelId[1]))
            {
                $url = 'https://www.googleapis.com/youtube/v3/channels?part=brandingSettings&id='.$channelId[1].'&key=' . Config::get('constant.google_api_key');

                $source = curl_call($url, 'get',[]);

                $deJson = json_decode($source, true);
                $dataArray =[];
                if( !empty( $deJson['items'][0]['brandingSettings']['image']['bannerExternalUrl'] ) ) {

                    $token['url']      = $deJson['items'][0]['brandingSettings']['image']['bannerExternalUrl'] . '=w2120-fcrop64=1,00000000ffffffff-k-c0xffffffff-no-nd-rj';
                    $token['filename'] = 'SuperTool';
                    $token['type']     = 'jpg';
                    $dlLink            = url('/') . '/downld.php?token=' . encode( json_encode($token) );

                    $dataArray['preview']   = $deJson['items'][0]['brandingSettings']['image']['bannerExternalUrl'] . '=w2120-fcrop64=1,00000000ffffffff-k-c0xffffffff-no-nd-rj';
                    $dataArray['download']  = $dlLink;

                    return $dataArray;
                } 
                else{

                    session()->flash('status', 'error');
                    session()->flash('message', __('No Result Found!'));
                    return;
                }
            } else {
                session()->flash('status', 'error');
                session()->flash('message', __('Invalid Youtube Channel Link!'));
                return;
            }
        } catch (\Exception $e) {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }

    public function searchChannel($data)
    {
        try {
            $youtube = $this->commonYoutube();

            $value = $youtube->search->listSearch('snippet', array(
                'q'          => $data['query'],
                'type'       => 'channel',
                'regionCode' => $data['country'],
                'maxResults' => $data['result']
            ));
            $dataArray = [];

            if(!empty($value['items']))
            {
                foreach($value['items'] as $key => $value)
                {
                    $dataArray[$key]['channelId']    = isset( $value['snippet']['channelId'] ) ? $value['snippet']['channelId'] : 'None';

                    $dataArray[$key]['channelTitle'] = isset( $value['snippet']['channelTitle'] ) ? $value['snippet']['channelTitle'] : 'None';

                    $dataArray[$key]['thumbnail']    = isset( $value['snippet']['thumbnails']['default']['url'] ) ? $value['snippet']['thumbnails']['default']['url'] : asset('img/no-thumb.svg');

                    $dataArray[$key]['publishedAt']  = isset( $value['snippet']['publishedAt'] ) ? $value['snippet']['publishedAt'] : 'None';
                }
                return $dataArray;
            }
            else {
                session()->flash('status','error');
                session()->flash('message','No Result Found!');
                return ;
            }
        } catch (\Exception $e) {
            session()->flash("status",'error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }
}