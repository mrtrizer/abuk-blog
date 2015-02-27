<?php
function show_error($errorCode, $errorMessage = "")
{
	die('{"error_code":'.$errorCode.', "error_msg":"'.htmlspecialchars($errorMessage).'"}');
}

$args = NULL;

if (array_key_exists('func',$_POST))
	$args = $_POST;
else
	if (array_key_exists('func',$_GET))
		$args = $_GET;

if ($args == NULL)
	show_error(100);

require_once('default_config.php');

$link = mysql_connect($mysql_host, $mysql_login, $mysql_password)  or show_error(2);
mysql_set_charset('utf8',$link);
$selected = mysql_select_db($mysql_db, $link);

$func = preg_replace('/[^A-Za-z0-9\-]/', '', $args['func']);

if ($func == 'login')
{
	if (!array_key_exists('login',$args) || !array_key_exists('pass_hash',$args))
		show_error(1);

	$login = preg_replace('/[^A-Za-z0-9\-]/', '', $args['login']);
	$passHash = preg_replace('/[^A-Fa-f0-9\-]/', '', $args['pass_hash']);

	$result = mysql_query("SELECT `id`, `key`, `email`, `name` FROM user WHERE id='".$login."' and pass_hash=0x".$passHash, $link) or show_error(3,mysql_error($link));
	$row = mysql_fetch_array($result);

	if ($row == NULL)
		show_error(4,"Wrong user login or password.");

	$key = md5($passHash.$login.time().time());
	mysql_query("UPDATE user SET `key`=0x".$key." WHERE `id`='".$login."'",$link) or  show_error(5,mysql_error($link));

	echo '{"error_code":0, "key":"'.$key.'"}';
	exit;
}

if ($func == 'savearticle')
{
	if (!array_key_exists('id',$args) || 
			!array_key_exists('content',$args) || 
			!array_key_exists('key',$args) || 
			!array_key_exists('name',$args) || 
			!array_key_exists('about',$args))
		show_error(1);
		
	$id = preg_replace('/[^0-9\-]/', '', $args['id']);
	$content = urlencode(trim($args['content'],'"'));
	$key = preg_replace('/[^A-Fa-f0-9\-]/', '', $args['key']);
	$name = urlencode(trim($args['name'],'"'));
	$about = urlencode(trim($args['about'],'"'));
	
	if (($id == "") || ($key == ""))
		show_error(2,"Wrong arguments format");

	$result = mysql_query("SELECT `id`,`rights` FROM user WHERE `key`=0x".$key, $link) or show_error(3,mysql_error($link));
	$row = mysql_fetch_array($result);
	
	if ($row == NULL)
		show_error(666,"Access denied.");
		
	if ($row['rights'] != 'admin')
		show_error(667,"You must have administrator rigths to edit this article.");
		
	mysql_query("UPDATE article SET `content`='".$content."', `name`='".$name."', `about`='".$about."' WHERE `id`=".$id."",$link) or  show_error(5,mysql_error($link));
	
	echo '{"error_code":0}';
	exit;
}

if ($func == 'addcomment')
{
	if (!array_key_exists('name',$args) || 
			!array_key_exists('email',$args) || 
			!array_key_exists('text',$args) || 
			!array_key_exists('context',$args))
		show_error(1);
		
	$email = preg_replace('/[^A-Za-z0-9\-\@\.]/', '', $args['email']);
	$name = urlencode(trim($args['name'],'"'));
	$text = urlencode(trim($args['text'],'"'));
	$context = preg_replace('/[^0-9\-]/', '', $args['context']);
	
	mysql_query('INSERT INTO message (`name`,`email`,`text`,`context`) VALUES ("'.$name.'","'.$email.'","'.$text.'","'.$context.'")') or  show_error(5,mysql_error($link));
	$result = mysql_query('SELECT date FROM message WHERE id = '.mysql_insert_id()) or show_error(788,"Can't read a date!");
	
	$row = mysql_fetch_array($result);
	
	$date = $row['date'];
	
	echo '{"error_code":0, "email":"'.$email.'", "name":"'.$name.'", "text":"'.$text.'", "date":"'.$date.'"}';
	exit;
}

show_error(899,"Wrong function: ".$func);
