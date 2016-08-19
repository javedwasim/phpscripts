<?php
if(isset($_POST['submit'])){
    
    $servername = $_POST['server_name'];
    $username = $_POST['user_name'];
    $password = $_POST['password'];
    $my_db = $_POST['my_db'];
     // Create connection
    $conn = new mysqli($servername, $username, $password,$my_db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql_select = "select * from scrap_register";
    $result = $conn->query($sql_select);
    
    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
            $password = md5($row['password']); 
            $sql = "UPDATE scrap_register SET password='{$password}' WHERE id={$row["id"]}"; 
            $conn->query($sql);
        }
        echo "Record updated successfully";
        
    } else {
        echo "0 results";
    }
    
}
?> 



<html>
<head>
<title>Database Connection</title>
<body>

<form method="post">
<!-- we will create registration.php after registration.html -->
Server Name:<input type="text" name="server_name" value=""></br>
User Name:<input type="text" name="user_name" value=""></br>
Password:<input type="text" name="password" value=""></br>
My Database:<input type="text" name="my_db" value=""></br>
<input type="submit" name="submit" value="submit">
</form>

</body>
</head>
</html>