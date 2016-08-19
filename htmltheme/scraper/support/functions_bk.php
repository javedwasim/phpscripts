<?php
require_once("tables/table2arr.php");
include_once "../Step2Wealth/includes/Database.php";

function strip_zeros_from_date($marked_string = "") {
    // first remove the marked zeros
    $no_zeros = str_replace('*0', '', $marked_string);
    // then remove any remaining marks
    $cleaned_string = str_replace('*', '', $no_zeros);
    return $cleaned_string;
}

function redirect_to($location = NULL) {
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}

function output_message($message = "") {
    if (!empty($message)) {
        return "<p class=\"message\">{$message}</p>";
    } else {
        return "";
    }
}

function __autoload($class_name) {
    $class_name = strtolower($class_name);
    $path = LIB_PATH . DS . "{$class_name}.php";
    if (file_exists($path)) {
        require_once($path);
    } else {
        die("The file {$class_name}.php could not be found.");
    }
}

function include_layout_template($template = "") {
    include(SITE_ROOT . DS . 'public' . DS . 'layouts' . DS . $template);
}

function log_action($action, $message = "") {
    $logfile = SITE_ROOT . DS . 'logs' . DS . 'log.txt';
    $new = file_exists($logfile) ? false : true;
    if ($handle = fopen($logfile, 'a')) { // append
        $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
        $content = "{$timestamp} | {$action}: {$message}\n";
        fwrite($handle, $content);
        fclose($handle);
        if ($new) {
            chmod($logfile, 0755);
        }
    } else {
        echo "Could not open log file for writing.";
    }
}

