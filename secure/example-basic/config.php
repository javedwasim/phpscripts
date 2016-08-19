<?php
/**
 * For Development Purposes
 */
ini_set("display_errors", "on");

require __DIR__ . "/../class.logsys.php";

\Fr\LS::config(array(
  "db" => array(
    "host" => "localhost",
    "port" => 3306,
    "username" => "root",
    "password" => "",
    "name" => "library",
    "table" => "users"
  ),
  "features" => array(
    "auto_init" => true
  ),
  "pages" => array(
    "no_login" => array(
      "/phpscripts/secure/",
      "/phpscripts/secure/example-basic/reset.php",
      "/phpscripts/secure/example-basic/register.php"
    ),
    "login_page" => "/phpscripts/secure/example-basic/login.php",
    "home_page" => "/phpscripts/secure/example-basic/home.php"
  )
));
