<?php
$style = 'indian';
$mysql_db = 'blog';
$mysql_login = 'trizer';
$mysql_password = 'tkiller';
$mysql_host = 'localhost';
$title = 'ABUKSIGUN';
$logo = 'data/abuksigun_logo.png';
$debug = true;

//Default page language:
//empty - English [default]
//RU - Russian
$lang = ""; 

if (file_exists("config.php"))
	include_once("config.php");
