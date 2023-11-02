<?php
namespace App\Libraries;

use App\Libraries\CSSMinify;
use App\Libraries\JavaScriptMinify;

abstract class MinificationSequenceFinder
{
    public $start_idx;
    public $end_idx;
    public $type;
    abstract protected function findFirstValue($string);
    public function isValid(){
        return $this->start_idx !== false;
    }
} 

class StringSequenceFinder extends MinificationSequenceFinder
{
    protected $start_delimiter;
    protected $end_delimiter;
    function __construct($start_delimiter, $end_delimiter){
        $this->type = $start_delimiter;
        $this->start_delimiter = $start_delimiter;
        $this->end_delimiter = $end_delimiter;
    }
    public function findFirstValue($string){
        $this->start_idx = strpos($string, $this->start_delimiter);
        if ($this->isValid()){
            $this->end_idx = strpos($string, $this->end_delimiter, $this->start_idx+1);
            // sanity check for non well formed lines
            $this->end_idx = ($this->end_idx === false ? strlen($string) : $this->end_idx +
            strlen($this->end_delimiter));
        }
    }
}

class QuoteSequenceFinder extends MinificationSequenceFinder
{
    function __construct($type){
        $this->type = $type;
    }
    public function findFirstValue($string){
        $this->start_idx = strpos($string, $this->type);
        if ($this->isValid()){
            // look for first non escaped endquote
            $this->end_idx = $this->start_idx+1;
            while ($this->end_idx < strlen($string)){
            // find number of escapes before endquote
                if (preg_match('/(\\\\*)(' . preg_quote($this->type) . ')/', $string,
                $match, PREG_OFFSET_CAPTURE, $this->end_idx)){
                    $this->end_idx = $match[2][1] + 1;
                    // if odd number of escapes before endquote, endquote is escaped. Keep going
                    if (!isset($match[1][0]) || strlen($match[1][0]) % 2 == 0){
                        return;
                    }
                } else {
                    // no match, not well formed
                    $this->end_idx = strlen($string);
                    return;
                }
            }
        }
    }
}

class RegexSequenceFinder extends MinificationSequenceFinder
{
    protected $regex;
    public $sub_match;
    public $sub_start_idx;
    public $start_idx = false;
    public $full_match;
    public $end_idx;

    function __construct($type, $regex){
        $this->type = $type;
        $this->regex = $regex;
    }
    public function findFirstValue($string){
        preg_match($this->regex, $string, $matches, PREG_OFFSET_CAPTURE);
        if (count($matches) == 0){
            $this->start_idx = false;
            return false;
        }
        // full match
        $this->full_match = $matches[0][0];
        $this->start_idx = $matches[0][1];
        if (count($matches) > 1){
            // substart
            $this->sub_match = $matches[1][0];
            $this->sub_start_idx = $matches[1][1];
        }
        $this->end_idx = $this->start_idx + strlen($this->full_match);
    }
}


class HTMLMinify
{
    protected $minificationStore;
    protected $singleQuoteSequenceFinder;
    protected $doubleQuoteSequenceFinder;
    protected $javascript;
    protected $css;

    public function __construct()
    {
        $this->minificationStore = [];
        $this->javascript = new JavaScriptMinify();
        $this->css = new CSSMinify();
    }

