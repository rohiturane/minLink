<?php
// namespace App\Helpers;

use App\Models\PageInformation;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Melbahja\Seo\MetaTags;

if(!function_exists('curl_call'))
{

    function curl_call($url, $method, $payload=[])
    {
        $process = curl_init($url); 
        curl_setopt($process, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36'); 
        curl_setopt($process, CURLOPT_TIMEOUT, 60); 
        curl_setopt($process, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($process, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($process, CURLOPT_REFERER, 'https://www.google.com/');
        curl_setopt($process, CURLOPT_ENCODING, 'gzip');
        
        if($method=='post') 
        {
            curl_setopt($process, CURLOPT_POST, TRUE);
            curl_setopt($process, CURLOPT_POSTFIELDS, $payload);
        }
        //Begin::Proxy
        /*$proxy = Proxy::where('banned', false)->inRandomOrder()->first();
        if ( !empty($proxy) ) {
            curl_setopt($process, CURLOPT_PROXY, $proxy['ip'] . ":" . $proxy['port']);
            curl_setopt($process, CURLOPT_PROXYTYPE, $this->get_proxy_type( $proxy['type'] ));
            if (!empty($proxy['username']) && !empty($proxy['password'])) {
                curl_setopt($process, CURLOPT_PROXYUSERPWD, $proxy['username'] . ":" . $proxy['password']);
            }
            $chunkSize = 1000000;
            curl_setopt($process, CURLOPT_TIMEOUT, (int)ceil(3 * (round($chunkSize / 1048576, 2) / (1 / 8))));
        }*/
        //End::Proxy
        
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }
}

if(!function_exists('get_hash_tags'))
{
    function get_hash_tags($string) {  
        $hashtags= FALSE;  
        preg_match_all("/(#\w+)/u", $string, $matches);  
        if ($matches) {
            $hashtagsArray = array_count_values($matches[0]);
            $hashtags = array_keys($hashtagsArray);
        }
        return $hashtags;
    }
}

if(!function_exists('encode'))
{
    function encode($pData)
    {
        $encryption_key = 'earnmoneywithasset';

        $encryption_iv = '9999999999999999';

        $ciphering = "AES-256-CTR"; 
        
        $encryption = openssl_encrypt($pData, $ciphering, $encryption_key, 0, $encryption_iv);

        return $encryption;
    }
}

if(!function_exists('get_domain_name'))
{
    function get_domain_name($url) { 

        $parseUrl = parse_url(trim($url));
 
        if(isset($parseUrl['host']))
        {
            $host = $parseUrl['host'];
        }
        else
        {
             $path = explode('/', $parseUrl['path']);
             $host = $path[0];
        }
        
        $host = str_ireplace("www.", "", $host);
        
        return trim($host); 
     }
}

if(!function_exists('convert_to_age'))
{
    function convert_to_age($value){
        date_default_timezone_set('UTC');
        $time  = time() - $value;
        $years = floor($time / 31556926);
        $days  = floor(($time % 31556926) / 86400);
        if ($years == "1") {
            $y = "1 year";
        } else {
            $y = $years . " years";
        }
        if ($days == "1") {
            $d = "1 day";
        } else {
            $d = $days . " days";
        }
        return "$y, $d";
    }
}

if(!function_exists('get_index_status'))
{
    function get_index_status($url) {
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1) ;
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json; charset=UTF-8"
        )) ;

        //Begin::Proxy
        /*$proxy = Proxy::where('banned', false)->inRandomOrder()->first();
        if ( !empty($proxy) ) {
            curl_setopt($ch, CURLOPT_PROXY, $proxy['ip'] . ":" . $proxy['port']);
            curl_setopt($ch, CURLOPT_PROXYTYPE, $this->get_proxy_type( $proxy['type'] ));
            if (!empty($proxy['username']) && !empty($proxy['password'])) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy['username'] . ":" . $proxy['password']);
            }
        }*/
        //End::Proxy
        //
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return $code;
    }
}

