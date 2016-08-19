<?php 
include './cast128.php';
$example = new cast128;
echo $data= $example->encrypt("My Name is Javed and what is your's?", "MYKEY");
echo $example->decrypt($data, "");

?>