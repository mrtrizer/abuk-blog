<?php 
//*********************************************************************
//Backend
//*********************************************************************
$id = $args['id'] or die('Expected an id argument.');

$request = sprintf('
	SELECT `id`,`name`,`date`,`content`,`context`,`about`,`image`,`keywords`
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
	'context' => $row['context'],
	'about' => urldecode($row['about']),
	'image' => $row['image'],
	'keywords' => urldecode($row['keywords'])];

$context = $article['context'];
$description = $article['about'];
$keywords = $article['keywords'];
if (strlen($article['image']) > 0)
	$description_image = $article['image'];

include('comments.php');
$template_path = 'article.php';

//*********************************************************************
//Frontend
//*********************************************************************
?><script>

function articleMenuInit()
{
	var editorButton = document.getElementById("edit_button");
	if (!editorButton)
		return;
	editorButton.style.display = "block";
	editorButton.href = "index.php?page=article_editor&id=<?=$article['id']?>";
}

addInitFunc(articleMenuInit);

</script>
