File Structure : 

1. config.php : Configuration for the script
2. database.php : Database for the test 
3. user.php : Example script with Add, Edit, Records Display, Delete, Active/Inactive Change Status and Pagination methods
4. class/Main.class.php : Class file for all the important methods


Methods in the Class : 

1) RedirectPage($url) : 
Parameter(s) : 
1 : url (string) => The file name or the url where you want to redirect the user
Details : The method will redirect to the give url. 
Example : $Main->RedirectPage("userdetails.php");

===========================

2) ViewLink($id) : 
Details : The method will generate VIEW action like user.php?action=view&id=1. You just need to provide the PRIMARY KEY/ID of the record which you want to display.
Parameter(s) : 
1 : id (integer) => The primary key for the record which you want to get details.
Example : <a href="<?php echo $Main->ViewLink(1); ?>">View Details</a>
Output : user.php?action=view&id=1

===========================

3) EditLink($id) : 
Details : The method will generate EDIT action like user.php?action=edit&id=1. You just need to provide the PRIMARY KEY/ID of the record which you want to edi the record.
Parameter(s) : 
1 : id (integer)=> The primary key for the record which you want to get and edit details.
Example : <a href="<?php echo $Main->EditLink(1); ?>">Edit</a>
Output : user.php?action=edit&id=1

===========================

4) StatusChangeLink($id,$currentstatus) : 
Details : The method will generate STATUS CHANGE action like user.php?action=action&id=1&status=0. You just need to provide the PRIMARY KEY/ID of the record which you want to change the active/inactive status of the record. This method will generate two links for the record. One for Active Status and onther for Inactive Status
Parameter(s) : 
1 : id  (integer)=> The primary key for the record which you want to change the status.
2 : current status  (integer) => if you have set with 0 as inactive and 1 as active status. You need to pass the current status of the record.
Example : <?php echo $Main->StatusChangeLink(1,0); ?>
Output : 
1 : <a href="user.php?action=status&id=1&status=0">Active</a> : If the record has active status, this link will be used to inactive the same.
2 : <a href="user.php?action=status&id=1&status=1">Inactive</a> : If the record has inactive status, this link will be used to active the same.

===========================

5) StatusLink($id,$status) : 
Details : The method will generate STATUS action like user.php?action=status&id=1&status=0. You just need to provide the PRIMARY KEY/ID of the record which you want to edi the record.
Parameter(s) : 
1 : id  (integer)=> The primary key for the record which you want to change the status.
2 : status  (integer) => status which you want to change 
Example : <a href="<?php echo $Main->StatusLink(1,0); ?>">Change to Inactive </a>
Output : user.php?action=status&id=1&status=0

===========================

6) DeleteLink($id) : 
Details : The method will generate DELETE action like user.php?action=delete&id=1. You just need to provide the PRIMARY KEY/ID of the record which you want to edi the record.
Parameter(s) : 
1 : id (integer)=> The primary key for the record which you want to delete
Example : <a href="<?php echo $Main->DeleteLink(1); ?>">Edit</a>
Output : user.php?action=delete&id=1

===========================

7) SendMail($mailto,$subject,$message,$attachments="") : 
Details : The method will send mail using PHP mail() function. you can also change it with SMTP.
Parameter(s) : 
1 : $mailto (string)=> Email Address to send the mail
2 : $subject (string)=> Subject for the mail
3 : $message (string)=> Message for the Mail.
4 : $attachments (string)=> Attachment for the Mail. If you want to attach any file, provide the file path for the same.
Example : 
<?php
$mailto = "bharatparmar383@gmail.com";
$subject = "Test Subject";
$message = "Test Message";
$Main->SendMail($mailto,$subject,$message,$attachments="");
?>

===========================

8) GetRandomString($length,$type=0) 
Details : The method will generate the randon string which you can use for verification code or any other.
Parameter(s) : 
1 : $length (integer)=> String Length which you want. 
2 : $type (integer)=> 0 for alpha-numeric, 1 for numberic only and 2 for alpha only. By Default 0 will be set.

Example : 
<?php $Main->GetRandomString(10) ?> => AK76D2s9mh
<?php $Main->GetRandomString(4,1) ?> => 8169
<?php $Main->GetRandomString(5,2) ?> => mdiwl

===========================

9) InsertRecord($tablename, array $values)
Details : The method will insert record to given table name. You just need to provide the table name and the array with fields and value. This will return the Last Insert Id for the record. The fields which are given, will be added only.

Parameter(s) : 
1 : $tablename (string) : "user_master". Please note that if you have already set the TABLE_PREFIX in the config.php file, you need not to add that prefix here. 
2 : $array (array)=> array("field1"=>"value1", "field2"=>"value2");

Example : 
<?php
$password = md5("12345");
$info_array = array("username"=>"bharat383","password"=>$password,"email"=>"bharatparmar383@gmail.com");
$insert_id = $Main->InsertRecord("user_master", $info_array);
?>

Output : Last insert id for the record.

===========================

10) InsertMultipleRecord($tablename,$fieldarray,$valuearray)
Details : The method will insert multiple records to given table name. You just need to provide the table name and the array of fields name and array values. This will return the number of records added to the table. The fields which are given, will be added only.

Parameter(s) : 
1 : $tablename (string) : "user_master". Please note that if you have already set the TABLE_PREFIX in the config.php file, you need not to add that prefix here. 
2 : $fieldarray (array)=> array("field1", "field2");
3 : $valuearray (array)=> array(
	[0]=>array("value1", "value2"),
	[1]=>array("value11", "value12"),
	[2]=>array("value21", "value22"),
	[3]=>array("value31", "value32")
);