    function preserveEmeddedPHP($string)
    {
        $start_idx = strpos($string, '<?'); //matches both <? and <?php
        if (strlen($string)==0){ return $string; }
        if ($start_idx !== false){
            //need to find first end terminator not in quote
            $php_len = 2;
            while (true){
            // start looking for the PHP terminator from the PHP start
                $tmp_string = substr($string, $start_idx + $php_len);
                $end_php = strpos($tmp_string, '?>');
                $end_php = ($end_php !== false ? $end_php+2 : strlen($tmp_string));
                // find the closest string
                $quote_start = false;
                $this->singleQuoteSequenceFinder->findFirstValue($tmp_string);
                $this->doubleQuoteSequenceFinder->findFirstValue($tmp_string);
                if ($this->singleQuoteSequenceFinder->isValid() &&
                (!$this->doubleQuoteSequenceFinder->isValid() || $this->singleQuoteSequenceFinder->start_idx <
                $this->doubleQuoteSequenceFinder->start_idx)){
                    $quote_start = $this->singleQuoteSequenceFinder->start_idx;
                    $quote_end = $this->singleQuoteSequenceFinder->end_idx;
                } else if ($this->doubleQuoteSequenceFinder->isValid()){
                    $quote_start = $this->doubleQuoteSequenceFinder->start_idx;
                    $quote_end = $this->doubleQuoteSequenceFinder->end_idx;
                }
                // check if end terminator before string declared. If not, start search again after the string declared
                if ($quote_start === false || $end_php <= $quote_start){
                    $php_len += $end_php;
                    break;
                } else{
                    $php_len += $quote_end;
                }
            }
            // store the found PHP
            $php_substr = substr($string, $start_idx, $php_len);
            $placeHolder = $this->getNextMinificationPlaceholder();
            $newstring = substr($string, 0, $start_idx) . $placeHolder . substr($string,
            $start_idx+$php_len);
            $this->minificationStore[$placeHolder] = $php_substr;
            // search for next emedded PHP to preserve
            return $this->preserveEmeddedPHP($newstring);
        }
        return $string;
    }

    function getNextMinificationPlaceholder(){
        return '<-!!-' . count($this->minificationStore) . '-!!->';
    }

    public function getNextSpecialSequence($string, $sequences){
        // $special_idx is an array of the nearest index for all special characters
        $special_idx = array();
        foreach ($sequences as $finder){
            $finder->findFirstValue($string);
            if ($finder->isValid()){
                $special_idx[$finder->start_idx] = $finder;
            }
        }
        // if none found, return
        if (count($special_idx) == 0){ return false; }
        // get first occuring item
        asort($special_idx);
        return $special_idx[min(array_keys($special_idx))];
    }
    function minifyPHP($html)
    {
        $html_special_chars = array(
            new RegexSequenceFinder('javascript', "/<\s*script(?:[^>]*)>(.*?)<\s*\/script\s*>/si"),
            // javascript, can have type attribute
            new RegexSequenceFinder('css', "/<\s*style(?:[^>]*)>(.*?)<\s*\/style\s*>/si"),
            // css, can have type/media attribute
            new RegexSequenceFinder('pre', "/<\s*pre(?:[^>]*)>(.*?)<\s*\/pre\s*>/si") // pre
        );
        $html = $this->preserveEmeddedPHP($html);
        // pull out everything that needs to be pulled out and saved
        while ($sequence = $this->getNextSpecialSequence($html, $html_special_chars)){
            $placeholder = $this->getNextMinificationPlaceholder();
            $quote = substr($html, $sequence->start_idx, $sequence->end_idx - $sequence->start_idx);
            // subsequence (css/javascript/pre) needs special handeling, tags can still be minimized using minifyPHP
            $sub_start = $sequence->sub_start_idx- $sequence->start_idx;
            $sub_end = $sub_start + strlen($sequence->sub_match);
            switch ($sequence->type){
                case 'javascript':
                $quote = $this->minifyPHP(substr($quote, 0, $sub_start)) . $this->javascript->minifyJavascript(
                $sequence->sub_match) . $this->minifyPHP(substr($quote, $sub_end));
                break;
                case 'css':
                $quote = $this->minifyPHP(substr($quote, 0, $sub_start)) . $this->css->minifyCSS(
                $sequence->sub_match) . $this->minifyPHP(substr($quote, $sub_end));
                break;
                default: // strings that need to be preservered, e.g. between <pre> tags
                $quote = $this->minifyPHP(substr($quote, 0, $sub_start)) . $sequence->sub_match .
                $this->minifyPHP(substr($quote, $sub_end));
            }   
            $this->minificationStore[$placeholder] = $quote;
            $html = substr($html, 0, $sequence->start_idx) . $placeholder . substr($html,
            $sequence->end_idx);
        }
        // condense white space
        $html = preg_replace(
        array('/\s+/', '/<\s+/', '/\s+>/'),
        array(' ', '<', '>'),
        $html);
        // remove comments
        $html = preg_replace('/<!--([^-](?!(->)))*-->/', '', $html);
        // put back the preserved strings
        foreach($this->minificationStore as $placeholder => $original){
            $html = str_replace($placeholder, $original, $html);
        }
        return trim($html);
    }
}