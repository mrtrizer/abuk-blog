<?php
header("Content-Type: text/html; charset=utf-8");
require_once ('default_config.php');
require_once ('tools.php');

$args = $_GET;
if (!array_key_exists('page',$args))
	$page_name = 'main';
else
	$page_name = $args['page'];

$style_path = 'styles/'.$style.'/';

//Login
$link = mysql_connect($mysql_host, $mysql_login, $mysql_password)  or die("Unable to connect to MySQL");
mysql_set_charset('utf8',$link);
$selected = mysql_select_db($mysql_db, $link);

$request = sprintf('
	SELECT `name`,`file`,`description%s`
	FROM `pages`
	WHERE `name`="%s"',
	$lang,$page_name);
	
$result = mysql_query($request, $link) or die('Unable to find page.');

$row = mysql_fetch_array($result)  or die ('No pages with a name: '.$page_name);

$description = $row['description'.$lang];

$page_head_path = $row['file'];

$user = NULL;

if (isset($_COOKIE['key']) && (strlen($_COOKIE['key']) == 32)) 
{
	$key = htmlspecialchars($_COOKIE['key']);
	$result = mysql_query(sprintf("SELECT `id`, `key`, `email`, `name`, `rights` FROM `user` WHERE `key`=0x%s",$key), $link) or die('Unable to get a user.');
	$row = mysql_fetch_array($result);
	if ($row != NULL)
		$user = ['id' => $row['id'], 'email' => $row['email'], 'name' => $row['name'], 'rights' => $row['rights'], 'key' => $row['key']];
}

require_once ($style_path.'page.php');

mysql_close($link);
