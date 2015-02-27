<?php foreach ($article_list as $article): ?>
<div class="article_block">
	<h1 class="article_name">
		<?=$article['name'] ?>
	</h1>
	<?php if ($article['image'] != NULL): ?>
		<div class="square_img" >
			<span class="inline_block"></span>
				<img src="<?=$article['image'] ?>" />
		</div>
	<?php endif ?>
	<p class="article_about">

		<?=$article['about'] ?>
		<br>
		<a class="read_more" href="<?=article_url($article['id'])?>">Read more</a>
		<?php if ($user != NULL): ?>
		<a class="read_more" href="index.php?page=article_editor&id=<?=article_url($article['id'])?>">Edit</a>
		<?php endif ?>
	</p>
</div>
<?php endforeach ?>
