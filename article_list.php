<?php 
//*********************************************************************
//Backend
//*********************************************************************

$result = mysql_query("SELECT id,name,about,image,date,visible FROM article",$link) or die('Ubable to get an article list.');

$article_list = [];
	
while ($row = mysql_fetch_array($result))
	$article_list[] = [
	'id' => $row['id'], 
	'name' => urldecode($row['name']), 
	'date' => $row['date'], 
	'image' => $row['image'],  
	'about' => urldecode($row['about']),
	'visible' => urldecode($row['visible'])];

$article_list = array_reverse($article_list);

function article_url ($id)
{
	return 'index.php?page=article&id='.$id;
}

//include($style_path.'article_list.php');
$template_path = 'article_list.php';

//*********************************************************************
//Frontend
//*********************************************************************
?><script>
function pageListMenuInit()
{
	var addButton = document.getElementById("add_button");
	if (!addButton)
		return;
	addButton.style.display = "block";
}

//Stub function
function showPrompt(text, callback)
{
	callback("OK");
}

function deleteArticle(id)
{
	client.sendRequest("deletearticle", 
		{
			id:id, 
			key:"<?=bin2hex($user['key'])?>"
		},
		"POST",
		onDeleteSuccess,
		onCmdError);
}

function deleteArticleDialog(id)
{
	showPrompt("Delete an article?", 
		function (e) 
		{
			if (e) 
				deleteArticle(id)
		});
}

function onDeleteSuccess(data)
{
	document.getElementById("article_" + data.id).style.display = "none";
}

function hideArticle(id)
{
	client.sendRequest("hidearticle", 
		{
			id:id, 
			key:"<?=bin2hex($user['key'])?>"
		},
		"POST",
		onHideSuccess,
		onCmdError);
}

function onHideSuccess(data)
{
	document.getElementById("article_" + data.id).className = data.visible?"article_block":"article_block article_block_hidden";
	document.getElementById("hide_" + data.id).innerHTML = data.visible?"Hide":"Show";
}

function onCmdError(errCode,errMsg)
{
	var errStr = "Delete error.\nError code: " + errCode;
	if (errMsg != "")
		errStr += "\nError message: " + errMsg;
	alert(errStr);
}

addInitFunc(pageListMenuInit);

</script>
