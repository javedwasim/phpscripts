<?php
	
	$content  = '';
	$id = $_GET['spanId'];
		
	switch ($id) {
		
		case 'r1c1':
				$content = file_get_contents('Row1Col1.txt', 'r') or die("Failed to read from : Row1Col1.txt");				
				echo $content;
			break;			
		
		case 'r1c2':
				$content = file_get_contents('Row1Col2.txt', 'r') or die("Failed to read from : Row1Col2.txt");				
				echo $content;
			break;			
		
		case 'r2c1':
				$content = file_get_contents('Row2Col1.txt', 'r') or die("Failed to read from : Row2Col1.txt");				
				echo $content;
			break;			
		
		case 'r2c2':
				$content = file_get_contents('Row2Col2.txt', 'r') or die("Failed to read from : Row2Col2.txt");				
				echo $content;
			break;			
		
		default;		
			die ("Uncaught exception in ".__FILE__." at ".__LINE__);
	}
?>