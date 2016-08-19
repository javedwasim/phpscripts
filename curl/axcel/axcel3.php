<?php
require_once("ISDK/isdk.php");
ini_set('max_execution_time', 1800); 

$contactId = $_REQUEST['contactId'];
if(empty($contactId)){
	echo "Please enter valid contactId";
	die();
}
echo "Connecting to infusionsoft.......... <br/>";

$app = new iSDK;
// Test Connnection
if ($app->cfgCon("kq272")){

	$qry = array('Id' =>$contactId );
	$ret = array('Id','Email','FirstName','LastName','_AustralianCitizen','_USI');
	$contacts = $app->dsQuery("Contact", 1, 0, $qry, $ret);
	
	$id = !empty($contacts[0]['Id']) ? $contacts[0]['Id'] : 0;
	$FirstName = !empty($contacts[0]['FirstName']) ? $contacts[0]['FirstName'] : 0;
	$LastName = !empty($contacts[0]['LastName']) ? $contacts[0]['LastName'] : 0;
	$Email = !empty($contacts[0]['Email']) ? $contacts[0]['Email'] : 0;
	
	$AustralianCitizen = !empty($contacts[0]['_AustralianCitizen']) ? $contacts[0]['_AustralianCitizen'] : '';
	$USI = !empty($contacts[0]['_USI']) ? $contacts[0]['_USI'] : '';

	echo "<br/>Contact FirstName:".$FirstName;
	echo "<br/>Contact LastName:".$LastName;
	echo "<br/>Contact Email:".$Email;
	echo "<br/>USI:".$USI;
	echo "<br/>Citizen StatusID:".$AustralianCitizen;
	
		
	}
	// Token data hidden on your server   (jwanjum)  301423 AxAPIResponse
	$_WSTOKEN = '1416E478-A8F4-48AA-A14CCC150ACA01B3';
	$_APITOKEN = '3CC99231-4EFC-46E9-8C5D03D17E86C48B';

	// Set dynamic data here, could be from settings or a form etc.
	
	$service_url = 'https://admin.axcelerate.com.au/api/contacts/?emailAddress='.$Email."&givenName=".$FirstName."&surname=".$LastName;
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
	$axcelContacts = json_decode($out, true);

	echo "<pre>";
	//print_r($axcelContacts);
	
	//===============Create or update Contact in Axcel===========================//
	$contact_exist = $axcelContacts[0]['EMAILADDRESS'];
	$searchContacts = array();
	
	$index = 0;
	$data = array();
	if(!empty($contact_exist)){
				
		if((!empty($AustralianCitizen))){
			$data['CitizenStatusID'] = $AustralianCitizen;
		}else{
			$condata = array(
				"_AxAPIResponse" =>'Please Provide Valid Citizen Status Id.',
				
			);
			$app->dsUpdate("Contact", $_REQUEST['contactId'], $condata);
			$app->achieveGoal('kq272', 'errorgoal' , $_REQUEST['contactId']);
			echo "<h4>Error: Please Provide Valid Citizen StatusID.</h4>";
			die();
			
                }
		
		if((!empty($USI))){
			$data['USI'] = $USI;
		}else{
			$condata = array(
				"_AxAPIResponse" =>'Please Provide Valid USI Id.',
				
			);
			$app->dsUpdate("Contact", $_REQUEST['contactId'], $condata);
			$app->achieveGoal('kq272', 'errorgoal' , $_REQUEST['contactId']);
			echo "<h4>Error: Please Provide Valid USIID.</h4>";
			die();
			
                }
		
		$AxcelerateContactId = $axcelContacts[0]['CONTACTID'];
		
		$service_url = 'https://admin.axcelerate.com.au/api/contact/'.$AxcelerateContactId;
		$ch = curl_init($service_url);
				
		//print_r($headers);
		curl_setopt_array($ch, array(
			CURLOPT_HTTPHEADER  => $headers,
			CURLOPT_CUSTOMREQUEST=>"PUT",
			CURLOPT_RETURNTRANSFER  =>true,
			CURLOPT_POSTFIELDS => $data
		));

		$out = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($out, true);
	
                
                if(!empty($result['DETAILS'])){
                    echo "<pre>";
                    echo "<h4>Error: ".$result['DETAILS']."</h4>";
                    echo "</pre>";
                    $condata = array("_AxAPIResponse" =>$result['DETAILS']);
                    $app->dsUpdate("Contact", $_REQUEST['contactId'], $condata);
                    $app->achieveGoal('kq272', 'errorgoal' , $_REQUEST['contactId']);
                    die();
                }else{
                    echo "record updated successfully";
                }
		
		
	}else{
                $condata = array(
                        "_AxAPIResponse" =>'Contact Not Found with provided id.',

                );
                $app->dsUpdate("Contact", $_REQUEST['contactId'], $condata);
                $app->achieveGoal('kq272', 'errorgoal' , $_REQUEST['contactId']);
		echo "<h4>Error: Contact Not Found with provided id.</h4>";
                die();
			
	}
	
?>

