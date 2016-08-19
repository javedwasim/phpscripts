<?php
 /**
 *
 * Cpanel Cron Job Connector
 *
 * @class cronJob
 * @license       http://www.opensource.org/licenses/gpl-2.0.php GNU Public License
 * @copyright (c) Copyright 2011 Seyhun Cavus
 * @author        Seyhun Cavus  <http://www.seyhuncavus.com>
 * @version       1.0.0
 * @bugreport     <bugreport@seyhuncavus.com>
 */
 
/*------------------------------------------------------------------
Warning: You should get the xmlapi application before using this class.
https://github.com/CpanelInc/xmlapi-php/
----------------------------------------------
Useful functions for your api: getPreviousRunDate() , getNextRunDate()
https://github.com/mtdowling/cron-expression
----------------------------------------------
Here is available functions to use :
$CronJob = new cronJob;
$CronJob->addCronJob($minute,$hour,$day,$month,$weekday,$command);  // to add a cron job
$CronJob->removeCronJob($line); //to remove the specific cron job
$CronJob->getCronJob($line);   //to get the specific cron job as array  // $line is linekey or count
$CronJob->editCronJob($minute,$hour,$day,$month,$weekday,$command,$line);  // $line is linekey or count
$CronJob->getCronJobs();   //to get cron jobs as array
$CronJob->getErrors();     //to get errors as array
$CronJob->setDebug(true);  //to get errors as string
$CronJob->getLineKeys();   //to get linekeys as array, when there is an action as add or edit
$CronJob->DebugLineKeys();   //to get linekeys as string, when there is an action as add or edit
$CronJob->getEmail();   //to get email address
$CronJob->setEmail($email);   //to set email address
$CronJob->checkdns = true; //Add this line if you want to check the email address by dns
$CronJob->debug = true;       //helper parameter for setDebug(); 
$CronJob->keysdebug = true;   //helper parameter for DebugLineKeys();
------------------------------------------------------------------*/
  
 //Begin: Language Support
 define('ERROR_CRONJOB_EMAIL','Email value is not correct.');
 define('ERROR_CRONJOB_MINUTE','Minute value is not correct.');
 define('ERROR_CRONJOB_HOUR','Hour value is not correct.');
 define('ERROR_CRONJOB_DAY','Day value is not correct.');
 define('ERROR_CRONJOB_MONTH','Month value is not correct.');
 define('ERROR_CRONJOB_WEEKDAY','Weekday value is not correct.');
 define('ERROR_CRONJOB_COMMAND','Command value is not correct.');
 define('ERROR_CRONJOB_RESULTS','Parse error! Click <a href="#" onClick="document.location.reload();return false;">here</a> to refresh the page"');
 define('ERROR_CRONJOB_NOERR','No error found.');
 define('ERROR_CRONJOB_ID','Line(commandnumber) or linekey value is not correctly of cron job');
 define('ERROR_CRONJOB_SETTINGS_1','(ErrNo:1)Values are not correctly.');
 define('ERROR_CRONJOB_SETTINGS_2','(ErrNo:2)Values are not correctly.');
 define('ERROR_CRONJOB_SETTINGS_3','(ErrNo:3)Values are not correctly.');
 define('ERROR_CRONJOB_SETEMAIL','Cron Job Connector (set email): An error occured during parsing XML data. Please refresh the page and try again.');
 define('ERROR_CRONJOB_GETEMAIL','Cron Job Connector (get email): An error occured during parsing XML data. Please refresh the page and try again.');
 define('ERROR_CRONJOB_ADD','Cron Job Connector (add cron job): An error occured during parsing XML data. Please refresh the page and try again.');
 define('ERROR_CRONJOB_EDIT','Cron Job Connector (edit cron job): An error occured during parsing XML data. Please refresh the page and try again.');
 define('ERROR_CRONJOB_REMOVE','Cron Job Connector (remove cron job): An error occured during parsing XML data. Please refresh the page and try again.');
 define('ERROR_CRONJOB_NOKEY','No key found.');
 //End: Language Support
 
 @include('xmlapi.php');
 if (!class_exists('xmlapi', false)) {
   trigger_error('Unable to load class: xmlapi. <br />Download to use the lastest version of class xmlapi from <a href="https://github.com/CpanelInc/xmlapi-php/" target="blank">https://github.com/CpanelInc/xmlapi-php/</a>', E_USER_ERROR);
   exit;
 }
 class cronJob extends xmlapi {
  static private $ip = 'ip_is_here';
  static private $pass = 'password_is_here';
  static private $user = 'username_is_here';
  static private $account = 'account_name_is_here';   //that is the same as username for shared hosting users

  public $debug = false;
  public $keysdebug = false;
  public $checkdns = false;
  private $errors = array();
  private $linekeys = array();
  private $email = '';
  private $minute = '';
  private $hour = '';
  private $day = '';
  private $month = '';
  private $weekday = '';
  private $line = 0;
  private $linekey = '';
  
  function __construct() {
   $this->connect2cpanel();
  }
  private function connect2cpanel() {
   parent::__construct(self::$ip);
   parent::set_port(2082);
   parent::password_auth(self::$user,self::$pass);
   parent::set_output('xml');
   //parent::set_debug(1);
  }
  public function getErrors() {
   if(empty($this->errors))
     return false;
   return $this->errors;
  }
  public function setDebug($debug) {
   $this->debug = $debug;
   if ($this->debug === true) {
     $get = $this->getErrors();
	 if(is_array($get)) {
	   reset($get);
	   foreach($this->errors as $err) 
	     echo $err . '<br />' . PHP_EOL;
	 } else {
	   echo ERROR_CRONJOB_NOERR;
	 }
   }
  }
  public function DebugLineKeys($keysdebug) {
   $this->keysdebug = $keysdebug;
   if ($this->keysdebug === true) {
     $linekeys = $this->getLineKeys();
	 if(is_array($linekeys)) {
	  reset($linekeys);
	   while(list($action, $key) = each($linekeys)) {
        echo $action . ': ' . $key . '<br />' . PHP_EOL;
	   }
     } else {
       echo ERROR_CRONJOB_NOKEY;
     }
   }
  }
  public function getLineKeys() {
   if(!empty($this->linekeys))
     return false;
   return $this->linekeys;
  }
  public function setEmail($email) {
   $checked_email = $this->check_email($email);
   if ($checked_email===false) {
     array_push($this->errors, ERROR_CRONJOB_EMAIL);
     return false;
   }
   $this->email = $email;
   $xml = simplexml_load_string( 
                  parent::api2_query(self::$account, "Cron", "set_email",
                    array("email"=>$this->email)));
   if ($xml->event->result == '0') {
    array_push($this->errors, ERROR_CRONJOB_SETEMAIL);
    return false;
   }
   if ($xml->data->status == '0') {
    array_push($this->errors, $xml->data->statusmsg);
    return false; 
   }
   $this->email = $xml->data->email;
   return true;
  }
  public function getEmail() {
   $xml = simplexml_load_string( parent::api2_query(self::$account, "Cron", "get_email") );
   if ($xml->event->result == '0') {
    array_push($this->errors, ERROR_CRONJOB_GETEMAIL);
    return false;
   }
   $this->email = $xml->data->email;
   return $this->email;
  }
  public function addCronJob($minute,$hour,$day,$month,$weekday,$command) {
   $checkedTime = $this->checkCronTime(array($minute,$hour,$day,$month,$weekday));
   if ($checkedTime === false)
     return false;
   if (is_string($command)!==true) {
     array_push($this->errors, ERROR_CRONJOB_COMMAND);
     return false;
   }
   $this->command = trim(preg_replace(array('/ +/','/[<>]/'), array(' ', '_'), trim(stripslashes($string))));
   $xml = simplexml_load_string( 
                  parent::api2_query(self::$account, "Cron", "add_line",
                    array("minute"=>$this->minute,
                          "hour"=>$this->hour,
                          "day"=>$this->day,
                          "month"=>$this->month,
                          "weekday"=>$this->weekday,
                          "command"=>$this->command)));
   if ($xml->event->result == '0') {
    array_push($this->errors, ERROR_CRONJOB_ADD);
    return false;
   }
   if ($xml->data->status == '0') {
    array_push($this->errors, $xml->data->statusmsg);
    return false; 
   }
   array_push($this->linekeys, array('add', $xml->data->linekey));
   return true;
  }
  public function removeCronJob($line) {
   if(is_numeric($line)) {
    $this->line = $line;
    $xml = simplexml_load_string( 
                   parent::api2_query(self::$account, "Cron", "remove_line",
                     array("line"=>$this->line)));
    if ($xml->event->result == '0') {
     array_push($this->errors, ERROR_CRONJOB_REMOVE);
     return false;
    }
    if ($xml->data->status == '0') {
     array_push($this->errors, $xml->data->statusmsg);
     return false;
    }
    return true;
   }
   return false;
  }
  private function checkCronTime($_arr) {
   if (is_array($_arr)!==true) {
     array_push($this->errors, ERROR_CRONJOB_SETTINGS_1);   
     return false;
   }
   reset($_arr);
   if (sizeof($_arr)!=5) {
     array_push($this->errors, ERROR_CRONJOB_SETTINGS_2);   
     return false;
   }
   for($i=0; $i<sizeof($_arr); $i++) {
     if(is_string($_arr[$i])!==true && is_numeric($_arr[$i])!==true) {
	   array_push($this->errors, ERROR_CRONJOB_SETTINGS_3);
       return false;
     }
     else
       $_arr[$i] = preg_replace('@[^\*,\/\-a-zA-Z0-9]@', '', $_arr[$i]);
   }
   $this->minute = $_arr[0];
   $this->hour = $_arr[1];
   $this->day = $_arr[2];
   $this->month = $_arr[3];
   $this->weekday = $_arr[4];
   $checked_mi = $this->check_minute();
   $checked_h = $this->check_hour();
   $checked_d = $this->check_day();
   $checked_mo = $this->check_month();
   $checked_w = $this->check_weekday();
   switch(false){
    case $checked_mi: array_push($this->errors, ERROR_CRONJOB_MINUTE); break;
    case $checked_h: array_push($this->errors, ERROR_CRONJOB_HOUR); break;
    case $checked_d: array_push($this->errors, ERROR_CRONJOB_DAY); break;
    case $checked_mo: array_push($this->errors, ERROR_CRONJOB_MONTH); break;
    case $checked_w: array_push($this->errors, ERROR_CRONJOB_WEEKDAY); break;
   }
   if (sizeof($this->errors)>0)
    return false;
  }
  public function editCronJob($minute,$hour,$day,$month,$weekday,$command,$line) {
   if(is_numeric($line)===false && is_string($line)===false) {
     array_push($this->errors, ERROR_CRONJOB_ID);
     return false;
   }
   $line = preg_replace('@[^a-zA-Z0-9]@', '', $line);
   if(empty($line)) {
     array_push($this->errors, ERROR_CRONJOB_ID);
     return false;
   }
   if(strlen($line)==32)
    $line_arr = array("linekey"=>$linekey);
   else
    $line = preg_replace('@[^0-9]@', '', $line);
   if(!empty($line) && is_numeric($line))
    $line_arr = array("commandnumber"=>$line);
   else {
    array_push($this->errors, ERROR_CRONJOB_ID);
	return false;
   }
   $checkedTime = $this->checkCronTime(array($minute,$hour,$day,$month,$weekday));
   if ($checkedTime === false)
     return false;
   if (is_string($command)!==true) {
     array_push($this->errors, ERROR_CRONJOB_COMMAND);
     return false;
   }
   $this->command = trim(preg_replace(array('/ +/','/[<>]/'), array(' ', '_'), trim(stripslashes($string))));
   $parameters = array("minute"=>$this->minute,
                       "hour"=>$this->hour,
                       "day"=>$this->day,
                       "month"=>$this->month,
                       "weekday"=>$this->weekday,
                       "command"=>$this->command);
   $parameters = array_merge($parameters, $line_arr);
   $xml = simplexml_load_string( 
                  parent::api2_query(self::$account, "Cron", "edit_line",
                    $parameters));
   if ($xml->event->result == '0') {
    array_push($this->errors, ERROR_CRONJOB_EDIT);
    return false;
   }
   if ($xml->data->status == '0') {
    array_push($this->errors, $xml->data->statusmsg);
    return false;
   }
   array_push($this->linekeys, array('edit', $xml->data->linekey));
   return true;
  }
  public function getCronJob($line) { 
   if(is_numeric($line)===false && is_string($line)===false) {
     array_push($this->errors, ERROR_CRONJOB_ID);
     return false;
   }
   $line = preg_replace('@[^a-zA-Z0-9]@', '', $line);
   if(empty($line)) {
     array_push($this->errors, ERROR_CRONJOB_ID);
     return false;
   }
   if(strlen($line)!=32) {
    $line = preg_replace('@[^0-9]@', '', $line);
    if(empty($line)) {
     array_push($this->errors, ERROR_CRONJOB_ID);
	 return false;
    }
   }
   $xml = simplexml_load_string( parent::api2_query(self::$account, "Cron", "listcron") );
   if ($xml->event->result == '1') {
    $datas=array();
    foreach($xml->data as $data) {
      if (isset($data->linekey) && ($data->linekey == $line || $data->count == $line)) {  //fix for data->result
	   $datas['d'] = $data->day;
       $datas['h'] = $data->hour; 
       $datas['l'] = $data->linekey; 
       $datas['mo'] = $data->month; 
       $datas['mi'] = $data->minute; 
       $datas['w'] = $data->weekday; 
       $datas['c'] = $data->command;
       $datas['ch'] = $data->command_htmlsafe;
       $datas['co'] = $data->count;  //This can be use when that remove the cron job
      }
    }
   } else {
    array_push($this->errors, ERROR_CRONJOB_RESULTS);
	return false;
   }
   return $datas;
  }
  public function getCronJobs() {
   $xml = simplexml_load_string( parent::api2_query(self::$account, "Cron", "listcron") );
   if ($xml->event->result == '1') {
    $datas=array();
    $datas['d']=$datas['h']=$datas['l']=$datas['mo']=$datas['mi']=$datas['w']=$datas['c']=$datas['ch']=$datas['co']=array();
    foreach($xml->data as $data) {
      if (isset($data->linekey)) {  //fix for data->result
       array_push($datas['d'], $data->day); 
       array_push($datas['h'], $data->hour); 
       array_push($datas['l'], $data->linekey); 
       array_push($datas['mo'], $data->month); 
       array_push($datas['mi'], $data->minute); 
       array_push($datas['w'], $data->weekday); 
       array_push($datas['c'], $data->command);
       array_push($datas['ch'], $data->command_htmlsafe);
       array_push($datas['co'], $data->count);  //This can be use when that remove the cron job
      }
    }
   } else {
    array_push($this->errors, ERROR_CRONJOB_RESULTS);
	return false;
   }
   return $datas;
  }
  private function check_minute(){
   return $this->check_cron_field($this->minute,0,59);
  }
  private function check_hour(){
   return $this->check_cron_field($this->hour,0,23);
  }
  private function check_day(){
   return $this->check_cron_field($this->day,1,31);
  }
  private function check_month(){
   $month=strtolower($this->month);
   $month=str_replace('jan',1,$month);
   $month=str_replace('feb',2,$month);
   $month=str_replace('mar',3,$month);
   $month=str_replace('apr',4,$month);
   $month=str_replace('may',5,$month);
   $month=str_replace('jun',6,$month);
   $month=str_replace('jul',7,$month);
   $month=str_replace('aug',8,$month);
   $month=str_replace('sep',9,$month);
   $month=str_replace('oct',10,$month);
   $month=str_replace('nov',11,$month);
   $month=str_replace('dec',12,$month);
   return $this->check_cron_field($month,1,12);
  }
  private function check_weekday(){
   $weekday=strtolower($this->weekday);
   $weekday=str_replace('sun',0);
   $weekday=str_replace('mon',1);
   $weekday=str_replace('tue',2);
   $weekday=str_replace('wed',3);
   $weekday=str_replace('thu',4);
   $weekday=str_replace('fri',5);
   $weekday=str_replace('sat',6);
   return $this->check_cron_field($weekday,0,7);
  }
  private function check_cron_field($e,$g,$d){
   $f=explode(',', $e);
   for($c=0; $c<sizeof($f); $c++){
    if (!empty($f[$c])) {
	 if (strpos($f[$c], '-') !== false) { 
       $a = explode('-', $f[$c]);
       if(sizeof($a!=2))
         return false;
       if($this->check_cron_unit($a[0],$g,$d)===false)
         return false;
       if($this->check_cron_unit($a[1],$g,$d)===false)
         return false;
       $a[0]=intval($a[0]);
       $a[1]=intval($a[1]);
       if($a[0]>=$a[1])
         return false;
	 } else {
       if(strpos($f[$c],'/') !== false){
         $b=explode('/', $f[$c]);
         if(sizeof($b)!=2)
           return false;
         if($this->check_cron_unit($b[0],$g,$d,true)===false)
           return false;
         if($this->check_cron_unit($b[1],$g,$d)===false)
           return false;
       }else{
         if($this->check_cron_unit($f[$c],$g,$d,true)===false)
           return false;
       }
     }
    }
   }
   return true;
  }
  private function check_cron_unit($b,$d,$a,$c=false){
    if($c===true){
      if($b=='*')
       return true;
    }
    if(is_numeric($b) && ($b>=0 || $b<=9)){
      if($b>=$d && $b<=$a)
	    return true;
    }
    return false;
  }
  private function check_email($email) {
   if((is_string($email) && empty($email)) || (is_string($email) && strcasecmp($email,self::$user)=='0')) {
    return true;
   } elseif (is_string($email)) {
    $email = trim($email);
	$result = false;
    if (strlen($email)>255) {
      return false;
    } elseif (function_exists('filter_var') && defined('FILTER_VALIDATE_EMAIL')) {
      $result = (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    } else {
      if (substr_count($email,'@')>1) {
        return false;
      }
      if (preg_match("/[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/i",$email)) {
        $result = true;
      } else {
        return false;
      }
    }
    if ($result===true && $this->checkdns===true) {
      $domain = explode('@',$email);
      if (!checkdnsrr($domain[1], 'MX') && !checkdnsrr($domain[1], 'A')) {
        return false;
      }
    }
    return $result;
   } else {
    return false;
   }
  }
 } //->End of class
