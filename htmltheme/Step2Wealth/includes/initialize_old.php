<?php

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
 
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
//----------------------------------------------------------------
if ($_SERVER['HTTP_HOST'] == "localhost") {
	defined('MAINDIR') ? null : define('MAINDIR', "Step2Wealth");
    defined('SITE_ROOT') ? null : define('SITE_ROOT','C:\xampp\htdocs'. DS.'phpscripts'.DS.'htmltheme'.DS.'step2wealth');
}else{
    defined('MAINDIR') ? null : define('MAINDIR', "step2wealth");//
    defined('SITE_ROOT') ? null:define('SITE_ROOT',"E:".DS."HostingSpaces".DS."zmahmood".DS."ryan.infusionsoftdevelopers.com".DS."wwwroot".DS.MAINDIR);
    
}
//------------------------------------------------------------------
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');
//-------------------------------------------------------------------
// load config file first
require_once(LIB_PATH.DS.'constants.php');
// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'functions.php');

// load core objects
require_once(LIB_PATH.DS.'session.php');
require_once (LIB_PATH.DS.'isSDK/isdk.php');
include_once (LIB_PATH.DS."contacts.php");
global $currentUrl;
$currentUrl = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
global $currentPage;
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>