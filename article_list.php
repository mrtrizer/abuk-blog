<?php 
//*********************************************************************
//Backend
//*********************************************************************

$result = mysql_query("SELECT id,name,about,image,date,visible FROM article",$link) or die('Ubable to get an article list.');

$article_list = [];
	
while ($row = mysql_fetch_array($result))
	$article_list[] = ['id' => $row['id'], 'name' => urldecode($row['name']), 'date' => $row['date'], 'image' => $row['image'],  'about' => urldecode($row['about'])];

function article_url ($id)
{
	return 'index.php?page=article&id='.$id;
}

include($style_path.'article_list.php');

//*********************************************************************
//Frontend
//*********************************************************************
?><script>
	var addButton = document.getElementById("add_button");
	addButton.style.display = "block";
</script>
