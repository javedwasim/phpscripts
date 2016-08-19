<?php
ini_set('max_execution_time', 9000); 
require_once("ISDK/isdk.php");
$app = new iSDK;   

if (!$_REQUEST){
  die("No Posted value found!");
}

$data = $_REQUEST;
$email = $data['contact']['email'];
$tagname = $data['contact']['tags'];

if ($app->cfgCon("uk255")){
	echo "connected<br/>";
	
	$returnGroupFields = array('Id');
	$query = array('Email' => $email);
	
	//get contact id.
	$contactQuery = $app->dsQuery('Contact', 1, 0, $query, $returnGroupFields);
	$contactid = $contactQuery[0]["Id"];
	echo "<br/>";
	
	//check if tag exist and get tagid to be applied.
	$returnGroupFields = array('Id', 'GroupName');
	$query = array('GroupName' => $tagname);
	$tagExist = $app->dsQuery('ContactGroup', 1, 0, $query, $returnGroupFields);
	
	if(empty($tagExist)){
		//create new tag and add to ContactGroup database table
		$newTagData = array('GroupName' => $tagname); 
		$tagId = $app->dsAdd('ContactGroup',$newTagData); 
		$app->grpAssign($contactid, $tagId);
		echo "Tag Id ".$tagId. " has been created successfully.";
	}else{
		$tagid = ($tagExist[0]['Id']);
		$app->grpAssign($contactid, $tagid);
		echo "Tag has applied.<br/>";
	}
	
}else{
	echo "Connection not found";
}

