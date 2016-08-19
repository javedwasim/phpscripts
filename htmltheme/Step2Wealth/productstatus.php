<?php 
session_start();
$productid = $_REQUEST['productid'];
if (in_array($productid, $_SESSION['purchasedprod'])){echo 1;}else{echo "exit";}
?>

    