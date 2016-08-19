<?php 
/*
Author : Anis uddin Ahmad <anisniit@gmail.com>
Date   : 29rd JAn, 2007
For    : Creating MYSql Form builder
*/
//*** BE SURE THAT, YOU HAVE EXECUTED THE mysqlForm.sql FILE ***//
//*** OTHERWISE EDIT VALUES ON THIS FILE                     ***// 

$database='ijt';
$table='contact';

$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
$db= mysql_select_db($database, $link);
?>