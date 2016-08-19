<?php
// Token data hidden on your server
$_WSTOKEN = '1416E478-A8F4-48AA-A14CCC150ACA01B3';
$_APITOKEN = '3CC99231-4EFC-46E9-8C5D03D17E86C48B';
 
// Set dynamic data here, could be from settings or a form etc.
$contactid = '3056110';
 
// Note for GET requests, all parameters are set in the URL
$service_url = 'https://admin.axcelerate.com.au/api/contact/'.$contactid;
$headers = array(
    'wstoken: '.$_WSTOKEN, 
    'apitoken: '.$_APITOKEN
);
 
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
 
// Call API
$curl_response = curl_exec($curl);
 echo "<pre>";
 print_r($curl_response);
// Error handling etc.. see the link above

$service_url = 'https://admin.axcelerate.com.au/api/contacts/';
$ch = curl_init($service_url);

$headers = array();
$headers[] = 'wstoken: '.$_WSTOKEN;
$headers[] = 'apitoken: '.$_APITOKEN;


$data = array("emailAddress" => "khurram@gmail.com");                                                                    
$data_string = json_encode($data);  

//print_r($headers);
curl_setopt_array($ch, array(
	CURLOPT_HTTPHEADER  => $headers,
	CURLOPT_RETURNTRANSFER  =>true,
    CURLOPT_VERBOSE     => 1,
	CURLOPT_CUSTOMREQUEST => 'GET'
	CURLOPT_POSTFIELDS => $data_string,
));
$out = curl_exec($ch);
curl_close($ch);
// echo response output
echo "<pre>";
print_r($out);
echo "</pre>";
?>