Example : 
<?php
$fieldarray = array("username","password","email");
$valuearray (array)=> array(
	[0]=>array("test1", "123456", "test1@mail.com"),
	[1]=>array("test2", "123456", "test2@mail.com"),
	[2]=>array("test3", "123456", "test3@mail.com"),
	[3]=>array("test4", "123546", "test4@mail.com")
);
$total = InsertMultipleRecord("user_master",$fieldarray,$valuearray);
?>
Output : Number of records addd with this method.

===========================

11) GetSingleRecord($tablename,array $array)
Details : The method will return the details of the single record in the array format as per your 2nd parameter.

Parameter(s) : 
1 : $tablename (string) : "user_master". Please note that if you have already set the TABLE_PREFIX in the config.php file, you need not to add that prefix here. 
2 : $array (array) : 
2.1 fields => Fields which you want to retrive. If you want to retrive all fields value, just leave it blank or use "*" for the same. By default it will take "*" for the same.
2.2 where : where condition of you query in simple plain text like "user_id=1 and active_status=1". Do not use "where" here.

Example : 
<?php 
$info_array = array("where"=>"user_id=1");
$userdata = $Main->GetSingleRecord("user_master",$info_array); 
?>

Return :
Array => array("username"=>"bharat383","password"="12345","email"=>"bharatparmar383@gmail.com","active_status"="1")

===========================

12) GetRecord($tablename,array $array)
Details : The method will return the details of the records in the array format as per your 2nd parameter.

Parameter(s) : 
1 : $tablename (string) : "user_master". Please note that if you have already set the TABLE_PREFIX in the config.php file, you need not to add that prefix here. 
2 : $array (array) : 
2.1 fields => Fields which you want to retrive. If you want to retrive all fields value, just leave it blank or use "*" for the same. By default it will take "*" for the same.
2.2 where (string) : where condition of you query in simple plain text like "user_id=1 and active_status=1". Do not use "where" here.
2.3 orderby (string) : order by field name
2.4 ordertype  (string) : order type (asc or desc)
2.5 limit  (integer) : number of records
2.6 startfrom  (string) : start number of record
2.7 groupby (string) : group by field name


Example : 
<?php 
$info_array = array("where"=>"active_status=1");
$userdata = $Main->GetRecord("user_master",$info_array); 
?>

Return :
Array => array(
[0]=>array("username"=>"bharat383","password"="12345","email"=>"bharatparmar383@gmail.com","active_status"="1"),
[1]=>array("username"=>"test1","password"="12345","email"=>"test1@gmail.com","active_status"="1")
[2]=>array("username"=>"test2","password"="12345","email"=>"test2@gmail.com","active_status"="1")
);

13) PagiNation($tablename,$primarykey)
Details : The method will display the pagination button/link

Parameter(s) : 
1 : $tablename (string) : "user_master". Please note that if you have already set the TABLE_PREFIX in the config.php file, you need not to add that prefix here. 
2 : $primarykey (string) : primary key which can be count.

Example : 
<?php $Main->Pagination("user_master","user_id"); ?>

===========================

14) UpdateRecord($tablename,array $array, $where="")
Details : The method will update the records.
Parameter(s) : 
1 : $tablename (string) : "user_master". Please note that if you have already set the TABLE_PREFIX in the config.php file, you need not to add that prefix here. 
2 : $array (array)=> array("field1"=>"value1", "field2"=>"value2");
3 : $where (string) : where conditions

Example : 
<?php $Main->UpdateRecord("user_master",$array, $where="user_id='1'"); ?>

Return/Output : This method will return you the number of updated records.

===========================

15) DeleteRecord($tablename,$where="",$limit=0)
Details : The method will delete the records from the table.
Parameter(s) : 
1 : $tablename (string) : "user_master". Please note that if you have already set the TABLE_PREFIX in the config.php file, you need not to add that prefix here. 
2 : $where (string) : where conditions
3 : $limit (integer) : number of records to be delete.

Example : 
<?php $Main->DeleteRecord("user_master",$where="user_id='1'"); ?>

Return/Output : This method will return you the number of deleted records.

===========================

16) GetCustom($query_string)
Details : The method will return array as per your query. You can define here any custom, join query.
Parameter(s) : 
1 : $query_string (string) : MySQL query string.

Example : 
<?php $Main->GetCustom("select * from hm_user_master"); ?>

Return/Output : This method will return you the number of records in array.

===========================


17) UploadFile($files,array $array)
Details : The method will upload the file/files which you want to upload
Parameter(s) : 
1 $files (array) : $_FILES which has been used for the upload file.
2 $array : your upload file settings
2.1 uploadpath (string) : upload directory path
2.2 filetype (array) : file types array which you want to allow.
2.3 maxsize (integer) : file size to max size

Example : 
<?php $Main->UploadFile($_FILES['profile_picture'],$array); ?>

Return/Output : This method will return files name which has been uploaded. It will rename the file name.

===========================

18) DeleteFile(array $array)
Details : The method will upload the file/files which you want to upload
Parameter(s) : 
1 $array : your file settings
1.1 $files (array) : file name which you want to remove. You can remove multiple files.
1.2 uploadpath (string) : directory path from where you want to delete the file

Example : 
<?php $Main->DeleteFile($array); ?>

Return/Output : This method will return number of deleted file.

===========================

19) DateDifference($date1,$date2)
Details : The method will return you the array of two dates difference in hours and days
Parameter(s) : 
1 $date1 : First Date
1 $date2 : Second Date


Example : 
<?php $Main->DateDifference("2015-09-21 12:30:00","2015-09-25 19:00:00"); ?>

Return/Output : This method will return hours and days difference.

===========================





