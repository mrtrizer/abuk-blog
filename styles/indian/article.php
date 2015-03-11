<div class="article_block">
	<h1 class="article_name"><?=$article['name'] ?></h1>
	<div id="article_text"><?=$article['content'] ?></div>
	<script>parseBBCodes('article_text'); </script>
	<?php include($style_path.$comments_template_path); ?>
</div>

