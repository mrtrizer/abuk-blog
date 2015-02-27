<?php
header("Content-Type: text/html; charset=utf-8");
require_once ('default_config.php');
require_once ('tools.php');

//Page identification
$pages = [	'main' => 'main.php',
			'article_list' => 'article_list.php',
			'about' => 'about.php',
			'guest_book' => 'guest_book.php',
			'article' => 'article.php',
			'article_editor' => 'article_editor.php'];
			
$args = $_GET;
if (!array_key_exists('page',$args))
	$page_name = 'main';
else
	$page_name = $args['page'];

if (!array_key_exists($page_name,$pages))
{
	echo 'No pages with a name: '.$page_name;
	exit;
}

$style_path = 'styles/'.$style.'/';
$body_path = $pages[$page_name];

//Login
$link = mysql_connect($mysql_host, $mysql_login, $mysql_password)  or die("Unable to connect to MySQL");
mysql_set_charset('utf8',$link);
$selected = mysql_select_db($mysql_db, $link);

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