if(!function_exists('CSVtoAssocArray'))
{
    function CSVtoAssocArray($path_file)
    {
        $importdata = [];
        $row = 1;
        if (($handle = fopen($path_file, "r")) !== FALSE) {
            $header = fgetcsv($handle);
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                //echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                $importdata[] = array_combine($header,$data);
            }
            fclose($handle);

            return $importdata;
        }
    }
}

if(!function_exists('CSVtoArray'))
{
    function CSVtoArray($path_file)
    {
        $importdata = [];
        $row = 1;
        if (($handle = fopen($path_file, "r")) !== FALSE) {
            $header = fgetcsv($handle);
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                //echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                $importdata[] = $data;
            }
            fclose($handle);

            return $importdata;
        }
    }
}

if(!function_exists('pretty_json')) 
{
    function pretty_json($json, $ret= "\n", $ind="\t") 
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
}

if(!function_exists('is_json'))
{
    function is_json($string) {
        $decoded = json_decode($string); // decode our JSON string
        if ( !is_object($decoded) && !is_array($decoded) ) {
            /*
            If our string doesn't produce an object or array
            it's invalid, so we should return false
            */
            return false;
        }
        /*
        If the following line resolves to true, then there was
        no error and our JSON is valid, so we return true.
        Otherwise it isn't, so we return false.
        */
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

if(!function_exists('minify_html'))
{
    function minify_html($input) {
        if(trim($input) === "") return $input;
        // Remove extra white-space(s) between HTML attribute(s)
        $input = preg_replace_callback('#<([^\/\s<>!]+)(?:\s+([^<>]*?)\s*|\s*)(\/?)>#s', function($matches) {
            return '<' . $matches[1] . preg_replace('#([^\s=]+)(\=([\'"]?)(.*?)\3)?(\s+|$)#s', ' $1$2', $matches[2]) . $matches[3] . '>';
        }, str_replace("\r", "", $input));
        // Minify inline CSS declaration(s)
        if(strpos($input, ' style=') !== false) {
            $input = preg_replace_callback('#<([^<]+?)\s+style=([\'"])(.*?)\2(?=[\/\s>])#s', function($matches) {
                return '<' . $matches[1] . ' style=' . $matches[2] . minify_css($matches[3]) . $matches[2];
            }, $input);
        }
        if(strpos($input, '</style>') !== false) {
        $input = preg_replace_callback('#<style(.*?)>(.*?)</style>#is', function($matches) {
            return '<style' . $matches[1] .'>'. minify_css($matches[2]) . '</style>';
        }, $input);
        }
        if(strpos($input, '</script>') !== false) {
        $input = preg_replace_callback('#<script(.*?)>(.*?)</script>#is', function($matches) {
            return '<script' . $matches[1] .'>'. minify_js($matches[2]) . '</script>';
        }, $input);
        }

        return preg_replace(
            array(
                // t = text
                // o = tag open
                // c = tag close
                // Keep important white-space(s) after self-closing HTML tag(s)
                '#<(img|input)(>| .*?>)#s',
                // Remove a line break and two or more white-space(s) between tag(s)
                '#(<!--.*?-->)|(>)(?:\n*|\s{2,})(<)|^\s*|\s*$#s',
                '#(<!--.*?-->)|(?<!\>)\s+(<\/.*?>)|(<[^\/]*?>)\s+(?!\<)#s', // t+c || o+t
                '#(<!--.*?-->)|(<[^\/]*?>)\s+(<[^\/]*?>)|(<\/.*?>)\s+(<\/.*?>)#s', // o+o || c+c
                '#(<!--.*?-->)|(<\/.*?>)\s+(\s)(?!\<)|(?<!\>)\s+(\s)(<[^\/]*?\/?>)|(<[^\/]*?\/?>)\s+(\s)(?!\<)#s', // c+t || t+o || o+t -- separated by long white-space(s)
                '#(<!--.*?-->)|(<[^\/]*?>)\s+(<\/.*?>)#s', // empty tag
                '#<(img|input)(>| .*?>)<\/\1>#s', // reset previous fix
                '#(&nbsp;)&nbsp;(?![<\s])#', // clean up ...
                '#(?<=\>)(&nbsp;)(?=\<)#', // --ibid
                // Remove HTML comment(s) except IE comment(s)
                '#\s*<!--(?!\[if\s).*?-->\s*|(?<!\>)\n+(?=\<[^!])#s'
            ),
            array(
                '<$1$2</$1>',
                '$1$2$3',
                '$1$2$3',
                '$1$2$3$4$5',
                '$1$2$3$4$5$6$7',
                '$1$2$3',
                '<$1$2',
                '$1 ',
                '$1',
                ""
            ),
        $input);
    }
}

if(!function_exists('minify_css'))
{
    // CSS Minifier => http://ideone.com/Q5USEF + improvement(s)
    function minify_css($input) {
        if(trim($input) === "") return $input;
        return preg_replace(
            array(
                // Remove comment(s)
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
                // Remove unused white-space(s)
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
                // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
                '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
                // Replace `:0 0 0 0` with `:0`
                '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
                // Replace `background-position:0` with `background-position:0 0`
                '#(background-position):0(?=[;\}])#si',
                // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
                '#(?<=[\s:,\-])0+\.(\d+)#s',
                // Minify string value
                '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
                '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
                // Minify HEX color code
                '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
                // Replace `(border|outline):none` with `(border|outline):0`
                '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
                // Remove empty selector(s)
                '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
            ),
            array(
                '$1',
                '$1$2$3$4$5$6$7',
                '$1',
                ':0',
                '$1:0 0',
                '.$1',
                '$1$3',
                '$1$2$4$5',
                '$1$2$3',
                '$1:0',
                '$1$2'
            ),
        $input);
    }
}

if(!function_exists('minify_js'))
{
    // JavaScript Minifier
    function minify_js($input) {
        if(trim($input) === "") return $input;
        return preg_replace(
            array(
                // Remove comment(s)
                '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
                // Remove white-space(s) outside the string and regex
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
                // Remove the last semicolon
                '#;+\}#',
                // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
                '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
                // --ibid. From `foo['bar']` to `foo.bar`
                '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
            ),
            array(
                '$1',
                '$1$2',
                '}',
                '$1$3',
                '$1.$3'
            ),
        $input);
    }
}

if(!function_exists('find_object'))
{
    function find_object($collection, $field)
    {
        return $collection->filter(function($item) use($field) {
            if($item->key == $field) return true;
            return false;
        });
    }
}

if(!function_exists('fetch_meta_information'))
{
    function fetch_meta_information($page_slug)
    {
        return PageInformation::where('page_slug', $page_slug)->first();
    }
}

if(!function_exists('generate_meta_information'))
{
    function generate_meta_information($page_info)
    {
        $seo = new MetaTags();

        $page_meta = $seo->title($page_info->meta_title.' | '.env('APP_NAME'))
            ->description($page_info->meta_description)
            ->meta('author', 'DevRohit')
            ->image(asset('/Super Tools.png'))
            ->canonical(url('/'));
        return $page_meta;
    }
}

if(!function_exists('get_html'))
{
    function get_html($section)
    {
        return 0;
        return Setting::where('key', $section)->first()->value;
    }
}


if(!function_exists('short_description'))
{
    function short_description($text, $limit)
    {
        return Str::words(strip_tags($text), $limit, ' ...');
    }
}


if(!function_exists('formatNumber'))
{
    function formatNumber($count, $precision = 2) {

        if ($count < 100000) {
            // Anything less than a million
            $n_format = $count;
        }
        else if ($count < 1000000) {
            // Anything less than a million
            $n_format = number_format($count / 1000) . 'K';
        } else if ($count < 1000000000) {
            // Anything less than a billion
            $n_format = number_format($count / 1000000, $precision) . 'M';
        } else {
            // At least a billion
            $n_format = number_format($count / 1000000000, $precision) . 'B';
        }
        return $n_format;
    }
}

if(!function_exists('numberToText'))
{
    function numberToText($number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees Only' : '') . $paise;
    }
}
if(!function_exists('randomString'))
{
    function randomString($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
     
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
     
        return $randomString;
    }
}
