<?php
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
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
