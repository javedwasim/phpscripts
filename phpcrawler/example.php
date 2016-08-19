<!Doctype html>
<html>
<head>
<title>My crawler</title>
</head>
<body>

<?php 

//error_reporting(-1);

/*Example link crawler
*@package :Simple crawler
*author : Trev Tune
*/

include 'crawler.class.php';

 /* @seenlinks
*
*A multidimentional array of all crawled links
*
*e.g print_r($seenlinks) may produce
array(
  [domain]=>array( [link1]=>link;
)
*/


$url='http://demo.woothemes.com/storefront/'; //trim($_GET['url']);

$seenlinks=array();


crawl($url,2);


function crawl($url,$depth=2,$singledomain=false)
{

$domain=host($url);

global $seenlinks;

//Have we crawled into the specified depth

if ($depth==0)
 return;

//Have we crawled this url

if(isset($seenlinks[$domain][$url]))
return;

$crawler=new crawler($url);

if(!$crawler)
return;

//$crawler->getLinks();

//Add to array


$seenlinks[$domain][$url]=$url;

$links=$crawler->getLinks();


foreach($links as $link=>$a)

{

//Does user want to crawl only a specific domain

if($singledomain) 
{
if($domain=!host($link))
break;}


crawl($link,$depth-1,$singledomain);}
}

function host($url)
{
/*
$host = parse_url($url);
$host = $host['host'];
*/

$host = str_ireplace('www.','', parse_url($url, PHP_URL_HOST));

return $host;
}

if(count($seenlinks)==0)
{die("No links found for $url");}

echo "

<div class='crawler'>
Domains/subdomains found = " . count($seenlinks) . "<br/>";


foreach($seenlinks as $domain=>$links){

echo "<br/> Domain ".$domain. " has "  . count($links) . "links <br>";

foreach($links as $link){
{
echo " <br/>  $link <br/>";

}

echo "<hr/>";
}

echo "<hr/>";
}

?>

</div>
</body>
</html>