<?php
$link = mysqli_connect('localhost', 'root', '', 'test');
if($link->connect_error){
    die('Connection Failed. '.$link->connect_error);
}
if (isset($_GET['term'])){
    $return_arr = array();
    $term = $_GET['term'];
    $sql= "select login from users where login LIKE '".$term."%'";
    $result = mysqli_query($link, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $return_arr[] = $row['login'];
    }
    echo json_encode($return_arr);
}
?>