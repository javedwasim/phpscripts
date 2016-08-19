<?php
include_once("conn.php");
$reg=ini_get('register_globals');
if($reg==0)//if register globals off
{
$user=$_POST['user'];	
$password=$_POST['password'];	
$name=$_POST['name'];
$Sex=$_POST['Sex'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$address=$_POST['address'];
$profession=$_POST['profession'];
$org=$_POST['org'];
}

//Field names are as there database column name
$sql="INSERT INTO `user` VALUES (0, '$user', '$password', '$name', '$Sex', '$email', '$phone', '$address', '$profession', '$org');";
$ins_result=mysql_query($sql,$link);
if($ins_result)
 include('test.php');
else
{
	echo "Something Wrong : Data not inserted!";
	include('test.php');
}	 
?>