<?php 
//*********************************************************************
//Backend
//*********************************************************************
$id = $args['id'] or die('Expected an id argument.');

$request = sprintf('
	SELECT `id`,`name`,`date`,`content`,`context` 
	FROM article 
	WHERE `id`=%d',
	$id);
	
$result = mysql_query($request, $link) or die('Ubable to get an article.');

$row = mysql_fetch_array($result)  or die ('Article with such name was not created!');;

$article = [
	'id' => $row['id'], 
	'name' => urldecode($row['name']), 
	'date' => $row['date'], 
	'content' => urldecode($row['content']), 
	'context' => urldecode($row['context'])];

$context = $article['context'];

include($style_path.'article.php');
include('comments.php');

//*********************************************************************
//Frontend
//*********************************************************************
?><script>
	var editorButton = document.getElementById("edit_button");
	editorButton.style.display = "block";
	editorButton.href = "index.php?page=article_editor&id=<?=$article['id']?>";
</script>
