<!DOCTYPE HTML>
<html lang="en"> 
	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
    <title>Test</title>
    </head>
    <body>

<?php
include_once "domparser/Domparser.class.php";
require_once "support/functions.php";
require_once("tables/table2arr.php");

$obj=new Domparser("http://localhost/phpscripts/htmltheme/scraper/testfile.php");

/* echo "Page title:";
echo '<pre>'.$obj->getTitle().'</pre>';

echo "All Images:";
echo '<pre>'.print_r($obj->getImages(),true).'</pre>';

echo "All links:";
echo '<pre>'.print_r($obj->getLinks(),true).'</pre>';

echo "Internal links:";

echo '<pre>'.print_r($obj->getInternalinks(),true).'</pre>';

echo "Extrenal links:";

echo '<pre>'.print_r($obj->getExternalinks(),true).'</pre>';

echo "Get div tag by id header:<br/>";
echo "<pre>";
echo htmlspecialchars($obj->getElementbyid("header"));
echo "</pre>";


echo "Get div tag by id table:<br/>";
echo "<pre>";
echo $data = htmlspecialchars($obj->getElementbyid("statsTable"));
echo "</pre>"; */

$data = ($obj->getElementbyid("all"));

$filename = 'testfile.php';
if (file_exists($filename)){
	
	if (!unlink($filename)){
		echo ("Error deleting $filename");
	}
}

exit();

print "</pre>";
parsehtmltable_intomysql($data);
print "</pre>";

?>
</body>
</html>