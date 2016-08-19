<?php
require_once("table2arr.php");
$h="
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 3.2 Final//EN'>
<HTML>
<HEAD>
<TITLE>example</TITLE>
<META NAME='Generator' CONTENT='Wojar Software'>
<META NAME='Author' CONTENT='Wojtek Jarzecki'>
<META NAME='Keywords' CONTENT='php example'>
<META NAME='Description' CONTENT='php table2arr class example'>
</HEAD>

<BODY>
<TABLE ALIGN='left' BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH='100%'>
<TR ALIGN='left' VALIGN='middle'>
	<TD> Real Madrid - Barcelona </TD>
	<TD>0-0</TD>
        <TD>&nbsp;</TD>
	<TD>33</TD>
	<TD>34</TD>
	<TD>33</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>
";

$g= new table2arr($h);
$cnt=$g->tablecount;

print "<pre>";
for($i=0;$i<$cnt;$i++)
{
$g->getcells($i);
   print_r($g->cells);
}
print "</pre>";

?>