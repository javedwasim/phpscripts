<!-- begin of generated class -->
<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        users
* GENERATION DATE:  31.08.2015
* CLASS FILE:       C:\xampp\htdocs\phpcodegenier\sqlgenerator/generated_classes/class.users.php
* FOR MYSQL TABLE:  users
* FOR MYSQL DB:     test
* -------------------------------------------------------
* CODE GENERATED BY:
* MY PHP-MYSQL-CLASS GENERATOR
* from: >> www.voegeli.li >> (download for free!)
* -------------------------------------------------------
*
*/

//include_once("../resources/class.database.php");

// **********************
// CLASS DECLARATION
// **********************

class users
{ // class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************

var $id;   // KEY ATTR. WITH AUTOINCREMENT

var $login;   // (normal Attribute)
var $pw;   // (normal Attribute)
var $real_name;   // (normal Attribute)
var $extra_info;   // (normal Attribute)
var $email;   // (normal Attribute)
var $tmp_mail;   // (normal Attribute)
var $access_level;   // (normal Attribute)
var $active;   // (normal Attribute)

var $database; // Instance of class database


// **********************
// CONSTRUCTOR METHOD
// **********************

function users()
{

$this->database = new Database();

}


// **********************
// GETTER METHODS
// **********************


function getid()
{
return $this->id;
}

function getlogin()
{
return $this->login;
}

function getpw()
{
return $this->pw;
}

function getreal_name()
{
return $this->real_name;
}

function getextra_info()
{
return $this->extra_info;
}

function getemail()
{
return $this->email;
}

function gettmp_mail()
{
return $this->tmp_mail;
}

function getaccess_level()
{
return $this->access_level;
}

function getactive()
{
return $this->active;
}

// **********************
// SETTER METHODS
// **********************


function setid($val)
{
$this->id =  $val;
}

function setlogin($val)
{
$this->login =  $val;
}

function setpw($val)
{
$this->pw =  $val;
}

function setreal_name($val)
{
$this->real_name =  $val;
}

function setextra_info($val)
{
$this->extra_info =  $val;
}

function setemail($val)
{
$this->email =  $val;
}

function settmp_mail($val)
{
$this->tmp_mail =  $val;
}

function setaccess_level($val)
{
$this->access_level =  $val;
}

function setactive($val)
{
$this->active =  $val;
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id)
{

echo $sql =  "SELECT * FROM users WHERE id = $id;";
$result =  $this->database->query($sql);
$result = $this->database->result;
$row = mysql_fetch_object($result);

$this->id = $row->id;

$this->login = $row->login;

$this->pw = $row->pw;

$this->real_name = $row->real_name;

$this->extra_info = $row->extra_info;

$this->email = $row->email;

$this->tmp_mail = $row->tmp_mail;

$this->access_level = $row->access_level;

$this->active = $row->active;


}

// **********************
// DELETE
// **********************

function delete($id)
{
$sql = "DELETE FROM users WHERE id = $id;";
$result = $this->database->query($sql);

}

// **********************
// INSERT
// **********************

function insert()
{
$this->id = ""; // clear key for autoincrement

$sql = "INSERT INTO users ( login,pw,real_name,extra_info,email,tmp_mail,access_level,active ) VALUES ( '$this->login','$this->pw','$this->real_name','$this->extra_info','$this->email','$this->tmp_mail','$this->access_level','$this->active' )";
$result = $this->database->query($sql);
$this->id = mysql_insert_id($this->database->link);

}

// **********************
// UPDATE
// **********************

function update($id)
{



$sql = " UPDATE users SET  login = '$this->login',pw = '$this->pw',real_name = '$this->real_name',extra_info = '$this->extra_info',email = '$this->email',tmp_mail = '$this->tmp_mail',access_level = '$this->access_level',active = '$this->active' WHERE id = $id ";

$result = $this->database->query($sql);



}


} // class : end

?>
<!-- end of generated class -->
