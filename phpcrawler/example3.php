<!DOCTYPE html>
<html>
<head>
<title>Simple Source Code Viewer</title>
</head>
<body>
<?php 

/*Package search engine crawler
*
*author Trev Tune */

include 'crawler.class.php';

$crawler=new crawler("http://demo.woothemes.com/storefront/");

$html=$crawler->html;
 
highlight_string($html);
?>
</body>
</html>