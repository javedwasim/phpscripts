       <?php
       error_reporting(-1);
     /**
       * Class to crawl a page    and extract links,images,html,words etc
       *
       *@author : Trev Tunechi [jayzantel@gmail.com]
       *
       *@URL : http://www.codia.tk
       *
       *license GNU Public license v3
       */
       
       class crawler{
       
   //Set Variables
       
       public $links,$linksfound;
       
   //Holds all found links on page and total links
       
       public $data=array(); //Details about the page including download speed,words etc
       
       public $images;//An array of all images on page
       
       public $meta=array();//Sure you know that
       
       public $domains,$url;//all domains crawled and current url
       
       public $html; //Page content with html
       
       public $clean; //Page content with no html
       
       protected $dom;
       protected $curl;
       
     /*Class constructor
       *Gets html content*/
       function __construct($url)
       
       {
       
       $this->curl=curl_init();
       curl_setopt($this->curl,CURLOPT_USERAGENT,'Codia Crawler');
       curl_setopt($this->curl,CURLOPT_FOLLOWLOCATION,false);
       
       
       curl_setopt($this->curl,CURLOPT_HEADER,false);
       curl_setopt($this->curl,CURLOPT_SSL_VERIFYPEER,false);
       curl_setopt($this->curl,CURLOPT_SSL_VERIFYHOST,false);
       curl_setopt($this->curl,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_0);
       curl_setopt($this->curl,CURLOPT_RETURNTRANSFER,true);
       curl_setopt($this->curl,CURLOPT_AUTOREFERER,TRUE);
       
       
   //Get Contents
       $this->init($url);
       }
       
     /*Get meta info
       * returns array of meta info in the form
       *meta['description']='I love this class'
       */
       
       
       function crawlMeta()
       
       {
       
     /*We have already defined the dom
       *The meta info will be an array
       */
       
       $metainfo=array();
       
       $metadata=$this->dom->getElementsByTagName('meta');
       
       foreach ($metadata as $meta)
       {
       $metainfo[$meta->getAttribute('name')]=$meta->getAttribute('content');
       
   //If there is any meta info
       }
       if (count($metainfo)>0)
       {
       $this->meta=$metainfo;
       return $metainfo;
       }
       else{
       $this->meta="No meta information";
       return false;}
       }
       
       function getLinks()
       {
       
     /*** returns an assoc array of links with url as $key and anchor text as $value ***/
       
       
       $links = array();
       
     /*** get the links from the HTML ***/
       
       $urls=$this->dom->getElementsByTagName('a');
       
       
     /*** loop over the links ***/
       
       foreach ($urls as $url)
       {
       $anchor=$url->childNodes->item(0)->nodeValue;
       $href=$url->getAttribute('href');
   //is it a relative url
       
       if(substr($href,0,4)!='http')
       {
       $href=$this->url  . $href;
       }
       $links [$href]=$anchor;
       }
       
       $this->links=$links;
       return $links;
       }
       
       function getImages()
       {
       
     /*** returns an assoc array of images with url as $key and alt text as $value ***/
       
       $images = array();
       
     /*** get the images from the HTML ***/
       
       $pics=$this->dom->getElementsByTagName('img');
       
     /*** loop over the images ***/
       
       foreach ($pics as $image)
       {
       
       $src=$image->getAttribute('src');
       
       if(substr($src,0,4)!='http')
       {
       $src=$this->url  . $src;
       }
       $images [$src]=$image->getAttribute('alt');
       }
       
       $this->images=$images;
       return $images;
       }
       
       function getmicrotime()
       {
       
       list ( $usec, $sec) = explode(" ", microtime());
       
       return  ((float)$usec + (float)$sec);
       
       }
       
     /*
       Gets the content
       *returns true or false on error
       *It initialises a new dom document
       */
       
       
       function getcontent()
       
       {
       
       if(!$this->html)
       {return false;}
       
       
   //Get the title of page
       
       $title=$this->dom->getElementsByTagName('title') ->item(0);
       
     /*** Display the first title ***/
       
       $title=$title->nodeValue;
       
       if(!$title)
       {$title="No Title";}
       
       $this->title=$title;
       
   //What is the host/domain
       
       $parse=parse_url($this->url);
       
       $domain=$parse['host'];
       $this->domains[$domain]=$domain;
       
       $this->data['domain']=$domain;
       
       $this->data['wordcount']=str_word_count("$this->clean");
       
   //Array of words
       
       $this->data['words']=str_word_count($this->clean, 1);
       
       
       $this->data['uniquewords']=count($words);
       
       return $this->data;
       
       }
       
       function followlocation($url)
       {
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_HEADER,true);curl_setopt($ch, CURLOPT_FOLLOWLOCATION,false);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
       $a = curl_exec($ch);
       if(preg_match('#Location: (.*)#', $a, $r)) $l = trim($r[1]);
       if (!empty($l))
       return $l;
       return $url;
       }
       
       function init($url)
       {
       $start=$this->getmicrotime();
       
       $this->url=$this->followlocation($url);
       
       curl_setopt( $this->curl , CURLOPT_URL , $url);
       curl_setopt( $this->curl , CURLOPT_POST , false);
       curl_setopt($this->curl , CURLOPT_HTTPGET , true);
       $this->html=curl_exec($this->curl);
       
       
       $end=$this->getmicrotime();
       
       $this->data['time']=substr($end-$start,0,6);
       
   //Remove some js
       $clean = preg_replace('#<script[^>]*>.*?</script>#is','', $this->html);
       
   //Now remove css
       
       $clean = preg_replace('#<style[^>]*>.*?</style>#is','', $clean);
       
       $this->clean=strip_tags($clean);
       
       echo $this->clean;
       
       $this->dom=@ new DOMDocument;
       
       @ $this->dom->loadHTML($this->html);
       
       }
       
       
       }