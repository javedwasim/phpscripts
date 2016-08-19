<?php
$uri = 'http://api.us.rcmtm.com/order-api/resources/order/status/XXXC15040023';
$ch = curl_init($uri);

$pwd = md5(123456);

$headers = array();
$headers[] = 'user: TESTJJ';
$headers[] = 'pwd: '.$pwd.'';
$headers[] = 'lan: en';


define('XML_PAYLOAD', '<?xml version="1.0" encoding="UTF-16" standalone="no"?>
<data>
<ID>27</ID>
<REQ_ID>0123456789abcdefg</REQ_ID>
<ReferenceNo>29684</ReferenceNo>
<ProcessDate>02/27/12</ProcessDate>
<ProcessTime>11:18:20 AM</ProcessTime>
</data>');

$data = array("name" => "Hagrid", "age" => "36");

//print_r($headers);
curl_setopt_array($ch, array(
	CURLOPT_HTTPHEADER  => $headers,
	CURLOPT_RETURNTRANSFER  =>true,
    CURLOPT_VERBOSE     => 1,
	
));
$out = curl_exec($ch);
curl_close($ch);
// echo response output
echo "<pre>";
print_r($out);
echo "</pre>";
?>
