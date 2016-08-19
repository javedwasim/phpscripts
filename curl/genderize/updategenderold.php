<?php
ini_set('max_execution_time', 9000); 
require_once("includes/ISDK/isdk.php");
$app = new iSDK;   

if ($app->cfgCon("uk255"))
{
$all_contacts = array();        
$page = 0;
		
$returnFields = array('Id','FirstName','LastName');
$query = array('Email' => '%');

while(true)
{
	$results = $app->dsQuery("Contact", 1000, $page, $query, $returnFields);
				
	$all_contacts = array_merge($all_contacts, $results);
	
	if(count($results) < 1000)
	{
		break;
	}

	$page++;
}

$query = array('Email' => '%');
$contact_updated = $app->dsCount("Contact", $query);

$query =  array();
$queryCount = 0;
$count = 10;
$check = $contact_updated/10;
$str = "";
for ($x = 0; $x <$contact_updated; $x+=10){
	for($i=0; $i<$count; $i++){
		if($i<$count-1){
			$concate = "&";
		}else{
			$concate = "";
		}
		$index = $x+$i;
		$str .= "name[".$index."]=".$all_contacts[$x+$i]['FirstName']."".$concate;
	}
	echo "https://api.genderize.io?".$str."&name[]=''"."<br/>";
	echo "<br/>"."==================="."<br/>";
	$rawData = file_get_contents("https://api.genderize.io?&".$str."&name[]=''");
	$parsedGender = json_decode($rawData);
	echo "<pre>";
	//print_r($parsedGender);
	echo "</pre>";
	
	foreach($parsedGender as $gender){
		echo "<pre>";
		print_r($gender);
		echo "</pre>";
		$query[$queryCount]['name'] = $gender->name;
		$query[$queryCount]['gender'] = $gender->gender;
		echo $queryCount++;
	}
	echo "here";
	echo $check;
	$check--;
	if($check>=1){
		$count = 10;
	}else{
		echo "incheck";
		echo $count = $contact_updated%10;
	}
	$str="";
	
}
echo "<pre>";
print_r($query);
echo "</pre>";

//Update infusionsoft contact's gender
$contact_names = array();
foreach($query as $data){
	//print_r($data['name']); exit;
	$contact_names[] = $data['name'];
	//check duplicate name
	$length  = count( array_keys( $contact_names, $data['name']));
	if ($length == 1) {
	    $returnFields = array('Id','FirstName');
		$query = array('FirstName' => $data['name']);
		$contacts = $app->dsQuery("Contact",10,0,$query,$returnFields);
		foreach($contacts as $contact){
			$id = $contact['Id'];
			$condata = array('_Gender4' => $data['gender']);
			$cid = $app->dsUpdate("Contact", $id, $condata);
		}
		echo "Gender Field of ".$data['name']. " has been updated<br/>";
	} 
}

echo "Gender of  ".$contact_updated ." contacts updated successfully.";

   
}else{
	echo "Connection not found";
}
