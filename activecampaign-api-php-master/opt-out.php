<?php
ini_set('max_execution_time', 300); 
require_once("ISDK/isdk.php");
$app = new iSDK;   

if (!$_REQUEST){
  die("No ContactId found!");
}
//Add App Name
if ($app->cfgCon("uk255")){
	echo "Connected<br/>";
	$contactId = $_REQUEST['contactId'];
	
	$returnGroupFields = array('Id','Email');
	$query = array('Id' => $contactId);
	$contactEmail = $app->dsQuery('Contact', 1, 0, $query, $returnGroupFields);
	//print_r($contactEmail[0]['Email']);
	
	$returnGroupFields = array('DateCreated','DateCreated','Email','Id','LastClickDate','LastOpenDate','LastSentDate','Type');
	$query = array('Email' => $contactEmail[0]['Email']);
	$contactQuery = $app->dsQuery('EmailAddStatus', 1, 0, $query, $returnGroupFields);
	
	$optOutdate =  wordwrap($contactQuery[0]['DateCreated'] , 4 , ' ' , true );
		
	
	if($contactQuery[0]['Type'] == 'Admin'){
		echo "Email Opt-out date is: "." ".$optOutdate;
	}else{
		echo "Email Opt-in date is: "." ".$optOutdate;
	}
	
	echo "<pre>";
	//print_r($contactQuery);
	echo "</pre>";
}else{
	echo "Connection not found";
}


?>