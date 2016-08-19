<?php
ini_set('max_execution_time', 1800); 

echo "Connecting to infusionsoft.......... <br/>";
require_once("ISDK/isdk.php");
$app = new iSDK;
// Test Connnection
if ($app->cfgCon("kq272")){
	
	echo "Yabba Dabba Doo! You Are Connected To Infusionsoft!!!!!";
	
	$condata = array(
						"FirstName" => 'test03',
						"LastName" => 'test03',
						"Phone1" => '03314716888',
						"City" => 'test',
						"StreetAddress1" =>'test',
						"PostalCode" => 'test',
						"Country"=>'test',
						"State"=>'test',
						"Email"=>'test03@test.com',
						"_BirthCountry"=>'test',
						'_cityofbirth'=>'test'
					
					); 
	//echo $conID = $app->addCon($condata);
	
	$qry = array('Email' => 'test03@test.com');
	$ret = array('Id','Email','FirstName','LastName','_Birth_Country');
	$contacts = $app->dsQuery("Contact", 1, 0, $qry, $ret);
	
	$id = !empty($contacts[0]['Id']) ? $contacts[0]['Id'] : 0;
	$FirstName = !empty($contacts[0]['FirstName']) ? $contacts[0]['FirstName'] : 0;
	$LastName = !empty($contacts[0]['LastName']) ? $contacts[0]['LastName'] : 0;
	$Email = !empty($contacts[0]['Email']) ? $contacts[0]['Email'] : 0;
	$BirthCountry = !empty($contacts[0]['_Birth_Country']) ? $contacts[0]['_Birth_Country'] : 0;

	
	echo "here";
	echo "<br/>Contact FirstName:".$FirstName;
	echo "<br/>Contact LastName:".$LastName;
	echo "<br/>Contact Email:".$Email;
	echo "<br/>Birth Country:".$BirthCountry;


	
}
// Token data hidden on your server
$_WSTOKEN = '1416E478-A8F4-48AA-A14CCC150ACA01B3';
$_APITOKEN = '3CC99231-4EFC-46E9-8C5D03D17E86C48B';

// Set dynamic data here, could be from settings or a form etc.
echo $Email;
$service_url = 'https://admin.axcelerate.com.au/api/contacts/?emailAddress='.$Email;
$ch = curl_init($service_url);

$headers = array();
$headers[] = 'wstoken: '.$_WSTOKEN;
$headers[] = 'apitoken: '.$_APITOKEN;

//print_r($headers);
curl_setopt_array($ch, array(
	CURLOPT_RETURNTRANSFER=>true,
	CURLOPT_HTTPHEADER  => $headers,
	CURLOPT_POST=>false,
));

$out = curl_exec($ch);
curl_close($ch);
// echo response output
$json = json_decode($out, true);

echo "<pre>";
$contact_exist = $json[0]['EMAILADDRESS'];

if(!empty($contact_exist)){
	echo "Contact Exist<br/>";
	print_r($json[0]['EMAILADDRESS']);
}else{
	print_r($json);
}

echo "</pre>";


//==============Create New Contact========================//
if(empty($contact_exist)){
	
	$service_url = 'https://admin.axcelerate.com.au/api/contact/';
	$ch = curl_init($service_url);
	
	$data = array(
					"givenName" => $FirstName,
					"surname" => $LastName,
					"emailAddress" => $Email,
					"dob"=>"10/12/1984",
					"CountryofBirthID"=>$BirthCountry,
					"CityofBirth"=>$cityofbirth,
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
	echo "Contact Created Successfully";
	print_r($out);
	echo "</pre>";	
	
	
}

?>
