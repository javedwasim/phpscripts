<?php
ini_set('max_execution_time', 9000); 
require_once("includes/contacts.php");

/* 
echo "<pre>";
print_r(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=182.178.240.107')));
echo "</pre>";
 */

$name = "uk255";
$key = "56e4ff504097865cf12bb6a30f8b4a46";
// Create Contact object and Infusionsoft Connnection
$contact_obj = new contacts();

//gel all infusionsoft contacts
$all_contacts = $contact_obj->getallContacts();

$contact_updated  = $contact_obj->CountAllContacts();
// Build query to get gender from genderize API
$query =  array();
for ($x = 0; $x <$contact_updated; $x++){
	
	// get JSON from API. make sure you prefix the domain with "api."
	$param = array('name' => $all_contacts[$x]['FirstName']);
	$rawData = file_get_contents("http://api.genderize.io?apikey=6cdd5178b5261cf235c10b73a3207e17&" . http_build_query($param));
	$parsedGender = json_decode($rawData);
	$query[$x]['name'] = $parsedGender->name;
	$query[$x]['gender'] = $parsedGender->gender;
	
}

//Update infusionsoft contact's gender
$contact_names = array();
foreach($query as $data){
	//print_r($data['name']); exit;
	$contact_names[] = $data['name'];
	//check duplicate name
	$length  = count( array_keys( $contact_names, $data['name']));
	if ($length == 1) {
		//print_r($contact_names);
		$contact_obj->updteContactGender($data['name'], $data['gender']);
		echo "Gender Field of ".$data['name']. "has been updated<br/>";
	}
}

echo "Gender of  ".$contact_updated ." contacts updated successfully.";

   


