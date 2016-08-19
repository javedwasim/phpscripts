<?php 
$link = mysqli_connect('localhost', 'root', '', 'test');
if($link->connect_error){
    die('Connection failed: '.$con->connect_error);
}
$id = $_GET['id'];
$sql = "select * from users where id = ".$id;
$result = mysqli_query($link, $sql);
$num_rows = mysqli_num_rows($result);
if($num_rows>0){
    while($row = $result->fetch_assoc()){
?>
<table border="1">
    <tr>
        <th>User Name</th>
        <th>Email</th>
    </tr>
    <tr>
        <td><?php echo $row['login']; ?></td>
        <td><?php echo $row['email']; ?></td>
    </tr>
</table>
<?php    
}
}else{
        echo "0 result";
}

mysqli_close($link);
?>