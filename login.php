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

	$request = sprintf('
		SELECT `id`, `key`, `email`, `name` 
		FROM `user` 
		WHERE `id`="%s" and `pass_hash`=0x%s',$login,$passHash);

	$result = mysql_query($request, $link) or show_error(3,mysql_error($link));
	$row = mysql_fetch_array($result);

	if ($row == NULL)
		show_error(4,"Wrong user login or password.");

	$key = md5($passHash.$login.time().time());
	
	$request = sprintf('
		UPDATE `user` 
		SET `key`=0x%s 
		WHERE `id`="%s"',
		$key,$login);
	
	mysql_query($request,$link) or  show_error(5,mysql_error($link));

	echo '{"error_code":0, "key":"'.$key.'"}';
	exit;
}

if ($func == 'deletearticle')
{
	if (!array_key_exists('id',$args) || 
			!array_key_exists('key',$args))
		show_error(1);
		
	$id = preg_replace('/[^0-9\-]/', '', $args['id']);
	$key = preg_replace('/[^A-Fa-f0-9\-]/', '', $args['key']);
	
	if (($id == "") || ($key == ""))
		show_error(2,"Wrong arguments format");

	$request = sprintf('
		SELECT `id`,`rights` 
		FROM `user` 
		WHERE `key`=0x%s',
		$key);
		
	$result = mysql_query($request, $link) or show_error(3,mysql_error($link));
	$row = mysql_fetch_array($result);
	
	if ($row == NULL)
		show_error(666,"Access denied.");
		
	if ($row['rights'] != 'admin')
		show_error(667,"You have to be an administrator to delete this article.");
		
	$request = sprintf('
		DELETE FROM `article` 
		WHERE `id`=%d',
		$id);
		
	mysql_query($request, $link) or  show_error(5,mysql_error($link));
	
	echo '{"error_code":0, "id":'.$id.'}';
	exit;
}

if ($func == 'hidearticle')
{
	if (!array_key_exists('id',$args) || 
			!array_key_exists('key',$args))
		show_error(1);
		
	$id = preg_replace('/[^0-9\-]/', '', $args['id']);
	$key = preg_replace('/[^A-Fa-f0-9\-]/', '', $args['key']);
	
	if (($id == "") || ($key == ""))
		show_error(2,"Wrong arguments format");

	$request = sprintf('
		SELECT `id`,`rights` 
		FROM `user` 
		WHERE `key`=0x%s',
		$key);
		
	$result = mysql_query($request, $link) or show_error(3,mysql_error($link));
	$row = mysql_fetch_array($result);
	
	if ($row == NULL)
		show_error(666,"Access denied.");
		
	if ($row['rights'] != 'admin')
		show_error(667,"You have to be an administrator to change visibility of this article.");
		
	$request = sprintf('
		SELECT `visible` 
		FROM `article` 
		WHERE `id`=%d',
		$id);
		
	$result = mysql_query($request, $link) or  show_error(5,mysql_error($link));
	
	$visible = ord(mysql_fetch_array($result)['visible']);	
		
	$request = sprintf('
		UPDATE `article` 
		SET `visible`=%d
		WHERE `id`=%d',
		!$visible,$id);
		
	mysql_query($request, $link) or  show_error(5,mysql_error($link));
	
	echo '{"error_code":0, "id":'.$id.', "visible":'.($visible == 1?'false':'true').'}';
	exit;
}

if ($func == 'savearticle')
{
	if (!array_key_exists('id',$args) || 
			!array_key_exists('content',$args) || 
			!array_key_exists('key',$args) || 
			!array_key_exists('name',$args) || 
			!array_key_exists('about',$args) || 
			!array_key_exists('image',$args) || 
			!array_key_exists('keywords',$args))
		show_error(1);
		
	$id = preg_replace('/[^0-9\-]/', '', $args['id']);
	$content = urlencode(trim($args['content'],'"'));
	$key = preg_replace('/[^A-Fa-f0-9\-]/', '', $args['key']);
	$name = urlencode(trim($args['name'],'"'));
	$about = urlencode(trim($args['about'],'"'));
	$image = trim($args['image'],'"');
	$keywords = urlencode(trim($args['keywords'],'"'));
	
	if (($id == "") || ($key == ""))
		show_error(2,"Wrong arguments format");

	$request = sprintf('
		SELECT `id`,`rights` 
		FROM `user` 
		WHERE `key`=0x%s',
		$key);
		
	$result = mysql_query($request, $link) or show_error(3,mysql_error($link));
	$row = mysql_fetch_array($result);
	
	if ($row == NULL)
		show_error(666,"Access denied.");
		
	if ($row['rights'] != 'admin')
		show_error(667,"You have to be an administrator to edit this article.");
		
	$request = sprintf('
		UPDATE `article` 
		SET `content`="%s", `name`="%s", `about`="%s", `image`="%s", `keywords`="%s"
		WHERE `id`=%d',
		$content,$name,$about,$image,$keywords,$id);
		
	mysql_query($request, $link) or  show_error(5,mysql_error($link));
	
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
	
	$request = sprintf('
		INSERT INTO `message` (`name`,`email`,`text`,`context`) 
		VALUES ("%s","%s","%s","%d")',
		$name,$email,$text,$context);
		
	mysql_query($request) or  show_error(5,mysql_error($link));
	
	$request = sprintf('
		SELECT `date` 
		FROM `message` 
		WHERE `id` = %d',
		mysql_insert_id());
		
	$result = mysql_query($request) or show_error(788,"Can't read a date!");
	
	$row = mysql_fetch_array($result);
	
	$date = $row['date'];
	
	echo '{"error_code":0, "email":"'.$email.'", "name":"'.$name.'", "text":"'.$text.'", "date":"'.$date.'"}';
	exit;
}

if ($func == 'getcomments')
{
	if (!array_key_exists('portion',$args))
		show_error(1);
		
	$portion = preg_replace('/[^0-9\-]/', '', $args['portion']);
	$context = preg_replace('/[^0-9\-]/', '', $args['context']);
	
	$request = sprintf('
		SELECT COUNT(*) FROM `message` 
		WHERE `context`=%d',
		$context);
	$result = mysql_query($request, $link) or show_error (146,'Unable to get message count');
	$rowCount = mysql_fetch_array($result)['COUNT(*)'];

	$request = sprintf('
		SELECT `list_size` 
		FROM `context` 
		WHERE `id`=%d',
		$context);
	$result = mysql_query($request, $link) or show_error (147,'Ubable to get a context.');
	$listSize = mysql_fetch_array($result)['list_size'] or show_error (148,'Wrong context.');
	
	$portionCount = ceil($rowCount / $listSize);

	$start = $listSize * $portion;
	$end = $start + $listSize;

	
	$request = sprintf('
		SELECT `id`,`name`,`text`,`email`,`date` 
		FROM `message` 
		WHERE `context`=%d 
		ORDER BY date DESC 
		LIMIT %d,%d',
		$context,$start,$end);
	$result = mysql_query($request, $link) or show_error(788,"Can't read a date!");
	
	$messages = '[';
	
	while ($row = mysql_fetch_array($result))
	{
		$messages .= sprintf('{"name":"%s","text":"%s","email":"%s","date":"%s"},',
				$row['name'],$row['text'],$row['email'],$row['date']);
	}
	
	$messages .= ']';
	echo sprintf('{"error_code":0, "portion":"%d", "portion_count":"%d", "message_list":%s}',$portion, $portionCount, $messages);
	exit;
}

show_error(899,"Wrong function: ".$func);
