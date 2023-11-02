<?php

namespace App\Services;

use Google\Client;
use Illuminate\Support\Facades\Config;
use Iodev\Whois\Factory as Whois;
use Html2Text\Html2Text;
use Faker\Provider\Lorem;

class SEOService
{

    public function googlePageSpeed($data)
    {
        try {
            $url = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?category=ACCESSIBILITY&category=PERFORMANCE&category=SEO&strategy=DESKTOP&url='.$data['link'].'&key=AIzaSyBASqF-qeK6XaieImPHY1kmWh9wr0-xG6M';
            $source = curl_call($url, 'get',[]);
            $source = json_decode($source);

            
            return $source;
        } catch (\Exception $e) {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            dd($e->getMessage());
            return;
        }
    }

    public function metaTagsAnalyzer($data, $tags)
    {
        try {
            $html = curl_call($data['link'],'get',[]);

            if(!$html) {
                session()->flash('status','error');
                session()->flash('message','Something went wrong');
                return;
            }
            $doc = new DOMDocument();
            @$doc->loadHTML($html);
            $nodes = $doc->getElementsByTagName('title');

            $ary = [];
            
            $ary['title'] = $nodes->item(0)->nodeValue;
            $metas = $doc->getElementsByTagName('meta');
            
            for ($i = 0; $i < $metas->length; $i++) {
                $meta = $metas->item($i);
                
                foreach($tags as $tag) {
                    if ($meta->getAttribute('name') == $tag) {
                        $ary[$tag] = $meta->getAttribute('content');
                    }
                }
            }
            return $ary;
        } catch(\Exception $e) {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }

    public function openGraphChecker($data, $tags)
    {
        try {
            $html = curl_call($data['link'], 'get',[]);
            if(!$html) {
                session()->flash('status','error');
                session()->flash('message','Something went wrong');
                return;
            }

            $doc = new DOMDocument();
            @$doc->loadHTML($html);
            $ary = [];
            $metas = $doc->getElementsByTagName('meta');
            
            for ($i = 0; $i < $metas->length; $i++) {
                $meta = $metas->item($i);
                
                foreach($tags as $tag) {
                    if ($meta->getAttribute('property') == $tag) {
                        $ary[$tag] = $meta->getAttribute('content');
                    }
                }
            }
            return $ary;
        } catch (\Exception $e) {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }

    public function domainLookup($data)
    {
        try {
            $domain = get_domain_name($data['link']);
            $whois = Whois::get()->createWhois();
            $dataArray =[];
            $response = $whois->loadDomainInfo($domain);
            if($response)
            {
                $dataArray['domainName']     = $response->domainName;
                $dataArray['whoisServer']    = $response->whoisServer;
                $dataArray['nameServers']    = $response->nameServers;
                $dataArray['dnssec']         = $response->dnssec;
                $dataArray['creationDate']   = ( $response->creationDate ) ? $response->creationDate : 0;
                $dataArray['expirationDate'] = ( $response->expirationDate ) ? $response->expirationDate : 0;
                $dataArray['updatedDate']    = ( $response->updatedDate ) ? $response->updatedDate : 0;
                $dataArray['owner']          = $response->owner;
                $dataArray['registrar']      = $response->registrar;
                $dataArray['states']         = $response->states;

                return $dataArray;

            } else {
                session()->flash('status','error');
                session()->flash('message','Invalid Domain Name');
                return;
            }
        } 
        catch(\Exception $e)
        {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }

    public function getDomainInfo($data)
    {
        try {
            $domain = get_domain_name($data['link']);

            $whois = Whois::get()->createWhois();

            $response = $whois->loadDomainInfo( $domain );
            $dataArray = array();
            if($response)
            {
                $dataArray['domain_name'] = $domain;
                $dataArray['age'] = convert_to_age($response->creationDate);
                $dataArray['creation_date']   = $response->creationDate ?? 0;
                $dataArray['updated_date']    = $response->updatedDate ?? 0;
                $dataArray['expiration_date'] = $response->expirationDate ?? 0;
                
                return $dataArray;
            } else {
                session()->flash('status','error');
                session()->flash('message','Invalid Domain Name');
                return;
            }
        } catch(\Exception $e)
        {
            session()->flash('status','error');
            session()->flash('message',$e->getMessage());
            return;
        } 
    }

    public function googleCacheChecker($data)
    {
        try {
            $url = 'https://webcache.googleusercontent.com/search?hl=en&gl=en&ie=UTF-8&oe=UTF-8&q=cache:' . urlencode($data['link']);

            $get_source = curl_call($url, 'get', []);

            $get_source = str_replace(',', '', $get_source);

            preg_match('/(([0-9]{1,2}||[A-Za-z]{3}) ([A-Za-z]{3}||[0-9]{1,2}) [0-9]{4}) [0-9]{2}:[0-9]{2}:[0-9]{2}/', $get_source, $match);
            $dataArray = [];
            if(!empty($match))
            {
                $dataArray['domain_name'] = $data['link'];
                $dataArray['date'] = $match[0].' GMT';
                return $dataArray;
            } else {
                session()->flash('status','error');
                session()->flash('message','No Cache Found!');
                return ;
            }
        } catch (\Exception $e) {
            session()->flash('statis','error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }

    public function keywordDensityChecker($data)
    {
        try {
            $get_source = curl_call($data['link'], 'get',[]);

            $html = new Html2Text( $get_source );

            $words = explode(" ", strtolower($html->getText()));

            $common_words = "i,he,she,it,and,me,my,you,the";
            $common_words = strtolower($common_words);
            $common_words = explode(",", $common_words);

            // Get keywords   
            $words_sum = 0;
            foreach ($words as $value) {
                $common = false;
                $value = $this->trim_replace($value);
                if (strlen($value) > 3) {
                    foreach ($common_words as $common_word) {
                        if ($common_word == $value) {
                            $common = true;
                        }
                    }
                    if (true !== $common) {
                        if (!preg_match("/http/i", $value) && !preg_match("/mailto:/i", $value)) {
                            $keywords[] = $value;
                            $words_sum++;
                        }
                    }
                }
            }

            // Do some maths and write array
            if ($keywords) {
                $keywords = array_count_values($keywords);
                arsort($keywords);
                $results = array();
                $results [] = array(
                    'total words' => $words_sum
                );
                foreach ($keywords as $key => $value) {
                    $percent = 100 / $words_sum * $value;
                    $results [] = array(
                        'keyword' => trim($key),
                        'count' => $value,
                        'percent' => round($percent, 2)
                    );
                }
            }
            else {
                return false;
            }
            $dataArray = array();

            foreach($results as $key => $value) {

                if( !empty($value['keyword']) ) {
                   
                    $value['keyword'] = trim( $value['keyword'] );
                   
                    $blackLists = array('!','"','#','$','%','&','\'','(',')','*','+',',','-','.','/',':',';','<','=','>','?','@','[','\\',']','^','_','`','{','|','}','~');
                    
                    $status = $this->contains_blacklist($value['keyword'], $blackLists);
                    
                    if ( !preg_match('/[0-9]+/', $value['keyword']) ){

                        if(!$status){
                            array_push($dataArray, array(
                                'keyword' => mb_convert_encoding($value['keyword'], "UTF-8", "auto"),
                                'count'   => $value['count'],
                                'percent' => $value['percent']
                            ));
                        }

                    }
                }
            }
            return $dataArray;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function contains_blacklist($str, array $arr)
    {
        foreach($arr as $a) {
            if (stripos($str, $a) !== false) return true;
        }
        return false;
    }

    private function trim_replace($string) {
        $string = trim($string);
        return (string) str_replace(array("\r", "\r\n", "\n"), '', $string);
    }

    public function keywordSuggestionTool($data)
    {
        try {
            $url = 'https://suggestqueries.google.com/complete/search?output=toolbar&q=' . urlencode($data['query']);

            $get_source = curl_call($url, 'get',[]);
            
            $xmlObject  = simplexml_load_string($get_source);

            $json       = json_encode($xmlObject);

            $deJson     = json_decode($json, true);

            $dataArray = array();

            if ( !empty($deJson['CompleteSuggestion'] )) {

                foreach ($deJson['CompleteSuggestion'] as $value) {

                    array_push($dataArray, array(
                        "keyword"      => $value['suggestion']['@attributes']['data']
                    ));
                }
            }
            return $dataArray;
        } catch (\Exception $e) {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }

    public function privacyPolicyGenerator($data)
    {
        try {
            $htmlString = "<h1>Privacy Policy of {COMPANY_NAME}</h1>
            
            <p>{COMPANY_NAME} operates the {SITE_URL} website, which provides the SERVICE.</p>
            
            <p>This page is used to inform website visitors regarding our policies with the collection, use, and disclosure of Personal Information if anyone decided to use our Service, the {SITE_NAME} website.</p>
            
            <p>If you choose to use our Service, then you agree to the collection and use of information in relation with this policy. The Personal Information that we collect are used for providing and improving the Service. We will not use or share your information with anyone except as described in this Privacy Policy.</p>
            
            <p>The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which is accessible at {SITE_URL}, unless otherwise defined in this Privacy Policy.</p>
            
            <h2>Information Collection and Use</h2>
            
            <p>For a better experience while using our Service, we may require you to provide us with certain personally identifiable information, including but not limited to your name, phone number, and postal address. The information that we collect will be used to contact or identify you.</p>
            
            <h2>Log Data</h2>
            
            <p>We want to inform you that whenever you visit our Service, we collect information that your browser sends to us that is called Log Data. This Log Data may include information such as your computer's Internet Protocol ('IP') address, browser version, pages of our Service that you visit, the time and date of your visit, the time spent on those pages, and other statistics.</p>
            
            <h2>Cookies</h2>
            
            <p>Cookies are files with small amount of data that is commonly used an anonymous unique identifier. These are sent to your browser from the website that you visit and are stored on your computer's hard drive.</p>
            
            <p>Our website uses these 'cookies' to collection information and to improve our Service. You have the option to either accept or refuse these cookies, and know when a cookie is being sent to your computer. If you choose to refuse our cookies, you may not be able to use some portions of our Service.</p>
            
            <h2>Service Providers</h2>
            
            <p>We may employ third-party companies and individuals due to the following reasons:</p>
            
            <ul>
                <li>To facilitate our Service;</li>
                <li>To provide the Service on our behalf;</li>
                <li>To perform Service-related services; or</li>
                <li>To assist us in analyzing how our Service is used.</li>
            </ul>
            
            <p>We want to inform our Service users that these third parties have access to your Personal Information. The reason is to perform the tasks assigned to them on our behalf. However, they are obligated not to disclose or use the information for any other purpose.</p>
            
            <h2>Security</h2>
            
            <p>We value your trust in providing us your Personal Information, thus we are striving to use commercially acceptable means of protecting it. But remember that no method of transmission over the internet, or method of electronic storage is 100% secure and reliable, and we cannot guarantee its absolute security.</p>
            
            <h2>Links to Other Sites</h2>
            
            <p>Our Service may contain links to other sites. If you click on a third-party link, you will be directed to that site. Note that these external sites are not operated by us. Therefore, we strongly advise you to review the Privacy Policy of these websites. We have no control over, and assume no responsibility for the content, privacy policies, or practices of any third-party sites or services.</p>
            
            <p>Children's Privacy</p>
            
            <p>Our Services do not address anyone under the age of 13. We do not knowingly collect personal identifiable information from children under 13. In the case we discover that a child under 13 has provided us with personal information, we immediately delete this from our servers. If you are a parent or guardian and you are aware that your child has provided us with personal information, please contact us so that we will be able to do necessary actions.</p>
            
            <h2>Changes to This Privacy Policy</h2>
            
            <p>We may update our Privacy Policy from time to time. Thus, we advise you to review this page periodically for any changes. We will notify you of any changes by posting the new Privacy Policy on this page. These changes are effective immediately, after they are posted on this page.</p>
            
            <p>Our Privacy Policy was created with the help of the <a href='{PRIVACY_URL}'>Privacy Policy Template</a>.</p>
            
            <h2>Contact Us</h2>
            
            <p>If you have any questions or suggestions about our Privacy Policy, do not hesitate to contact us.</p>";
            
            $htmlString = str_replace('{COMPANY_NAME}', $data['company_name'], $htmlString);
            $htmlString = str_replace('{SITE_URL}', $data['site_url'], $htmlString);
            $htmlString = str_replace('{SITE_NAME}', $data['site_name'], $htmlString);
            $htmlString = str_replace('{PRIVACY_URL}', url('/privacy-policy-generator'), $htmlString);

            return $htmlString;
        } catch (\Exception $e) {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }

    public function termsOfServiceGenerator($data)
    {
        try {
            $htmlString = "<h1>Website Terms and Conditions of Use</h1>

            <h2>1. Terms</h2>
            
            <p>By accessing this Website, accessible from {SITE_URL}, you are agreeing to be bound by these Website Terms and Conditions of Use and agree that you are responsible for the agreement with any applicable local laws. If you disagree with any of these terms, you are prohibited from accessing this site. The materials contained in this Website are protected by copyright and trade mark law.</p>
            
            <h2>2. Use License</h2>
            
            <p>Permission is granted to temporarily download one copy of the materials on {COMPANY_NAME}'s Website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>
            
            <ul>
                <li>modify or copy the materials;</li>
                <li>use the materials for any commercial purpose or for any public display;</li>
                <li>attempt to reverse engineer any software contained on {COMPANY_NAME}'s Website;</li>
                <li>remove any copyright or other proprietary notations from the materials; or</li>
                <li>transferring the materials to another person or 'mirror' the materials on any other server.</li>
            </ul>
            
            <p>This will let {COMPANY_NAME} to terminate upon violations of any of these restrictions. Upon termination, your viewing right will also be terminated and you should destroy any downloaded materials in your possession whether it is printed or electronic format. These Terms of Service has been created with the help of the <a href='{TERMS_URL}'>Terms Of Service Generator</a>.</p>
            
            <h2>3. Disclaimer</h2>
            
            <p>All the materials on {COMPANY_NAME}'s Website are provided 'as is'. {COMPANY_NAME} makes no warranties, may it be expressed or implied, therefore negates all other warranties. Furthermore, {COMPANY_NAME} does not make any representations concerning the accuracy or reliability of the use of the materials on its Website or otherwise relating to such materials or any sites linked to this Website.</p>
            
            <h2>4. Limitations</h2>
            
            <p>{COMPANY_NAME} or its suppliers will not be hold accountable for any damages that will arise with the use or inability to use the materials on {COMPANY_NAME}'s Website, even if {COMPANY_NAME} or an authorize representative of this Website has been notified, orally or written, of the possibility of such damage. Some jurisdiction does not allow limitations on implied warranties or limitations of liability for incidental damages, these limitations may not apply to you.</p>
            
            <h2>5. Revisions and Errata</h2>
            
            <p>The materials appearing on {COMPANY_NAME}'s Website may include technical, typographical, or photographic errors. {COMPANY_NAME} will not promise that any of the materials in this Website are accurate, complete, or current. {COMPANY_NAME} may change the materials contained on its Website at any time without notice. {COMPANY_NAME} does not make any commitment to update the materials.</p>
            
            <h2>6. Links</h2>
            
            <p>{COMPANY_NAME} has not reviewed all of the sites linked to its Website and is not responsible for the contents of any such linked site. The presence of any link does not imply endorsement by {COMPANY_NAME} of the site. The use of any linked website is at the user's own risk.</p>
            
            <h2>7. Site Terms of Use Modifications</h2>
            
            <p>{COMPANY_NAME} may revise these Terms of Use for its Website at any time without prior notice. By using this Website, you are agreeing to be bound by the current version of these Terms and Conditions of Use.</p>
            
            <h2>8. Your Privacy</h2>
            
            <p>Please read our Privacy Policy.</p>
            
            <h2>9. Governing Law</h2>
            
            <p>Any claim related to {COMPANY_NAME}'s Website shall be governed by the laws of in without regards to its conflict of law provisions.</p>";

            $htmlString = str_replace('{COMPANY_NAME}', $data['company_name'], $htmlString);
            $htmlString = str_replace('{SITE_URL}', $data['site_url'], $htmlString);
            $htmlString = str_replace('{SITE_NAME}', $data['site_name'], $htmlString);
            $htmlString = str_replace('{TERMS_URL}', url('/terms-of-service-generator'), $htmlString);

            return $htmlString;
        } catch (\Exception $e) {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }

    public function loremIpsumGenerator($data)
    {
        try{
            $result = [];
            if($data['type'] == 'words')
            {
                $result = Lorem::words($data['count']);
            }
            else if($data['type'] == 'sentences')
            {
                $result = Lorem::sentences($data['count']);
            }
            else {
                $result = Lorem::paragraphs($data['count']);
            }
            return $result;
        } 
        catch(\Exception $e)
        {
            session()->flash('status','error');
            session()->flash('message', $e->getMessage());
            return;
        }
    }

}