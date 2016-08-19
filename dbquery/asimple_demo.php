<?php
// You have to include the class file asimple.php
require_once('asimple.php');

// Create the dataset
$dataset = new ASimpleMySQLDB(SIMPLE_DB_SERVER, SIMPLE_DB_NAME, SIMPLE_DB_USERNAME, SIMPLE_DB_PASSWORD);



// Populating a database

$inserts[] = array('name' => '1GB Jump Drive','description' => 'One Gigabyte USB Jump Drive','catID' => 1);
$inserts[] = array('name' => '2GB Jump Drive','description' => 'Two Gigabyte USB Jump Drive','catID' => 1);
$inserts[] = array('name' => '5GB Jump Drive','description' => 'Five Gigabyte USB Jump Drive','catID' => 1);
$inserts[] = array('name' => 'Wireless g Router','description' => 'Short Range Wireless Router','catID' => 2);
$inserts[] = array('name' => 'Wireless n Router','description' => 'Long Range Wireless Router','catID' => 2);

foreach($inserts as $insert) {

   // $dataset->insert_array('Items', $insert);
}

// =========================================================================

// Updating a recordset
$update = array('name' => 'Wireless N Router','description' => 'Super Long Range Wireless Router','catID' => 2);

//$dataset->update_array('Items', 'itemID', 5, $update);

// =========================================================================
echo '<pre>';
// Selecting a row from the database
$myItem = $dataset->get_record_by_ID('tbl_users', 'uId', 17);
echo $myItem['firstName']."\n";
echo $myItem['lastName']."\n";
echo "*********************************************\n";

// =========================================================================

// Selecting a group from the database
// Here you would be selecting all records in the wireless router category
$myItems = $dataset->get_records_by_group('tbl_users', 'uId', 17);

foreach($myItems as $myItem) {
    echo $myItem['firstName']."\n";
    echo $myItem['lastName']."\n";
    echo "=============================================\n";
}
echo "*********************************************\n";

?>