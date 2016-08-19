<?php
include_once('function.php');
extract(getHttpVars());
include_once("ISDK/isdk.php");
include_once("ISDK/xmlrpc-3.0/lib/xmlrpc.inc");

$app = new iSDK;
$ref = getenv("HTTP_REFERER"); 

if(isset($_POST) && !empty($_POST)){
	echo "<pre>";
	//print_r($_POST);
	echo "</pre>";
	
	if(isset($_POST['firstname'])){ $firstname =  $_POST['firstname']; }else{ $firstname = ""; }
	if(isset($_POST['lastname'])){ $lastname =  $_POST['lastname']; }else{ $lastname = ""; }
	if(isset($_POST['email'])){ $email =  $_POST['email']; }else{ $email = ""; }
	if(isset($_POST['phone'])){ $phone =  $_POST['phone']; }else{ $phone = ""; }
	if(isset($_POST['cellphone'])){ $cellphone =  $_POST['cellphone']; }else{ $cellphone = ""; }
	if(isset($_POST['timeTocontact'])){ $timeTocontact =  $_POST['timeTocontact']; }else{ $timeTocontact = ""; }
	if(isset($_POST['agent'])){ $agent =  $_POST['agent']; }else{ $agent = ""; }
	if(isset($_POST['interestinotherdevelopments'])){ $interestinotherdevelopments =  $_POST['interestinotherdevelopments']; }else{ $interestinotherdevelopments = ""; }
	if(isset($_POST['price'])){ $price =  $_POST['price']; }else{ $price = ""; }
	if(isset($_POST['comments'])){ $comments =  $_POST['comments']; }else{ $comments = ""; }
	if(isset($_POST['casl'])){ $casl =  $_POST['casl']; }else{ $casl = "No"; }
	if(isset($_POST['register'])){ $register =  $_POST['register']; }else{ $register = ""; }
	if(isset($_POST['condotype'])){ 
	//$condotype =  $_POST['condotype']; 
	$condotype = implode(",",$_POST['condotype']);
	}else{ $condotype = ""; }
	
	if(isset($_POST['floortype'])){ 
	//$condotype =  $_POST['condotype']; 
	$floortype = implode(",",$_POST['floortype']);
	}else{ $floortype = ""; }
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
				'ContactNotes' => $personNotes,
				'_Agent' => $agent,
				'_PriceRange'=>$price,
				'_Bedrooms' => $condotype,
				'_ConsentForCASL0'	=>	$casl,
				'_Message0'=>$comments,
				'_Besttimetocontact'=>$timeTocontact,
				'_Model'=>$floortype,
				//'_CopyofIDURL'=>$ref,
				
			);
			//print_r($conDat);
			//die();SCBLPKKXLHR
		   if (empty($contacts)) {
			   	$con_id = $app->addCon($conDat);
				//$Optin 	= $app->optIn($email, "Subscriber");
			} else {
				$con_id = $contacts[0]['Id'];
				$result = $app->dsUpdate("Contact", $con_id, $conDat);
			}
			if (!empty($con_id)) {
				//echo $con_id;
				if($agent == 'Yes'){
					$app->grpAssign($con_id, 717);
				}
				if($casl == 'Yes'){
					$app->grpAssign($con_id, 3911);
				}
				echo "Contact saved Successfully";
				exit();
				
			}
		}//end of if ($app->cfgCon("ul232")) {
}//end of main if

?>
