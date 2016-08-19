<?php
ini_set('max_execution_time', 1800); 
echo "Hello World! <br/>";
require_once("iSDK-master/isdk.php");
$app = new iSDK;
// Test Connnection
if ($app->cfgCon("m396")){
		echo "Yabba Dabba Doo! You Are Connected To Infusionsoft!!!!!";
	
		$all_contacts = array();        
        $page = 0;
        $count = 0;
		
        $returnFields = array('GroupId', 'ContactId','Contact.FirstName');
        $query = array('GroupId' => 1427);
		
        while(true)
        {
            $results = $app->dsQuery("ContactGroupAssign", 1000, $page, $query, $returnFields);
                        
            $all_contacts = array_merge($all_contacts, $results);
		  	
			          
            if(count($results) < 1000)
            {
                break;
            }
        
            $page++;
			$count++;
        }
        echo "<pre>";
        print_r($all_contacts);
        echo "</pre>";
		
		
		
		$returnFields = array("Id", "FirstName");
        $query = array("Email" => "%");
		$count = 0;
        while(true)
        {
            $results = $app->dsQuery("Contact", 1000, $page, $query, $returnFields);
                        
            $all_contacts = array_merge($all_contacts, $results);
		  	
			          
            if(count($results) < 1000)
            {
                break;
            }
        
            $page++;
			$count++;
        }
		echo "here".$count;
        echo "<pre>";
        print_r($all_contacts);
        echo "</pre>";
		
		
			
}
else
{
echo "Not Connected…";
}


$page = 0;
$all_tags = array();    
$fields = array('Id','GroupName');
$query = array('Id' => 1427);

while(true){
	
	$results = $app->dsQuery('ContactGroup',1000,$page,$query,$fields);	
	$all_tags = array_merge($all_tags, $results);
	if(count($results) < 1000)
	{
		break;
	}

	$page++;
}

echo "<pre>";
print_r($all_tags);
echo "</pre>";

?>
<!--
m396.infusionsoft.com
healthpriority75@gmail.com
Khuram22
-->