function datetime_to_text($datetime = "") {
    $unixdatetime = strtotime($datetime);
    return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

/*
 * 
 * 
 * Custom Function by IS
 * 
 */

function redirect_JS($page) {
    echo '<script>window.location = "' . $page . '";</script>';
}

function getHttpVars() {
    $superglobs = array(
        '_POST',
        '_REQUEST',
        '_GET',
        '_FILES',
        'HTTP_POST_VARS',
        'HTTP_GET_VARS');
    $httpvars = array();
    // extract the right array
    foreach ($superglobs as $glob) {
        global $$glob;
        if (isset($$glob) && is_array($$glob)) {
            $httpvars = $$glob;
        }
        if (count($httpvars) > 0)
            break;
    }
    return $httpvars;
}

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function is_home_page() {
    global $currentPage;
    if ($currentPage == "index.php") {
        return true;
    }
}

function is_page($page) {
    global $currentPage;
    //$page  =   $page.".php";
    if ($currentPage == $page) {
        return true;
    }
}

function open_child_nav(array $page) {

    global $currentPage;
    if (in_array($currentPage, $page)) {
        echo 'style="display:block"';
    }
}

function beutifyArray(array $arr) {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

function page_heading() {
    global $currentPage;
    if (is_home_page()) {
        echo " Dashboard";
    } elseif (is_page("myproducts.php")) {
        echo "My Products";
    } elseif (is_page("slideshow.php")) {
        echo 'Make Content For <span class="label label-success text-24"><i class="fa fa-dollar"></i></span>';
    } elseif (is_page("existingslideshow.php")) {
        echo 'Share Content For <span class="label label-success text-24"><i class="fa fa-dollar"></i></span>';
    } elseif (is_page("referral.php")) {
        echo 'Refer People for <span class="label label-success text-24"><i class="fa fa-dollar"></i></span>';
    } elseif (is_page("training.php")) {
        echo "Training";
    } elseif (is_page("memberslideshow.php")) {
        echo "Slides Show";
    } elseif (is_page("admin.php")) {
        echo "Members";
    } elseif (is_page("unlockcommission.php")) {
        echo "Unlock Commission";
    } elseif (is_page("slideshowdetail.php")) {
        echo "Slide Showdetail";
    } elseif (is_page("totalcommissiondetail.php")) {
        echo "Total Commission";
    } elseif (is_page("createdcontentcommissiondetail.php")) {
        echo "Created Content Commission";
    } elseif (is_page("referralcommissiondetail.php")) {
        echo "Referral Commission";
    } elseif (is_page("sharedcontentcommissiondetail.php")) {
        echo "Shared Content Commission";
    }elseif(is_page("adminsettings.php")){
        echo "Admin Settings";
    }elseif(is_page("membersettings.php")){
        echo "Member Settings";
    } else {
        echo str_replace(".php", "", $currentPage);
    }
}

function generatePassword($l = 6, $c = 0, $n = 0, $s = 0) {
    // get count of all required minimum special chars
    $count = $c + $n + $s;
    $out = "";
    // sanitize inputs; should be self-explanatory
    if (!is_int($l) || !is_int($c) || !is_int($n) || !is_int($s)) {
        trigger_error('Argument(s) not an integer', E_USER_WARNING);
        return false;
    } elseif ($l < 0 || $l > 20 || $c < 0 || $n < 0 || $s < 0) {
        trigger_error('Argument(s) out of range', E_USER_WARNING);
        return false;
    } elseif ($c > $l) {
        trigger_error('Number of password capitals required exceeds password length', E_USER_WARNING);
        return false;
    } elseif ($n > $l) {
        trigger_error('Number of password numerals exceeds password length', E_USER_WARNING);
        return false;
    } elseif ($s > $l) {
        trigger_error('Number of password capitals exceeds password length', E_USER_WARNING);
        return false;
    } elseif ($count > $l) {
        trigger_error('Number of password special characters exceeds specified password length', E_USER_WARNING);
        return false;
    }

    // all inputs clean, proceed to build password
    // change these strings if you want to include or exclude possible password characters
    $chars = "abcdefghijklmnopqrstuvwxyz";
    $caps = strtoupper($chars);
    $nums = "0123456789";
    $syms = "!@#$%^&*()-+?";

    // build the base password of all lower-case letters
    for ($i = 0; $i < $l; $i++) {
        $out .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }

    // create arrays if special character(s) required
    if ($count) {
        // split base password to array; create special chars array
        $tmp1 = str_split($out);
        $tmp2 = array();

        // add required special character(s) to second array
        for ($i = 0; $i < $c; $i++) {
            array_push($tmp2, substr($caps, mt_rand(0, strlen($caps) - 1), 1));
        }
        for ($i = 0; $i < $n; $i++) {
            array_push($tmp2, substr($nums, mt_rand(0, strlen($nums) - 1), 1));
        }
        for ($i = 0; $i < $s; $i++) {
            array_push($tmp2, substr($syms, mt_rand(0, strlen($syms) - 1), 1));
        }

        // hack off a chunk of the base password array that's as big as the special chars array
        $tmp1 = array_slice($tmp1, 0, $l - $count);
        // merge special character(s) array with base password array
        $tmp1 = array_merge($tmp1, $tmp2);
        // mix the characters up
        shuffle($tmp1);
        // convert to string for output
        $out = implode('', $tmp1);
    }

    return $out;
}

function object_to_array($object) {
    if (is_object($object)) {
        return array_map(__FUNCTION__, get_object_vars($object));
    } else if (is_array($object)) {
        return array_map(__FUNCTION__, $object);
    } else {
        return $object;
    }
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

function admin_pages_previliges() {
    global $session;
if (is_page("admin.php") || is_page("memberslideshow.php") || is_page("slideshowdetail.php") || is_page("adminsettings.php") || is_page("membersettings.php")) {
        if (!$session->is_Admin_logged_in()) {
            redirect_JS("index.php");
            die();
        }
    }
}

function member_pages_previliges() {
    global $session;
    if (is_page("index.php") || is_page("slideshow.php")) {
        if (!$session->is_logged_in()) {
            redirect_JS("admin.php");
            die();
        }
    }
}

function spanner_loder($id) {
    echo '<span id="spinner_' . $id . '" class="display-none">
            <img src="images/loading-bars.svg" width="48" height="48" />
           </span>';
}

function success_message($id) {
    echo '<div id="successmsgBx_' . $id . '" class="alert alert-success display-none">
                	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              			<div id="msg_suc' . $id . '"></div>
              		</div>';
}

function msg_box($id) {
    echo '<div id="msg_box_' . $id . '" class="alert alert-danger display-none msg_box">
                	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              			<div id="msg_err_' . $id . '"></div>
              		</div>';
}
function generateUniqueName($flieName){
        if ($flieName != '') {
        $random_digit = rand(0000, 9999);
        $time = time();
        $ext = substr($flieName, -3);
        $newFileName = $time . '_' . $random_digit . '.' . $ext;
        return $newFileName;
    }
}
function upload_pic($temp,$NewFileName){
    if (move_uploaded_file($temp, SLIDES_PIC_DIR.$NewFileName)) {
            return true;
        } else {
           return false;
        }
}
function allowed_file_type($fileType){
    switch(strtolower($fileType))
        {
            //allowed file types
            case 'image/png': 
            case 'image/gif': 
            case 'image/jpeg': 
            case 'image/pjpeg':
            break;
            default:
                die('Unsupported File!'); //output error
    }
}
function checked_field($val,$val2){
    if($val == $val2){
        echo 'checked="checked"';
    }
}

function currentresponse_file($currentResponse){
	$myfile = fopen("testfile.php", "w") or die("Unable to open file!");
	$txt = $currentResponse;
	fwrite($myfile, $txt);
	$txt = "Javed Wasim\n";
	fwrite($myfile, $txt);
	fclose($myfile);
}

function parsehtmltable_intomysql($data){
	$dbobj = new Database();
	$g= new table2arr("'$data'");
	
	$drop_table = "DROP TABLE IF EXISTS `affiliate_report`";
	$dbobj->query($drop_table);
	
	//Create table if not exist.
	$sql = "CREATE TABLE IF NOT EXISTS `affiliate_report` ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, `Date` date NOT NULL, `Offer ID` int(11) NOT NULL, `Affiliate ID` int(11) NOT NULL, `Impressions` bigint(11) NOT NULL, `Clicks` int(11) NOT NULL, `Conversions` int(11) NOT NULL, `Cost` varchar(100) NOT NULL, `CPC` varchar(100) NOT NULL, `Revenue` varchar(100) NOT NULL, `RPC` varchar(100) NOT NULL, `Profit` varchar(100) NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

	$dbobj->query($sql);
	
	//Count number of tables in current response.
	$cnt=$g->tablecount;
	
	print_r($g->table[0]['content']);
		
	$report_data = array();
	//print "<pre>";
	for($i=0;$i<$cnt;$i++)
	{
	$g->getcells($i);
	  $report = $g->cells;
	  //print_r($g->cells);
	  //echo sizeof($report);
	  for($j = 1; $j<sizeof($report); $j++){
		  for($k = 0; $k<sizeof($report[$j]); $k++){
			//$dbobj->query($sql);  
			$report_data[] = $report[$j][$k]."\n";
		  }
		  echo "<h1>new row start\n</h1>";
		  $insert_query = "INSERT INTO `steptowealth_db`.`affiliate_report` (`id`, `Date`, `Offer ID`, `Affiliate ID`, `Impressions`, `Clicks`, `Conversions`, `Cost`, `CPC`, `Revenue`, `RPC`, `Profit`) VALUES (NULL, '$report_data[0]', '$report_data[1]', '$report_data[2]', '$report_data[3]', '$report_data[4]', '$report_data[5]', '$report_data[6]', '$report_data[7]', '$report_data[8]', '$report_data[9]', '$report_data[10]')";
		  
		  $dbobj->query($insert_query);
		  //empty query array to insert new record.
		  print_r($report_data);
		  unset($report_data);
	  }
	  
	}	
    
}

function updateContactRole($id) {
	global $app;
   $condata = array('_Role' => "Member");
   $cid = $app->dsUpdate("Contact", $id, $condata); 
	if (!empty($cid)) {
		return true;
	} else {
		return false;
	}   
}

 function changePwd($id, $Newpwd) {
	global $app; 
	$condata = array('Password' => $Newpwd);
	$cid = $app->dsUpdate("Contact", $id, $condata);
	if (!empty($cid)) {
		return true;
	} else {
		return false;
	}
}

 function authenticateContact($contactemail, $contactpassword) {
	global $app; 
	$returnFields = array("Id", "Email", "FirstName", "LastName", "Password", "_Role", "Company");
	$query = array("Email" => $contactemail, "Password" => $contactpassword);
	$Contact = $app->dsQuery('Contact', 1, 0, $query, $returnFields);
	return $Contact;
}

?>