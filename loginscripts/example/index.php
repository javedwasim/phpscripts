<?php require_once('user.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta http-equiv="Content-Language" content="en-us" />
	<title>Index Page</title>
	<link rel="stylesheet" type="text/css" href="/login.css" />
</head>

<body>
	<div>
<?php
	if($user->logged_in()):
?>
		<p>You are logged in as <?php echo $_SESSION['user']['name']; ?>. <a href="/logout">Log out</a>, <a href="/manage">Manage your account</a>, or <a href="/change">Change your password</a></p>
<?php
	endif;
	if(!$user->logged_in()):
?>
		<p>You are not logged in. <a href="/login">Log in now</a> or <a href="/signup">Sign up</a></p>
<?php
	endif;
?>
	</div>
</body>

</html>