<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Ajax Grid</title>

	<link href="ajaxgrid.css" rel="Stylesheet" type="text/css" />
	<script src="prototype.js" type="text/javascript"></script>
	<script src="ajaxgrid.js" type="text/javascript"></script>
</head>

<body>
	<center>
		<h1>Ajax Grid</h1>
	</center>
	<?php
	
	$textForRow1Col1 = file_get_contents('Row1Col1.txt') or die("Failed to read from the file: Row1Col1.txt");	
	$textForRow1Col2 = file_get_contents('Row1Col2.txt') or die("Failed to read from the file: Row1Col2.txt");	
	$textForRow2Col1 = file_get_contents('Row2Col1.txt') or die("Failed to read from the file: Row2Col1.txt");
	$textForRow2Col2 = file_get_contents('Row2Col2.txt') or die("Failed to read from the file: Row2Col2.txt");
	
	
	$idName1 = 'r1c1'; 
	$idName2 = 'r1c2';
	$idName3 = 'r2c1'; 
	$idName4 = 'r2c2';
	
	require_once('AjaxGrid.inc.php');	
	
	// Code to be written in grid (Row 1 and Column 1)
	$ajaxGrid = new AjaxGrid($textForRow1Col1, 'showText');
	$htmlCodeForRow1Col1 = $ajaxGrid->getAjaxGridCode($idName1);
	
	// Code to be written in grid (Row 1 and Column 2)
	$ajaxGrid = new AjaxGrid($textForRow1Col2, 'showText');
	$htmlCodeForRow1Col2 = $ajaxGrid->getAjaxGridCode($idName2);
	
	// Code to be written in grid (Row 1 and Column 2)
	$ajaxGrid = new AjaxGrid($textForRow2Col1, 'showText');
	$htmlCodeForRow2Col1 = $ajaxGrid->getAjaxGridCode($idName3);
	
	// Code to be written in grid (Row 2 and Column 2)
	$ajaxGrid = new AjaxGrid($textForRow2Col2, 'showText');
	$htmlCodeForRow2Col2 = $ajaxGrid->getAjaxGridCode($idName4);
	
	$outputCode = '<table width="400" border="1" align="center">
	
					<tr>
						<td> '.$htmlCodeForRow1Col1.'</td>
						
						<td> '.$htmlCodeForRow1Col2.'</td>
					</tr>
					<tr>
						<td> '.$htmlCodeForRow2Col1.'</td>
						
						<td> '.$htmlCodeForRow2Col2.'</td>
					</tr>
					
					</table>					
				  ';
	
	echo $outputCode;
	
	?>
	
</body>
</html>