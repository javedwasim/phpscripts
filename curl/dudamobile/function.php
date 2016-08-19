<?php 
function redirect_JS($page){
    
        echo '<script  type="text/javascript" >window.location = "'.$page.'";</script>'; 
		
        
  }
function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
   }  
function createAccount($accountName,$firstName,$lastName,$siteURL,$siteName){
	  
	// Create Sub-Account
	//echo "Creating Sub-Account...<br/>";
	
	$data = array(
		'account_name' =>$accountName,
		'first_name' =>$firstName,
		'last_name' =>$lastName,
		
	);
	$data = json_encode( $data);
	
	

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/accounts/create');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "8c5dfa6766:Kk3cA3Dm8kR8");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json', 		
		'Content-Length: ' . strlen($data))                                                                       
	);   	
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
		
	if ($info['http_code'] != 204) {
		print("<br/>Error creating account<br/><br/>");
		print_r($output);
		print_r($info);
		die();
	}
	
	//echo "Sub-Account Created<br/><br/>";
	//=====================================================================================
	//if(empty($siteName)){}
	
	
	
	// Grant Access
	//echo "Granting Access...<br/>";
			
	$data = '';
	curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/accounts/grant-access/'.$accountName.'/sites/'.$siteName);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json', 		
		'Content-Length: ' . strlen($data))                                                                       
	); 
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	
	if ($info['http_code'] != 204) {
		print("<br/>Error granting access to site<br/><br/>");
		print_r($output);
		print_r($info);
		die();
	}
	
	//echo "Access Granted.<br/><br/>";
	
	curl_close($ch);
	
	//echo "Opening the branded editor using SSO.<br/>";
	
	//Set editor custom domain
	$ssoEndpoint = 'm.1mobil-e.com';
	//Set SSO Parameters
	$dm_sig_site = $siteName;
	$dm_sig_user = $accountName;
	$dm_sig_key = '60a279';
	$dm_sig_timestamp = time();
	$secret_key = '64c39529d00c8760415659350cf32f50';
	//Concatenate sso strings so it can be encrypted
	$dm_sig_string = $secret_key.'user='.$dm_sig_user.'timestamp='.$dm_sig_timestamp.'site='.$dm_sig_site.'partner_key='.$dm_sig_key;
	//Encrypt values
	$dm_sig = hash_hmac('sha1', $dm_sig_string, $secret_key);
	//Create SSO link
	$sso_link = 'http://'.$ssoEndpoint.'/home/site/'.$dm_sig_site.'?dm_sig_partner_key='.$dm_sig_key.'&dm_sig_timestamp='.$dm_sig_timestamp.'&dm_sig_user='.$dm_sig_user.'&dm_sig_site='.$dm_sig_site.'&dm_sig='.$dm_sig;	
	//Print SSO link
	//echo "This is the SSO link:".$sso_link;
	//echo "<br/><br/></br>";
	return $sso_link;
	  
  }

function getResetPasswordUrl($email){
	$data="" ;				
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/accounts/reset-password/'.$email);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "8c5dfa6766:Kk3cA3Dm8kR8");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json', 		
		'Content-Length: ' . strlen($data))                                                                       
	);   	
	$output = curl_exec($ch);
	return json_decode($output);
	}
function getContactIdByOrder($orderId){
	global $app;
	if ($app->cfgCon("zs230"))  {
		$qry = array('JobId' => $orderId);
        $ret = array("ContactId");
        $OrderItem = $app->dsQuery("Invoice", 1, 0, $qry, $ret);
        return $OrderItem[0]['ContactId'];
		}
	}
function getContactByEmail($email){
	global $app;
	if ($app->cfgCon("zs230")) {
		$qry = array('Email' => $email);
        $ret = array('Id','FirstName','LastName','Website','_MobileSiteName','City','Phone1','StreetAddress1','State','Country','PostalCode');
        $contacts = $app->dsQuery("Contact", 1, 0, $qry, $ret);
        return $contacts;
		}
}
function getContactById($id){
	global $app;
	if ($app->cfgCon("zs230")) {
			$qry = array('Id' => $id);
			$ret = array('Email','FirstName','LastName','Website','_MobileSiteName','City','Phone1','StreetAddress1','State','Country','PostalCode');
			$contacts = $app->dsQuery("Contact", 1, 0, $qry, $ret);
			return $contacts;
		}
}
	
function publishSite($siteName){
	$data="" ;				
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/sites/mobile/publish/'.$siteName."?test=true");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "8c5dfa6766:Kk3cA3Dm8kR8");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json', 		
		'Content-Length: ' . strlen($data))                                                                       
	);   	
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	if ($info['http_code'] != 204) {
		return ("<br/>Error granting access to site<br/><br/>");
		print_r($output);
		print_r($info);
		
	}else{
		return true;
		}
}

function generateLogFile(array $requet){
	//---------------------------------------------------------------------------------------
	$txtfile = 'LogFIle.txt';
	$txt = "Dated : " .date('Y-m-d H:i:s').PHP_EOL;
	 foreach ($requet as $key => $value) {
			$txt .= ' '.$key .' - '.$value .PHP_EOL;
	    }
	
	    $fh = fopen($txtfile, 'a'); 
    	fwrite($fh,$txt); // Write information to the file
    	fclose($fh); // Close the file
		
//---------------------------------------------------------------------------------------	
	
}
function createMobileSite($siteURL){
		$siteURL = addhttp($siteURL);
	 	$data = '
			{	
			"site_data":
				{						
					"original_site_url":"123456789"
				}
			}
		';
		$data = str_replace("123456789",$siteURL,$data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/sites/create');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, "8c5dfa6766:Kk3cA3Dm8kR8");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json', 		
			'Content-Length: ' . strlen($data))                                                                       
		);   	
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		if ($info['http_code'] != 200) {
			print(".<br/>Error creating site.<br/><br/>");
			print_r($output);
			print_r($info);
			die();
		}
		
		// Get result site name
		$output = json_decode($output, true);
		return $siteName = $output['site_name'];	
}
function getDudaAccount($accountEmail){
	$data = "";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/accounts/get/'.$accountEmail);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "8c5dfa6766:Kk3cA3Dm8kR8");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json', 		
		'Content-Length: ' . strlen($data))                                                                       
	);   	
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
		
	if ($info['http_code'] != 302) {
		print("<br/>Error getting<br/><br/>");
		print_r($output);
		print_r($info);
		//die();
	}else{
	//echo "Account Deleted";
	print_r($output);
		print_r($info);
	
	}
}
function deleteDudaAccount($accountEmail){
	$data = "";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/accounts/delete/'.$accountEmail);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "8c5dfa6766:Kk3cA3Dm8kR8");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json', 		
		'Content-Length: ' . strlen($data))                                                                       
	);   	
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
		
	if ($info['http_code'] != 204) {
		print("<br/>Error Deleteing<br/><br/>");
		print_r($output);
		print_r($info);
		//die();
	}else{
	echo "Account Deleted";
	}
}
function deleteDudaSite($siteName){
	$data = "";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/DELETE/sites/mobile/'.$siteName);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "8c5dfa6766:Kk3cA3Dm8kR8");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json', 		
		'Content-Length: ' . strlen($data))                                                                       
	);   	
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	print_r($output);
		print_r($info);	
	if ($info['http_code'] != 204) {
		print("<br/>Error Deleteing Site<br/><br/>");
		
		//die();
	}else{
	echo "Account Deleted";
	
	}
}
?>