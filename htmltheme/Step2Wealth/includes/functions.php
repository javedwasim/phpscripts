<?php

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

function generatePassword($l = 8, $c = 0, $n = 0, $s = 0) {
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
function selected_field($val,$val2){
    if($val == $val2){
        echo 'selected="selected"';
    }
}
################ pagination function #########################################

function paginate_function($item_per_page, $current_page, $total_records, $total_pages) {
    $pagination = '';
    if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) { //verify total pages and current page number
        $pagination .= '<ul class="ajx_pagination">';

        $right_links = $current_page + 3;
        $previous = $current_page - 3; //previous link 
        $next = $current_page + 1; //next link
        $first_link = true; //boolean var to decide our first link

        if ($current_page > 1) {
            $previous_link = ($previous == 0) ? 1 : $previous;
            $pagination .= '<li class="first"><a href="#" data-page="1" title="First">&laquo;</a></li>'; //first link
            $pagination .= '<li><a href="#" data-page="' . $previous_link . '" title="Previous">&lt;</a></li>'; //previous link
            for ($i = ($current_page - 2); $i < $current_page; $i++) { //Create left-hand side links
                if ($i > 0) {
                    $pagination .= '<li><a href="#" data-page="' . $i . '" title="Page' . $i . '">' . $i . '</a></li>';
                }
            }
            $first_link = false; //set first link to false
        }

        if ($first_link) { //if current active page is first link
            $pagination .= '<li class="first active">' . $current_page . '</li>';
        } elseif ($current_page == $total_pages) { //if it's the last active link
            $pagination .= '<li class="last active">' . $current_page . '</li>';
        } else { //regular current link
            $pagination .= '<li class="active">' . $current_page . '</li>';
        }

        for ($i = $current_page + 1; $i < $right_links; $i++) { //create right-hand side links
            if ($i <= $total_pages) {
                $pagination .= '<li><a href="#" data-page="' . $i . '" title="Page ' . $i . '">' . $i . '</a></li>';
            }
        }
        if ($current_page < $total_pages) {
            $next_link = ($i > $total_pages) ? $total_pages : $i;
            $pagination .= '<li><a href="#" data-page="' . $next_link . '" title="Next">&gt;</a></li>'; //next link
            $pagination .= '<li class="last"><a href="#" data-page="' . $total_pages . '" title="Last">&raquo;</a></li>'; //last link
        }

        $pagination .= '</ul>';
    }
    return $pagination; //return pagination links
}
?>