<?php
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	require_once "support/http.php";
	require_once "support/web_browser.php";
	require_once "support/simple_html_dom.php";
	require_once "support/functions.php";
	require_once "../ISDK/isdk.php";
	include_once("../ISDK/xmlrpc-3.0/lib/xmlrpc.inc");
	include_once("../Step2Wealth/includes/constants.php");
	include_once("../Step2Wealth/includes/Database.php");
		
	global $app;
	$app = new iSDK;
	if(isset($_REQUEST['contactId'])){
		$contactId = $_REQUEST['contactId'];
	}else{
		$contactId = "";
	}
	// Test Connnection
	if ($app->cfgCon("sv287")&&($contactId>0)){
		
		$contact_info = array();        
        $page = 0;
        //echo $contactId;
        $returnFields = array('Id','FirstName','LastName','Company','StreetAddress1','StreetAddress2','City','Country','State','PostalCode','Phone1','Email','Username','Password','JobTitle','Fax1');
        $query = array('Id' => $contactId);

        while(true)
        {
            $results = $app->dsQuery("Contact", 1000, $page, $query, $returnFields);
                        
            $contact_info = array_merge($contact_info, $results);
            
            if(count($results) < 1000)
            {
                break;
            }
        
            $page++;
        }
		
       
	}
	else{
		echo "Not Connected…";
		die();
	}
	//print_r($contact_info);
	//Process Affiliate and check for mandatory filds.
	if(!empty($contact_info[0]['Company'])&&!empty($contact_info[0]['FirstName'])&&!empty($contact_info[0]['Email'])&&!empty($contact_info[0]['Password'])){
	
		function GetForm($result){
				
			if (!$result["success"])  
				echo "Error retrieving URL.  " . $result["error"] . "\n";
			else if ($result["response"]["code"] != 200)  
				echo "Error retrieving URL.  Server returned:  " . $result["response"]["code"] . " " . $result["response"]["meaning"] . "\n";
			else if (count($result["forms"]) != 1)  {
				echo "Was expecting one form.  Received:  " . count($result["forms"]) . "\n";
				return "";
			}
			else
			{
				$form = $result["forms"][0];
				
				
				return $form;		
			}				
		}
		
		$url = "https://step2wealth.hasoffers.com/";
		$web = new WebBrowser(array("extractforms" => true));
		$response1 = $web->Process($url);
			
		$form1 = GetForm($response1);
		$form1->SetFormValue("data[User][email]", "ryan@ryanbuke.com");
		$form1->SetFormValue("data[User][password]", '$hip50Mil');
		
		$result2 = $form1->GenerateFormRequest("loginButton");
		
		$response2 = $web->Process($result2["url"], "auto", $result2["options"]);

		$form2 = GetForm($response2);
		$form2->SetFormValue("data[User][type]", "employee");
		
		$result3 = $form2->GenerateFormRequest("affiliates-login-button");
		$response3 = $web->Process($result3["url"], "auto", $result3["options"]);
		
		$response4 = $web->Process("https://step2wealth.hasoffers.com/admin/affiliates/create","auto", $result3["options"]);
		
		
		$form3 = $response4["forms"][1];
		
		//Set Values to create affiliate.
		if(isset($contact_info[0]['Company'])){
			$form3->SetFormValue("data[Affiliate][company]", $contact_info[0]['Company']);
		}
		if(isset($contact_info[0]['StreetAddress1'])){
			$form3->SetFormValue("data[Affiliate][address1]", $contact_info[0]['StreetAddress1']);
		}
		if(isset($contact_info[0]['StreetAddress2'])){
			$form3->SetFormValue("data[Affiliate][address2]", $contact_info[0]['StreetAddress2']);
		}
		if(isset($contact_info[0]['City'])){
			$form3->SetFormValue("data[Affiliate][city]", $contact_info[0]['City']);
		}
		if(isset($contact_info[0]['Country'])){
			$form3->SetFormValue("data[Affiliate][country]", $contact_info[0]['Country']);
		}
		if(isset($contact_info[0]['State'])){
			$form3->SetFormValue("data[Affiliate][region]", $contact_info[0]['State']);
		}
		if(isset($contact_info[0]['PostalCode'])){
			$form3->SetFormValue("data[Affiliate][zipcode]", $contact_info[0]['PostalCode']);
		}
		if(isset($contact_info[0]['Phone1'])){
			$form3->SetFormValue("data[Affiliate][phone]", $contact_info[0]['Phone1']);
		}
		if(isset($contact_info[0]['Fax1'])){
			$form3->SetFormValue("data[Affiliate][fax]", $contact_info[0]['Fax1']);
		}
		if(isset($contact_info[0]['FirstName'])){
			$form3->SetFormValue("data[AffiliateUser][first_name]", $contact_info[0]['FirstName']);
		}
		if(isset($contact_info[0]['LastName'])){
			$form3->SetFormValue("data[AffiliateUser][last_name]", $contact_info[0]['LastName']);
		}
		if(isset($contact_info[0]['JobTitle'])){
			$form3->SetFormValue("data[AffiliateUser][title]", $contact_info[0]['JobTitle']);
		}
		if(isset($contact_info[0]['Email'])){
			$form3->SetFormValue("data[AffiliateUser][email]", $contact_info[0]['Email']);
		}
		if(isset($contact_info[0]['Password'])){
			$form3->SetFormValue("data[AffiliateUser][password]", $contact_info[0]['Password']);
		}
		if(isset($contact_info[0]['Password'])){
			$form3->SetFormValue("data[AffiliateUser][password_confirmation]", $contact_info[0]['Password']);
		}
		
		$result4 = $form3->GenerateFormRequest("affiliates-create-button");
		$response5 = $web->Process($result4["url"], "auto", $result4["options"]);
			
		$affiliate_id = basename($response5['url']);
		
		if($affiliate_id>0){
			
			$memberid = $contact_info[0]['Id'];
			$db = new Database();
			$member_query = "select * from membersettings where memberId = ".$memberid;
			$result = $db->query($member_query);
			$count_member = $db->num_rows($result);
			if($count_member==0){
				
					$sql = "INSERT INTO membersettings (memberId, commissionPerClick, affiliateURL, affiliateId)
					VALUES ('".$memberid."','','http://interestingstories.co/','".$affiliate_id."')"; 
					$result = $db->query($sql);	
					$db->close_connection();
					echo "<h1>Affiliate With Id ".$affiliate_id." created successfully.</h1>";
					
			}else{
				
				/* $sql = "Update membersettings SET  affiliateId= '".$affiliate_id."', affiliateURL ='http://interestingstories.co/' Where memberId = ".$memberid;
				$result = $db->query($sql);	
				$db->close_connection(); */
				
				$sql = "INSERT INTO membersettings (memberId, commissionPerClick, affiliateURL, affiliateId)
				VALUES ('".$memberid."','','http://interestingstories.co/','".$affiliate_id."')"; 
				$result = $db->query($sql);	
				$db->close_connection();
				echo "<h1>Affiliate With Id ".$affiliate_id." created successfully.</h1>";
				
			}
			
			//generate new password
			$newpassword = generatePassword();
			
			//update Contact Role to Member.
			$role_status = updateContactRole($contactId);
			
			//Upate New Password
			$password_status = changePwd($contactId,$newpassword);
		   
			//authenticate contact
			$atuhenticate_contact = authenticateContact($contact_info[0]['Email'], $newpassword);
			
			echo "<pre>";
			echo "Contatc is authenticated \n";
			print_r($atuhenticate_contact);
			echo "</pre>";
			
			echo "role updated status ".$role_status."and new password is ".$newpassword;
			
		}else{
			echo "<h1>Affiliate with this name already exist.</h1>";
		}
		
	}else{
		
		echo "<h4 style='Color:red;'>Following 'FirstName, Email, Company, Password', fields require to create affiliate. </h4>";
	}
	
?>