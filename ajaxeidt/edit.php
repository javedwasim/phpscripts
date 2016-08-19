<?php
	/**
	 * This file saves the edited text in the database/file
	 */
	
	
	/*
	if ($_POST['id'] == 'desc' ) {
		$fp = fopen('text.txt', 'w') or die("Failed to open file for writing.");
		$content = $_POST['content'];

		if(fwrite($fp, $content)) {
			echo $content;
		}
		else {
			echo "Failed to update the text";
		}
	}
	elseif ($_POST['id'] == 'desc2' ) {
		$fp = fopen('text2.txt', 'w') or die("Failed to open file for writing.");
		$content = $_POST['content'];
		if(fwrite($fp, $content)) {
			echo $content;
		}
		else {
			echo "Failed to update the text";
		}
	}
	*/
	
	$id = $_POST['id'];
	
	switch ($id) {		
		
		case 'r1c1':
				$fp = fopen('Row1Col1.txt', 'w') or die("Failed to open file for writing.");
				$content = $_POST['content'];
		
				if(fwrite($fp, $content)) {
					echo $content;
				}
				else {
					echo "Failed to update the text";
				}
				break;
		
		case 'r1c2':
				$fp = fopen('Row1Col2.txt', 'w') or die("Failed to open file for writing.");
				$content = $_POST['content'];
		
				if(fwrite($fp, $content)) {
					echo $content;
				}
				else {
					echo "Failed to update the text";
				}
				break;

		case 'r2c1':
				$fp = fopen('Row2Col1.txt', 'w') or die("Failed to open file for writing.");
				$content = $_POST['content'];
		
				if(fwrite($fp, $content)) {
					echo $content;
				}
				else {
					echo "Failed to update the text";
				}
				break;
		
		case 'r2c2':
				$fp = fopen('Row2Col2.txt', 'w') or die("Failed to open file for writing.");
				$content = $_POST['content'];
		
				if(fwrite($fp, $content)) {
					echo $content;
				}
				else {
					echo "Failed to update the text";
				}
				break;
				
			
		default:
			 die("Uncaught exception: ".__LINE__);
	}
?>