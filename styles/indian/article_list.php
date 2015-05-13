<?php foreach ($article_list as $article): ?>
	<?php if (($user != NULL) || (ord($article['visible']) == 1)): ?>
	<div class="article_block <?=ord($article['visible']) == 0?"article_block_hidden":""?>" id="article_<?=$article['id']?>">
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
			<a class="read_more color3" id="hide_<?=$article['id']?>" onclick="hideArticle(<?=$article['id']?>)">
				<?php 
					if (ord($article['visible']) == 1) 
						echo "Hide";
					else
						echo "Show";
				?>
				</a>
			<a class="read_more color3" onclick="deleteArticleDialog(<?=$article['id']?>)">Delete</a>
			<?php endif ?>
		</p>
	</div>
	<?php endif ?>
<?php endforeach ?>
