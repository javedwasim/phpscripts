<html>
<head>
<title>Test of Class : mysqlForm</title>
<style type="text/css">
h2{font-family:verdana;font-size: 18px; color:#003300; font-weight: bold;}
form{color:#006600;font-family: verdana; font-size: 12px;
     display: block;}
td {background-color: #fafafa; color:#006600;
    font-family: verdana; font-size: 10px;}
th {background-color: #007700;color:#ffffff;
    font-family: verdana; font-size: 12px;font-weight:bold;}    
table {border: 1px solid green;,background-color: #aaaaaa;}    
input,select,textarea{font-family: verdana; font-size: 10px; font-weight: bold;
              background-color: #eeffee; color: #006600;border: 1px solid green;}    
</style>
</head>

<body>
<?php

//**** IMPORTENT : To test this file you must look over connection values in conn.php ***

include "conn.php";
include "mysqlForm.class.php";

//Creating mysqlForm class object
$mf=new mysqlForm($link,$database);

$result=mysql_query("select * from $table ",$link);

echo "<h2>Printing Table (using printResult method)</h2>";
// Printing a result set as table with 'printResult' method
// Argument 1 : the result resource. such as : $result
// Argument 2 : (Optional) format of table. such as : "border=1,cellpadding=2" 
$mf->printResult($result,"border=0, cellpadding=3, cellspacing=1");

echo "<h2>Creating Form (using printForm method)</h2>";
// Creating a form with 'printForm' method
// Argument 1 : Table name
// Argument 2 : Action of form. Default method is POST 
// Argument 3 : (Optional)Index of fields which hava not to 
//              appear as form field. Comma separated string format.
//              such as : "0,4,6" 
//              it skips 0,4 and 6 indexd columns of table     

$mf->printForm("$table","insert.php",'0');

?>

<table cellspacing=""></table>
</body>
</html>