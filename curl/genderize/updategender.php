<?php
//ini_set('max_execution_time', 9000); 
require_once("../ISDK/isdk.php");
$app = new iSDK;   

if ($app->cfgCon("emjayoh")){
	
$all_contacts = array();        
$page = 0;
		
		
$contId = ISSET($_REQUEST['contactId'])? $_REQUEST['contactId'] :"" ;

if (empty($contId)){
	
	die("contactId value should be posted to this url! <br/>");
}
		
    $returnFields = array('FirstName','LastName','_Gender0');

    $query = array('Id' => $contId);

    $results = $app->dsQuery("Contact", 1, 0, $query, $returnFields);
	
	if(empty($results[0]['_Gender0'])){
		
		$rawData = file_get_contents("http://api.genderize.io?apikey=4e296865d870e34d6c25e8e718a1e9b9&name=".$results[0]['FirstName']);
		$parsedGender = json_decode($rawData);
		$name = $parsedGender->name;
		$gender = $parsedGender->gender;
		
		echo $gender.'<br/>'; 
		$condata = array('_Gender0' => $gender);
		$cid = $app->dsUpdate("Contact", $contId, $condata);
			
		echo "Gender Field of ".$results[0]['FirstName']. " has been updated<br/>";
	 
	}else{
		
		echo "Gender Field of ".$results[0]['FirstName']. " has already updated<br/>";
	}
   
}else{
	echo "Connection not found";
}

