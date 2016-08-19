<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
include_once("../ISDK/isdk.php");
include_once("../ISDK/xmlrpc-3.0/lib/xmlrpc.inc");
$app = new iSDK;
// Test Connnection
if ($app->cfgCon("pz216")){
		echo "Yabba Dabba Doo! You Are Connected To Infusionsoft!!!!!";
		
		$all_products = array(); 
		$returnFields = array('Id','ProductName','ProductPrice');
		$query = array('Id' => '%');
		$products = $app->dsQuery("Product",10,0,$query,$returnFields);
		$all_products = array_merge($all_products, $products);
		
		echo "<h1>All Products</h1>";
		echo "<pre>";
        print_r($all_products);
		echo "</pre>";
		
		
		$all_orders = array(); 
		$returnFields = array('Id','ProductId','JobTitle');
		$query = array('Id' => '%');
		$orders = $app->dsQuery("Job",10,0,$query,$returnFields);
		$all_orders = array_merge($all_orders, $orders);
		
		echo "<h1>All Orders</h1>";
		echo "<pre>";
        print_r($all_orders);
		echo "</pre>";
		
		
		
		$all_subscription_products = array();        
        $page = 0;
        /** Get Products with Subscriptions EAW **/
		$returnFields = array('Id','ProductName','ProductPrice');
        $query = array('ProductName' => '%EAW %');
		$results = $app->dsQuery("Product", 1000, $page, $query, $returnFields);
		$all_subscription_products = array_merge($all_subscription_products, $results);
		
		echo "<h1>Get Products with Subscriptions EAW</h1>";
		echo "<pre>";
        print_r($all_subscription_products);
		echo "</pre>";
		
		/** Get Subscriptions with status active for Products EAW from  RecurringOrder Table **/
		
		$all_subscriptions = array();  
		foreach($all_subscription_products as $product){
			$ProductId = $product['Id'];
			$returnFields = array('Id','ProductId','Status','ContactId');
			$query = array('ProductId' => $ProductId,'Status'=>'Active');
			$results = $app->dsQuery("RecurringOrder", 1000, $page, $query, $returnFields);
			$all_subscriptions = array_merge($all_subscriptions, $results);
		}
		
		echo "<h1>Get Subscriptions with status active for Products EAW</h1>";
		echo "<pre>";
        print_r($all_subscriptions);
		echo "</pre>";
		
		$all_subscription_contacts = array();  
		echo "<h1>Get Contacts for Products EAW with active subscription</h1>";
		foreach($all_subscriptions as $subscription){
			/*
			$contactId = $subscription['ContactId'];
			$returnFields = array('Email', 'FirstName', 'LastName');
			$query = array('Id' => $contactId);
			$results = $app->dsQuery("Contact", 1000, $page, $query, $returnFields);
			$all_subscription_contacts = array_merge($all_subscription_contacts, $results);
			**/
			//echo "Set Status Inactive against Subscription ID ".$subscription['Id']." in RecurringOrder Table <br>";
			
			$grp = array('Status'  => 'Inactive');
			$grpID = $subscription['Id'];
			//$grpID = $app->dsUpdate("RecurringOrder", $grpID, $grp);
		}
		
		echo "<pre>";
        //print_r($all_subscription_contacts);
		echo "</pre>";
}
else{
	echo "Not Connected…";
}
?>