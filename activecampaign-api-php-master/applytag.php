<?php
ini_set('max_execution_time', 9000); 
require_once("ISDK/isdk.php");
$app = new iSDK;   

if (!$_REQUEST){
  die("No Posted value found!");
}

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $data = print_r($_POST, 1);
    
    $fd = @fopen("log.txt", "a");
    fwrite($fd, $data);
    fclose($fd);
    
  }

$data = $_REQUEST;
$email = $data['contact']['email'];
$tagname = $data['contact']['tags'];

$tagsname = explode(',', $tagname);



$tags = array('email' => $data['contact']['email']);

if ($app->cfgCon("uk255")){
	
	echo "connected<br/>";
	
	$returnGroupFields = array('Id');
	$query = array('Email' => $email);
	
	//get contact id.
	$contactQuery = $app->dsQuery('Contact', 1, 0, $query, $returnGroupFields);
	$contactid = $contactQuery[0]["Id"];
	var_dump($contactid);
	echo 	"<br/>";
	
	$contact_tags = array();
	$counter = 0;
	foreach($tagsname as $key) {    
    
	$key = trim($key);
	   
	$contact_tags[$counter] = $key;
	
		$returnGroupFields = array('Id', 'GroupName');
		$query = array('GroupName' => $key);
		$tagExist = $app->dsQuery('ContactGroup', 1, 0, $query, $returnGroupFields);
		
		if(empty($tagExist)){
			//create new tag and add to ContactGroup database table
			$newTagData = array('GroupName' => $key, 'GroupCategoryId' => 106); 
			
			$tagId = $app->dsAdd('ContactGroup',$newTagData); 
			
			$app->grpAssign($contactid, $tagId);
			echo "Tag Id ".$tagId. " has been created successfully.";
		}else{
			$tagid = ($tagExist[0]['Id']);
			$app->grpAssign($contactid, $tagid);
			echo "<h4>Tags applied on infusionsoft contacts.</h4><br/>";
		}
		
		$counter++;
	}
	
	//////////////// Update AC Tags ////////////////
	
	$returnGroupFields = array('ContactGroup');
	$query = array('ContactId' => $contactid);
	$tagsapplied = $app->dsQuery('ContactGroupAssign', 900, 0, $query, $returnGroupFields);
	
	echo "<pre>";
	print_r($tagsapplied);
	echo "</pre>";
	
	//create an array of all tags applied on contacts
	
	$index = 0;
	for($i=0;$i<count($tagsapplied);$i++){
		if(!empty($tagsapplied[$i]['ContactGroup'])){
			if(!in_array($tagsapplied[$i]['ContactGroup'],$contact_tags)){
				//echo $tagsapplied[$i]['ContactGroup']."<br/>checkkkk";
				$tags['tags['.$index.']'] = $tagsapplied[$i]['ContactGroup'];
			}
			
			$index++;
		}	
	
	}
	echo "<h4>Difference of tags</h4><br/>";
	echo "<pre>";
	print_r($tags);
	echo "</pre>";
	
}else{
	echo "Connection not found";
}

//get email parameter
 $url = 'https://javed693.api-us1.com';
 $api_key = '3ba2467edc9e1ec44cfd8bd99ea0ee7fbd92a915a0572629eec164d608701045ac08ae3e';
 

 $params = array(
  'api_key'      => $api_key,
  'api_action'   => 'contact_tag_add',
  'api_output'   => 'serialize',
  'email'        => $email,
 );
 
 $query = "";
 foreach( $params as $key => $value )
  $query .= $key . '=' . urlencode($value) . '&';
 $query = rtrim($query, '& '); 
 $url = rtrim($url, '/ ');
 if ( !function_exists('curl_init') ) 
  die('CURL not supported. (introduced in PHP 4.0.2)');
 if ( $params['api_output'] == 'json' && !function_exists('json_decode') )
  die('JSON not supported. (introduced in PHP 5.2.0)');
  
  
// This section takes the input data and converts it to the proper format
$data = "";
foreach( $tags as $key => $value ) $data .= $key . '=' . urlencode($value) . '&';
$data = rtrim($data, '& ');

  
 $api = $url . '/admin/api.php?' . $query;
 $request = curl_init($api);
 curl_setopt($request, CURLOPT_HEADER, 0);
 curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($request, CURLOPT_POSTFIELDS, $data); 
 curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
 curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

 $response = (string)curl_exec($request);

 curl_close($request);

 if ( !$response ) {
  die('Nothing was returned. Check API URL, Key, and Email parameters.');
 }

 $result = unserialize($response);

// This line takes the response and breaks it into an array using:
// JSON decoder
// $result = json_decode($response);
// unserializer
$result = unserialize($response);
// XML parser...
// ...

// Result info that is always returned
echo 'Result: ' . ( $result['result_code'] ? 'SUCCESS' : 'FAILED' ) . '<br />';
echo 'Message: ' . $result['result_message'] . '<br />';

// The entire result printed out
echo 'The entire result printed out:<br />';
echo '<pre>';
print_r($result);
echo '</pre>';

// Raw response printed out
echo 'Raw response printed out:<br />';
echo '<pre>';
print_r($response);
echo '</pre>';

// API URL that returned the result
echo 'API URL that returned the result:<br />';
echo $api;

 
?>