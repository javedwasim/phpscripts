<?php
ini_set('max_execution_time', 1800); //1800 seconds = 30 minutes
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myapp";

echo "Hello World! <br/>";
require_once("isdk.php");
$app = new iSDK;
$page = 0;

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check infusionsoft connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM tbl_users";
$result = $conn->query($sql);
if ($app->cfgCon("uk255")){
	$all_contacts = array();
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			echo "id: " . $row["uId"]. " - Name: " . $row["firstName"]. " " . $row["lastName"]. "  userType: ". $row["userType"]."<br>";
			
			$returnFields = array('Id','FirstName');
			$query = array('Email' => base64_decode($row["email"]));
			$contacts = $app->dsQuery("Contact", 1000, $page, $query, $returnFields);
			echo count($contacts)."<br>";
			//check if contact already exist
			if(count($contacts)==0){
				$data = array('FirstName' => $row["firstName"],
							  'LastName'  => $row["lastName"],
							  'Email'     => base64_decode($row["email"]),
							  'Country'     => $row["country"]);
				//add contact			  
				//$contactId = $app->dsAdd("Contact", $data);
				//optin
				//$app->optIn(base64_decode($row["email"]),"Subscriber");
				//applytag
				//if($row["userType"]==1){$results = $app->grpAssign($contactId, 112);}else{$results = $app->grpAssign($contactId, 110);}
			    
			}else{
				echo "Contact already exist.<br>";
				//$returnFields = array('Id','FirstName');
				//$query = array('Email' => base64_decode($row["email"]));
				//$contacts = $app->dsQuery("Contact",10,0,$query,$returnFields);
				echo $contactId = $contacts[0]['Id'];
				$all_contacts = array_merge($all_contacts, $contacts);
				//if($row["userType"]==1){$results = $app->grpAssign($contactId, 112);}else{$results = $app->grpAssign($contactId, 110);}
				
			}
		}
	}else {
		echo "0 results";
	}
}else{
	echo "Not Connected…";
}
$conn->close();
?>