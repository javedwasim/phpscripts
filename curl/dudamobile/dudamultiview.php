<?php 
/*========================Grant Access=====================================*/
//Set API user and password
define("API_USER","8c5dfa6766");
define("API_PASS","Kk3cA3Dm8kR8");
//Check if a template was selected from page
if (isset($_GET['template_id'])) {
    //if site was selected, use the template_id and original url (if set) to create a new site
    $createdSite = createSite($_GET['template_id'],$_GET['original_url']);
    //echo 'Site Created: ' . $createdSite . '<br/>';
    //$accountCreated = createSubAccount($_GET['email']);
    //echo 'Account created: ' . $accountCreated . '<br/>';
	$accountCreated = 'rine_t@ip6.pp.ua';
    $grantAccess = grantAccountAccess($accountCreated,$createdSite);
    //echo 'Account granted access.<br/>';
	$sso_link = generateSSOLink($createdSite,$accountCreated);
    header("Location: " . $sso_link);

} 
//if a template was note selected, display template selection
else {
    displayTemplates();
}

function generateSSOLink($siteName,$account) {
	//Set editor custom domain --
	$editor_url = 'm.1mobil-e.com';
	//Set SSO Parameters
	$dm_sig_site = $siteName;
	$dm_sig_user = $account;
	$dm_sig_partner_key = '60a279';
	$dm_sig_timestamp = date_timestamp_get(date_create());
	$secret_key = '64c39529d00c8760415659350cf32f50';
	//Concatenate sso strings so it can be encrypted
	$dm_sig_string = $secret_key.'user='.$dm_sig_user.'timestamp='.$dm_sig_timestamp.'site='.$dm_sig_site.'partner_key='.$dm_sig_partner_key;
	//Encrypt values
	$dm_sig = hash_hmac('sha1', $dm_sig_string, $secret_key);
	//Create SSO link
	$sso_link = 'http://' . $editor_url.'/home/site/'.$dm_sig_site.'?dm_sig_partner_key='.$dm_sig_partner_key.'&dm_sig_timestamp='.$dm_sig_timestamp.'&dm_sig_user='.$dm_sig_user.'&dm_sig_site='.$dm_sig_site.'&dm_sig='.$dm_sig;
	//return SSO link
	return $sso_link;
}

//Functions below
function grantAccountAccess($email,$siteName) {
    $ch = curl_init();
	
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //format URL to grant access to email and sitename passed
    curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/accounts/grant-access/'.$email.'/sites/'.$siteName);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, API_USER.':'.API_PASS);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //execute cURL call and get template data
    $output = curl_exec($ch);
	
	$info = curl_getinfo($ch);
	//print_r($info);
	if ($info['http_code'] != 204) {
		print("<br/>Error granting access to site<br/><br/>");
		print_r($output);
		print_r($info);
		die();
	}
	
    curl_close($ch);
    return true;
}
function createSubAccount($emailToCreate) {
    $data = '{"account_name":"rine_t@ip6.pp.ua"}';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/accounts/create');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, API_USER.':'.API_PASS);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //execute cURL call and get template data
    $output = curl_exec($ch);
    if(curl_getinfo($ch,CURLINFO_HTTP_CODE) == 204) {
        curl_close($ch);
        return $emailToCreate;
    } else {
        curl_close($ch);
        die('Account creation failed, error: '. $output . '<br/>');
    }
}
function createSite($tempalte_id,$original_url) {
    //create array with data
    if($original_url) {
        $data = array("template_id"=>$_GET['template_id'],"url"=>$original_url);    
    } else {
        $data = array("template_id"=>$_GET['template_id']);
    }
    //turn data into json to pass via cURL
    $data = json_encode($data);
    //Set cURL parameters
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/sites/multiscreen/create');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, API_USER.':'.API_PASS);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //execute cURL call and get template data
    $output = curl_exec($ch);
    //check for errors in cURL
    if(curl_errno($ch)) {
        die('Curl error: ' . curl_error($ch));
    }
    $output = json_decode($output);
    return $output->site_name;
}
function displayTemplates() {
    //Set parameters to make cURL call to Duda
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, 'https://api.dudamobile.com/api/sites/multiscreen/templates');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, API_USER.':'.API_PASS);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    //execute cURL call and get template data
    $output = curl_exec($ch);
    //check for errors in cURL
    if(curl_errno($ch)) {
        die('Curl error: ' . curl_error($ch));
    }
    $output = json_decode($output);
    curl_close($ch);
    //Loop through all templates and display all the available templates in a table
    echo '<table><thead><tr><th>Template Name</th><th>Template Image</th><th>Template Id</th></tr></thead>';
    foreach($output as $template) {
        echo '<tr>';
        echo '<td>' . $template->template_name . '</td>';
        echo '<td><a href="'.$template->preview_url.'" target="_blank"><img src="' . $template->thumbnail_url. '"></a>' . '</td>';
        echo '<td><form method="GET" action=' . $_SERVER['PHP_SELF'] . '>';
        echo '<input type="hidden" name="template_id" value="' . $template->template_id . '">';
        echo '<input type="url" name="original_url" placeholder="Existing Site URL">';
        echo '<input type="email" name="email" placeholder="Your e-mail" required>';
        echo '<button type="submit">Choose Site</button>';
        echo '</form></td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>