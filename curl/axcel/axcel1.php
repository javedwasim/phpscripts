<?php
// Token data hidden on your server
$_WSTOKEN = '1416E478-A8F4-48AA-A14CCC150ACA01B3';
$_APITOKEN = '3CC99231-4EFC-46E9-8C5D03D17E86C48B';

// Set dynamic data here, could be from settings or a form etc.
$contactid = '3056110';

$service_url = 'https://admin.axcelerate.com.au/api/contact/';
$ch = curl_init($service_url);

$headers = array();
$headers[] = 'wstoken: '.$_WSTOKEN;
$headers[] = 'apitoken: '.$_APITOKEN;

$data = array(
"givenName" => "test02",
"surname" => "test02",
"emailAddress" => "test02@test.com",
);                                                                    
$data_string = json_encode($data);  

//print_r($headers);
curl_setopt_array($ch, array(
	CURLOPT_HTTPHEADER  => $headers,
	CURLOPT_POST=>true,
	CURLOPT_RETURNTRANSFER  =>true,
	CURLOPT_POSTFIELDS => $data
));

$out = curl_exec($ch);
curl_close($ch);
// echo response output
echo "<pre>";
echo "here";
print_r($out);
echo "</pre>";



?>
