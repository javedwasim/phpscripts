<?php
include ("search.class.php");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myapp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM tbl_users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       // echo "id: " . $row["uId"]. " - Name: " . $row["firstName"]. " " . $row["lastName"]. "  userType: ". $row["userType"]."<br>";
    }
} else {
    echo "0 results";
}

//$array_holder  is an array with its keys as the column fields and the values those are posted by the user... you can add you table fields to this array and assign the value posted by the user. If the user did not select any option then the value should be "" i.e. <option value = ""> SELECT </option>
$array_holder = array();
$array_holder['firstName'] = 'Arcadia';
$array_holder['lastName'] = 'Ewell';
$array_holder['userName'] = 'aewell1';

$result =search::guerygen("tbl_users", $array_holder);

print_r($result);

$conn->close();
?>