<?php
//======================================Create Account=====================================================
/* $data = array(
	'account_name' =>'rine_t@ip6.pp.ua',
	'first_name' =>'Free',
	'last_name' =>'Subscriber',
	
);
$data = json_encode( $data);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/accounts/create');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "8c5dfa6766:Kk3cA3Dm8kR8");
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
	'Content-Type: application/json', 		
	'Content-Length: ' . strlen($data))                                                                       
);   	
$output = curl_exec($ch);
$info = curl_getinfo($ch);
	
if ($info['http_code'] != 204) {
	print("<br/>Error creating account<br/><br/>");
	print_r($output);
	print_r($info);
	die();
} */
//echo "Sub-Account Created<br/><br/>";
//die();
//======================================Create Site=====================================================

$website = isset($_REQUEST['website'])?$_REQUEST['website']:"";
//echo $website; die();
//$website = "google.com";
$website = addhttp($website);


$data = '
	{	
	"site_data":
		{						
			"original_site_url":"123456789"
		}
	}
';


$data = str_replace("123456789",$website,$data);

//var_dump($data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/sites/create');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "8c5dfa6766:Kk3cA3Dm8kR8");
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
	'Content-Type: application/json', 		
	'Content-Length: ' . strlen($data))                                                                       
);   	
$output = curl_exec($ch);
$info = curl_getinfo($ch);


if ($info['http_code'] != 200) {
	print(".<br/>Error creating site.<br/><br/>");
	$output = json_decode($output);
	if($output->error_code=="InvalidInput"){
		$output->message;
		
	}
	echo "unable to create site.".$output->message;
	die();
	
}

//======================================Grant Access=====================================================
$output = json_decode($output, true);
$siteName = $output['site_name']; 
	
function addhttp($url) {
if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
	$url = "http://" . $url;
}
return $url;
}
	
$data = '';
$accountName = 'rine_t@ip6.pp.ua';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/accounts/grant-access/'.$accountName.'/sites/'.$siteName);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "8c5dfa6766:Kk3cA3Dm8kR8");
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
	'Content-Type: application/json', 		
	'Content-Length: ' . strlen($data))                                                                       
);   
$output = curl_exec($ch);
$info = curl_getinfo($ch);
//print_r($info);
if ($info['http_code'] != 204) {
	print("<br/>Error granting access to site<br/><br/>");
	print_r($output);
	print_r($info);
	die();
}
curl_close($ch);

//Set editor custom domain
$ssoEndpoint = 'm.1mobil-e.com';
//Set SSO Parameters
$dm_sig_site = $siteName;
$dm_sig_user = $accountName;
$dm_sig_key = '60a279';
$dm_sig_timestamp = time();
$secret_key = '64c39529d00c8760415659350cf32f50';
//Concatenate sso strings so it can be encrypted
$dm_sig_string = $secret_key.'user='.$dm_sig_user.'timestamp='.$dm_sig_timestamp.'site='.$dm_sig_site.'partner_key='.$dm_sig_key;
//Encrypt values
$dm_sig = hash_hmac('sha1', $dm_sig_string, $secret_key);
//Create SSO link
$sso_link = 'http://'.$ssoEndpoint.'/home/site/'.$dm_sig_site.'?dm_sig_partner_key='.$dm_sig_key.'&dm_sig_timestamp='.$dm_sig_timestamp.'&dm_sig_user='.$dm_sig_user.'&dm_sig_site='.$dm_sig_site.'&dm_sig='.$dm_sig;	
//Print SSO link
//echo "This is the SSO link:".$sso_link;
//echo "<br/><br/></br>";
header('Location:'.$sso_link);
die();
