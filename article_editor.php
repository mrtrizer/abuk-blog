<?php
//*********************************************************************
//Backend
//*********************************************************************

if ($user == NULL)
	die ("Access denied");

$id = $args['id'];

if ($id == 0)
{
	$request = '
		INSERT INTO `context` (`list_size`) 
		VALUES (10)';
	mysql_query($request, $link) or  die(mysql_error($link));	
	$name = "New article";
	$visible = 1;
	$about = "";
	$content = "";
	$context = mysql_insert_id();
	$request = sprintf('
		INSERT 
		INTO `article` (`name`,`visible`,`about`,`content`,`context`) 
		VALUES ("%s","%d","%s","%s","%d")',
		$name,$visible,$about,$content,$context);
	mysql_query($request, $link) or  die(mysql_error($link));	
	$id = mysql_insert_id();
}

$request = sprintf('
	SELECT `id`,`about`,`name`,`date`,`content` 
	FROM `article` 
	WHERE `id`=%d',
	$id);
	
$result = mysql_query($request, $link) or die('Ubable to get an article.');

$row = mysql_fetch_array($result) or die ('Article with such name was not created!');

$article = [
	'id' => $row['id'], 
	'name' => urldecode($row['name']), 
	'date' => $row['date'], 
	'content' => urldecode($row['content']), 
	'about' => urldecode($row['about'])];

$template_path = 'article_editor.php';

//*********************************************************************
//Frontend
//*********************************************************************
?><script>
	
function saveArticle(id)
{
	var content = document.getElementById("editor_textarea").value;
	var name = document.getElementById("article_name_input").value;
	var about = document.getElementById("about_textarea").value;
	client.sendRequest("savearticle", 
		{
			id:id, 
			key:"<?=bin2hex($user['key'])?>", 
			content:encodeURIComponent(content),
			about:encodeURIComponent(about),
			name:encodeURIComponent(name)
		},
		"POST",
		onSaveSuccess,
		onSaveError);
}

function onSaveSuccess(data)
{
	document.getElementById("save_status_icon").className = "icon icon_success";
}

function onSaveError(errCode,errMsg)
{
	document.getElementById("save_status_icon").className = "icon icon_error";
	var errStr = "Login error.\nError code: " + errCode;
	if (errMsg != "")
		errStr += "\nError message: " + errMsg;
	alert(errStr);
}

</script>
