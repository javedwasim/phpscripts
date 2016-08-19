<?php
require_once("table2arr.php");
$h="
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 3.2 Final//EN'>
<HTML>
  <HEAD>
    <TITLE>
      example
    </TITLE>
    <META NAME='Generator' CONTENT='Wojar Software'>
    <META NAME='Author' CONTENT='Wojtek Jarzecki'>
    <META NAME='Keywords' CONTENT='php example'>
    <META NAME='Description' CONTENT='php table2arr class example'>
  </HEAD>
  <BODY>
    <!-- This table she has properties 'parent'=true // she has table as child-->
    <TABLE ALIGN='left' BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH='100%'>
      <TR ALIGN='left' VALIGN='middle'>
        <TD>
          Real Madrid - Barcelona
        </TD>
        <TD>
          0-0
        </TD>
        <TD>
          &nbsp;
        </TD>
        <TD>
          33
        </TD>
        <TD>
          34
        </TD>
        <TD>
          33
        </TD>
      </TR>
      <TR ALIGN='left' VALIGN='middle'>
        <TD>
          Real RWE - HSV
        </TD>
        <TD>
          1-2
        </TD>
        <TD>
          nix
        </TD>
        <TD>
          39
        </TD>
        <TD>
          24
        </TD>
        <TD>
          83
        </TD>
      </TR>
      <TR>
        <TD>
          <!-- This table she has properties 'parent'=false // not she has child table -->
          <TABLE ALIGN='left' BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH='100%'>
            <TR ALIGN='left' VALIGN='middle'>
              <TD>
                Integer Madrid - Clubcelona
              </TD>
              <TD>
                4-0
              </TD>
              <TD>
                &nbsp;
              </TD>
            </TR>
            <TR ALIGN='left' VALIGN='middle'>
              <TD>
                Echter RWE - Falscher HSV
              </TD>
              <TD>
                9-2
              </TD>
              <TD>
                nix
              </TD>
            </TR>
          </TABLE>
        </TD>
      </TR>
    </TABLE>
    <p>
      just another paragraph
    </p>
    <!-- This table she has properties 'parent'=true //  not she has child table-->
    <TABLE ALIGN='left' BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH='100%'>
      <TR ALIGN='left' VALIGN='middle'>
        <TD>
          Arsenal - Villareal
        </TD>
        <TD>
          1-0
        </TD>
        <TD>
          &nbsp;
        </TD>
      </TR>
      <TR ALIGN='left' VALIGN='middle'>
        <TD>
          Barcelona - AC Milan
        </TD>
        <TD>
          1-1
        </TD>
        <TD>
          nix
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
if (!$g->table[$i]["parent"])
// if not parent, not she has child table
   {
print "---cells of table $i----\n";
$g->getcells($i);
   print_r($g->cells);
   }
}

//print "--- display properties of all table -------\n";
//print_r($g->table);
//print "</pre>";

?>