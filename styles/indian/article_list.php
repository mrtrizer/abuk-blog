<?php foreach ($article_list as $article): ?>
<div class="article_block">
	<div class = "article_header">
		<h1 class="article_name">
			<?=$article['name'] ?>
		</h1>
		<div class="article_date">
		<?=$article['date'] ?>
		</div>
	</div>
	<?php if ($article['image'] != NULL): ?>
		<div class="square_img" >
			<span class="inline_block"></span>
				<img src="<?=$article['image'] ?>" />
		</div>
	<?php endif ?>
	<p class="article_about">

		<?=$article['about'] ?>
		<br>
		<a class="read_more color3" href="<?=article_url($article['id'])?>">Read more</a>
		<?php if ($user != NULL): ?>
		<a class="read_more color3" href="index.php?page=article_editor&id=<?=article_url($article['id'])?>">Edit</a>
		<?php endif ?>
	</p>
</div>
<?php endforeach ?>
