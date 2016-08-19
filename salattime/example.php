<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

<meta name="Subject" content="Muslim Prayer Times" />
<meta name="Description" content="Muslim Prayer Times" />
<meta name="Classification" content="PHP and Arabic Language" />
<meta name="Keywords" content="Muslim, Prayer, Times, PHP, Arabic, Language, Development, Implementation, Open Source, Free, GPL, Classes, Code" />
<meta name="Language" content="English, Arabic" />
<meta name="Author" content="Khaled Al-Shamaa" />
<meta name="Copyright" content="Khaled Al-Shamaa" />
<meta name="Designer" content="Khaled Al-Shamaa" />
<meta name="Publisher" content="Khaled Al-Shamaa" />
<meta name="Distribution" content="Global" />
<meta name="Robots" content="INDEX,FOLLOW" />
<meta name="City" content="Aleppo" />
<meta name="Country" content="Syria" />

<link rel="shortcut icon" href="../favicon.ico" />
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<title>Muslim Prayer Times</title>
</head>

<body>

<center>
<div style="width: 80%; position:absolute; left:10%; top:0%; z-index:1">
<br />
<div class="tabArea" align="center">
  <a class="tab" href="example.php">Example</a>
  <a class="tab" href="about.html">About</a>
  <a class="tab" href="http://www.ar-php.com">Homepage</a>
</div>

<div class="Paragraph">
<?php
// Create a list of Arab Country Capitals
$lines = file('ArabCapitals.txt');

$lat = array();
$long = array();
$combo = '<select name="city">';

foreach($lines as $line) {
    $line = trim($line);
    $info = split(',', $line);
    ($info[0] == isset($_POST['city']))? $x='selected' : $x='';
    $combo .= "<option value=\"{$info[0]}\" $x>{$info[0]} - {$info[1]}</option>\n";
    $lat[$info[0]] = $info[2];
    $long[$info[0]] = $info[3];
}

$combo .= '</select>';

$day = '<select name="day">';
for ($i = 1; $i < 32; $i++) {
    ($i == isset($_POST['day']))? $x='selected' : $x='';
    $day .= "<option $x>$i</option>";
}

$day .= '</select>';

$month = '<select name="month">';
for ($i = 1; $i < 13; $i++) {
    ($i == isset($_POST['month']))? $x='selected' : $x='';
    $month .= "<option $x>$i</option>";
}

$month .= '</select>';

$year = '<select name="year">';
for ($i = 2000; $i < 2011; $i++) {
    ($i == isset($_POST['year']))? $x='selected' : $x='';
    $year .= "<option $x>$i</option>";
}

$year .= '</select>';

$zone = '<select name="zone">';
for ($i = -8; $i <= 8; $i++) {
    ($i == isset($_POST['zone']))? $x='selected' : $x='';
    $zone .= "<option $x>$i</option>";
}

$zone .= '</select>';

if (isset($_POST['submit'])) {
    @ini_set('zend.ze1_compatibility_mode', '1');

    include('salat.class.php');
    $Salat = new Salat();

    $Salat->setLocation($long[$_POST['city']], $lat[$_POST['city']],
        $_POST['zone']);
    $Salat->setDate($_POST['day'], $_POST['month'], $_POST['year']);

    $times = $Salat->getPrayTime();

    echo"<b>Fajr:</b> {$times[0]}<br />";
    echo"<b>Sunrise:</b> {$times[1]}<br />";
    echo"<b>Zuhr:</b> {$times[2]}<br />";
    echo"<b>Asr:</b> {$times[3]}<br />";
    echo"<b>Maghrib:</b> {$times[4]}<br />";
    echo"<b>Isha:</b> {$times[5]}<br /><hr />";
}

?>
<form action="example.php" method="post">
<b>Select a city:</b> <?php echo $combo; ?><br /><br />
<b>Select a date:</b> <?php echo "$day / $month / $year"; ?><br /><br />
<b>Your time zone:</b> <?php echo $zone; ?><br /><br />
<input type="submit" name="submit" value="Prayer Times" />
</form>
</div>
<table border="0" cellspacing="0" align="left">
  <tr>
    <td bgcolor="#448800">&nbsp;&nbsp;</td>
    <td bgcolor="#66aa00">&nbsp;&nbsp;</td>
    <td bgcolor="#77bb00">&nbsp;&nbsp;</td>
    <td bgcolor="#aadd00">&nbsp;&nbsp;</td>
    <td bgcolor="#eeff66">&nbsp;&nbsp;</td>
  </tr>
</table>
</center>
          <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
          </script>
          <script type="text/javascript">
          _uacct = "UA-1268287-1";
          urchinTracker();
          </script>
</body>
</html>
