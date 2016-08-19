<?php
ini_set('max_execution_time', 1800); 
echo "Hello World! <br/>";
require_once("isdk.php");
$app = new iSDK;
// Test Connnection
if ($app->cfgCon("uk255"))
{
echo "Yabba Dabba Doo! You Are Connected To Infusionsoft!!!!!";
		$contactData = array('FirstName' => 'John',
                'LastName'  => 'Doe',
                'Email'     => 'JDoe@email.com');

//$conID = $app->addCon($contactData);
		$all_contacts = array();        
        $page = 0;
        
        $returnFields = array('Id','FirstName');
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
        echo "<pre>";
        print_r($all_contacts);
        echo "</pre>";
		
		//Delete All Records.
		foreach($all_contacts as $contact){
			//echo $contact['Id'];
			//$result = $app->dsDelete('Contact',$contact['Id']);
		}


		$username = 'jwaseem@thinkdonesolutions.com';
		$password = 'polkmn-manjum';
		
		$conDat = array('FirstName' => 'Wasim', 'LastName' => 'Anjum', 'Email' => 'test@example.com', 'Username' => $username, 'Password' => $password);
		//$cid = $app->addCon($conDat);
		
		$fields = array('Id', 'Password');
		$query = array('Username' => $username, 'Password' => $password);
		$results = $app->dsQuery("Contact", 1, 0, $query, $fields);

		if(!empty($results)){
			echo "User Authenticated";
			echo "<pre>";
				print_r($results);
			echo "<pre>";
		} else {
			echo "Failed to Find User";
		}
		
		$username = 'jwaseem@thinkdonesolutions.com';
		$password = 'Manjum1234';
		$newpassword = md5($password);
		$uid = $app->authenticateUser($username, $password);
		echo "<pre>";
			print_r($uid);
		echo "<pre>";
	
		
}
else
{
echo "Not Connected…";
}
?>