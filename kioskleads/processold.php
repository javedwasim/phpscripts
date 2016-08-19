<?php
include_once('function.php');
extract(getHttpVars());
include_once("ISDK/isdk.php");
include_once("ISDK/xmlrpc-3.0/lib/xmlrpc.inc");
	$app = new iSDK;
	$ref = getenv("HTTP_REFERER"); 
	
	if(!empty($casl)){
		$casl = "Yes";
	}else{
		$casl = "No";
	}
if(!empty($register)){

		if ($app->cfgCon("ul232")) {
			$personNotes = $comments;
			
			$returnFields = array('Id','ContactNotes');
			$contacts = $app->findByEmail($email, $returnFields);
			
				if (!empty($contacts)) {
					if(isset($contacts[0]['ContactNotes']) && !empty($contacts[0]['ContactNotes'])){
						$personNotes =	$personNotes ."\n". $contacts[0]['ContactNotes'];
						
					}
				}
			$conDat = array('FirstName' => $firstname,
				'LastName' => $lastname,
				'Email' => $email,
				'Phone1' => $phone,
				'Phone2' => $cellphone,
				'Leadsource'=>$ref,
				'StreetAddress1' => $address,
				'City' => $city,
				'PostalCode' => $zip,
				'Country' => $country,
				'State'	=>$state,
				'ContactNotes' => $personNotes,
				'_Agent' => $agent,
				'_PriceRange'=>$price,
				'_Bedrooms' => $condotype,
				'_BrokerageName'=>$brokerage,
				'_PrefferedLanguage' => $language,
				'_ConsentForCASL0'	=>	$casl,
				'_Message0'=>$comments
				
			);
			
				   if (empty($contacts)) {
						$con_id = $app->dsAdd("Contact", $conDat);
						//$Optin 	= $app->optIn($email, "Subscriber");
					} else {
						$con_id = $contacts[0]['Id'];
						$result = $app->dsUpdate("Contact", $con_id, $conDat);
					}
					if (!empty($con_id)) {
						//Apply Tag
						$app->grpAssign($con_id,197); //TDC with Projects 
						$app->grpAssign($con_id,3897); //TDC with NIC-Projects
						//$app->grpAssign($con_id,3897);
						 echo '<script>window.location = "thankyou.html";</script>';	
					}
		}//end of if ($app->cfgCon("ul232")) {
}//end of main if
?>
