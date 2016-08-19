<?php
	require 'query.php';
	
	$querObj =  new query();
	
	$result = $querObj->execute_requet('select login from users where id = 1');
	
	print_r($result);