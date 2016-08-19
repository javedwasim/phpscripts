<?php

/********************************************************************
*  This file contains a class which Creats form  for mysql table	*	
*  Date   : 29th Jan,2007											*
*  Author : Anis uddin Ahamd     									*
*  Mail   : anisniit@gmail.com										*
* 																	*
* *******************************************************************	
*    Licence:  GNU General Public License							*
*																	*
*   This program is distributed in the hope that it will be useful,	*	
*   but WITHOUT ANY WARRANTY; without even the implied warranty of	*
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the	*
*   GNU General Public License for more details.					*											*
****************************************************************** */


class mysqlForm
{
var $link;
var $db;	
	function mysqlForm($linkname,$dbname)
	{
		$this->link=$linkname;
		$this->db=mysql_select_db($dbname,$this->link);
	} 

//Prints result set as a table	
function printResult($result,$format="border=1")
{
if($result)
	{
	echo "<table $format><tr>";	
	$totalField=mysql_num_fields($result);
	
	//printing heading
	for($i=0;$i < $totalField ; $i++)
		echo "<th>".mysql_field_name($result,$i) ."</th>";
	echo "</tr>";	
	
	//Printing rows
	while ($row = mysql_fetch_array($result,MYSQL_NUM))
		{
		echo "<tr>";
			foreach($row as $v)
			{
			echo "<td>". $v ."</td>";	
			} 
		echo "</tr>";	
		}
	echo "</table>";		
	}
else
	{
		echo "Sorry! Not a valid result set: ".mysql_error();
	}		
}//end of printResult	

//Create combobox for enumaration fields
function createList($type,$name)
{
	$ENUMvalues=substr($type,5,strlen($type)-6);
	echo "<select name=$name>";
	foreach(explode(',',$ENUMvalues) as $val)
	{
		$fieldValue=substr($val,1,strlen($val)-2);
		echo "<option value='$fieldValue'>$fieldValue</option>";
	} 
	echo "</select>";
	
}


//Prints form for a table
function printForm($table,$action,$skip="-1")
{
$result=mysql_query("Select * from  $table limit 0,1",$this->link);	
if($result)
	{
	$skipfields=explode(',',$skip);
	$stracture=mysql_query("describe $table",$this->link);	
	$isEnum=false;
	
		
	echo "<form name=anisForm action='$action' method=post>";	
	echo "<table border=0 cellpadding=3 cellspacing=0>";	
	
	//Printing Fields
	$totalField=mysql_num_fields($result);
	
	//printing heading
	for($i=0;$i < $totalField ; $i++)
	{
	//If this field to avoid cresting input field	
	if(in_array($i,$skipfields))
		continue;

	//Detacting if this field is ENUM	
	$type=mysql_result($stracture,$i,1);
	if(strpos($type,'enum')===false)
	 	$isEnum=false;
	 else
	 	$isEnum=true;
			
		
	echo "<tr>";
	$fieldname=mysql_field_name($result,$i);
	$fieldlength=mysql_field_len($result,$i);
	$fieldtype=mysql_field_type($result,$i);
	
		echo "<td align=left>".mysql_field_name($result,$i) ."</td>";
		echo "<td align=left> &nbsp;&nbsp;&nbsp;";
		
		if($isEnum) $this->createList($type,$fieldname);
		else if($fieldname=='password')
			echo "<input type=password name=$fieldname size=20>";
		else if($fieldlength>50)
			echo "<textarea rows='5' cols='50' wrap='virtual' name=$fieldname ></textarea>";
		else
			echo "<input type=text name=$fieldname size=".($fieldlength+5)*1 .">";
		echo "</td>";
	echo "</tr>";	
	}
	echo "<tr> <td colspan=2>  <div align=center>
			<input type=Submit value=Submit>
	        <input type=reset value=Reset>
		</div></td></tr>";	
	echo "</table>";
	echo "</form>";		
	}
else
	{
		echo "Sorry! Not a valid result set";
	}		
}//end of printForm


 

}//end of class
?>