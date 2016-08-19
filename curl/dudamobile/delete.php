<?php 
include_once("ISDK/isdk.php");
global $app ;
$app = new iSDK;
include_once("function.php");

getDudaAccount($_GET['email']);
deleteDudaAccount($_GET['email']);

deleteDudaSite("gridcondosvip3");
?>				
				
	
