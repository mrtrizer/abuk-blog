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
	SELECT `id`,`about`,`name`,`date`,`content`,`image`,`keywords`
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
	'about' => urldecode($row['about']),
	'image' => urldecode($row['image']),
	'keywords' => urldecode($row['keywords'])
	];

$request = sprintf('
	SELECT `id`,`name`,`path`,`md5`,`size`,`author`,`date`
	FROM `file`');

$result = mysql_query($request, $link) or die('Ubable to get a file.');

$fileList = [];

while ($row = mysql_fetch_array($result))
	$fileList[] = $row;

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
	var image = document.getElementById("image_input").value;
	var keywords = document.getElementById("keywords_input").value;
	client.sendRequest("savearticle", 
		{
			id:id, 
			key:"<?=bin2hex($user['key'])?>", 
			content:encodeURIComponent(content),
			about:encodeURIComponent(about),
			name:encodeURIComponent(name),
			image:encodeURIComponent(image),
			keywords:encodeURIComponent(keywords)
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

function insertAtCursor(myField, myValue) {
    //IE support
    if (document.selection) {
        myField.focus();
        sel = document.selection.createRange();
        sel.text = myValue;
    }
    //MOZILLA and others
    else if (myField.selectionStart || myField.selectionStart == '0') {
        var startPos = myField.selectionStart;
        var endPos = myField.selectionEnd;
        myField.value = myField.value.substring(0, startPos)
            + myValue
            + myField.value.substring(endPos, myField.value.length);
    } else {
        myField.value += myValue;
    }
}

function insertImage(fileName)
{
	insertAtCursor(document.getElementById("editor_textarea"),"[img]../data/images/"+fileName+"[/img]");
}

function showUploadDialog()
{
	
}

</script>
