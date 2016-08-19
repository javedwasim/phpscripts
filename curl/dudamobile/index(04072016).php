<?php 

function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
   }
   
 function redirect_JS($page){
    
        echo '<script>window.location = "'.$page.'";</script>'; 
        
}  
   
if(isset($_REQUEST['email']) && isset($_REQUEST['website'])){

 $website = isset($_REQUEST['website'])?$_REQUEST['website']:"";   
 $email = isset($_REQUEST['email'])?$_REQUEST['email']:"";   

 $website = addhttp($website);


   $data = '
		{	
		"site_data":
			{						
				"original_site_url":"123456789"
			}
		}
	';

	
	$data = str_replace("123456789",$website,$data);
	
	//var_dump($data);
	
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
		$output = json_decode($output);
		if($output->error_code=="InvalidInput"){
			$output->message;
			
			}
		$pageUrl = "http://1m.1mobil-e.com/free-instant-mobile-website?msg=".$output->message."#img_container";
		
		//echo "pageUrl:". $pageUrl;
		
	redirect_JS($pageUrl);
	die();
		
	}
	
	// Get result site name
	$output = json_decode($output, true);
	$siteName = $output['site_name'];
   
   
//======================================Create View=====================================================
try{  
	 if (!empty($website))  {
		 
		 $data = '';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/sites/'.$siteName);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, "8c5dfa6766:Kk3cA3Dm8kR8");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json', 		
			'Content-Length: ' . strlen($data))                                                                       
		);   
		//Perform cURL and set result as $output
		$output = curl_exec($ch);
		//Decode JSON results into array
		$output = json_decode($output);
		curl_close($ch);
		//Echo exact preview URL from array
		$pageUrl = $output->site_extra_info->preview_url;
		//$pageUrl = "http://1m.1mobil-e.com/free-instant-mobile-website?url=".$pageUrl."#img_container";
		//$pageUrl = "http://1m.1mobil-e.com/free-instant-mobile-website?url=http://lemaster.editor.multiscreensite.com/preview/site/".$siteName."#img_container";
		$pageUrl = "http://1m.1mobil-e.com/free-instant-mobile-website?url=".$beforeAfterUrl."#img_container";
		header("Location:".$pageUrl);
		 
	 }else{
		 $pageUrl = "http://1m.1mobil-e.com/instant-free-mobile-design";
		 //redirect_JS($pageUrl);
		 header("Location:".$pageUrl);
		 die();
	 }
 } catch (Exception $e) {
        $pageUrl = "http://1m.1mobil-e.com/instant-free-mobile-design";
		header("Location:".$pageUrl);
		// redirect_JS($pageUrl);
		 die();
    }
 //echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
}// end of if(isset($_REQUEST['custom_type']) && isset($_REQUEST['email'])){