<div id="header" class="color1">
	<div class="header_block" id="header_logo">
		<img src="<?=$logo ?>" width="100px" />
	</div>
	<div class="header_block" id="header_title">
		<?=$title ?>
	</div>
	<div class="header_block" id="navigation_buttons">
		<a class="navigation_button color2" href="index.php?page=article_list">Articles</a>
		<a class="navigation_button color2" href="index.php?page=about">Author</a>
		<a class="navigation_button color2" href="index.php?page=guest_book">Guest book</a>
	</div>
	<div class="header_block" id="login_buttons">
		<?php if ($user == NULL): ?>
			<a class="navigation_button color2" onclick="displayLogin()" href="#">Login</a>
		<?php else: ?>
			<a class="navigation_button color2" onclick="logout()" href="#">Logout</a>
		<?php endif ?>
	</div>
	<div class="header_block" id="service_buttons">
		<?php if (($user != NULL) && ($user['rights'] == 'admin')): ?>
			<a class="navigation_button color2" id="edit_button" href="index.php?page=article_editor&id=1" style="display:none">Edit</a>
			<a class="navigation_button color2" id="add_button" href="index.php?page=article_editor&id=0" onclick="addArticle()" style="display:none">Add</a>
		<?php endif ?>
	</div>
	<div class="header_block" id="user_info">
		<?php if ($user != NULL): ?>
			<a class="user_name" href=""><?=$user['name'] ?></a>
			<a class="user_email" href=""><?=$user['email'] ?></a>
		<?php endif ?>
	</div>
</div>
