<?php
ini_set('max_execution_time', 9000); 
require_once("ISDK/isdk.php");
$app = new iSDK;  
//$string = "contact[email]";
//echo $new_str = str_replace(str_split('\\/:[]*?"<>|'), '', $string);
if ($app->cfgCon("uk255")){
	if(isset($_REQUEST['contactemail'])){
		echo $email = $_REQUEST['contactemail'];
		$app->optOut($email,"Email Subscriber");
	}
}else{
	echo "Connection not found";
}

