<?php
@session_start();

//DATABASE DETAILS 
//SET HOSTNAME
$hostname = "localhost";	

//MYSQL USERNAME
$username ="root";	

//MYSQL PASSWORD
$password="";

//MYSQL DATABASE NAME
$database="test";

//DATABASE CONNECTION

mysql_connect($hostname,$username,$password) or die(mysql_error());
mysql_select_db($database) or die(mysql_error());

unset($hostname);
unset($username);
unset($password);
unset($database);

//DATABASE CONNECTION CODE END


/*SET THE DEFAULT PAGE PER RECORD LIMIT*/
if(!isset($_SESSION['pagerecords_limit']))
{
	$_SESSION['pagerecords_limit']=20;
}

// TABLE PREFIX
define("TABLE_PREFIX","bh_");	//DATABASE TABLE PREFIX IF YOU HAVE SET LIKE : bh_user_master. => "bh_" otherwise leave it blank.

/* php.ini DEFAULT SETTINGS OVER-RIDE*/
ini_set("error_reporting", "1");

?>