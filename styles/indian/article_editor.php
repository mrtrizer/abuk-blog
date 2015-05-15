<div class="article_editor">
	<h1><?=$article['name']?></h1>
	<div class="controls_block">
		<div class="field" id="article_name_field"><b>Name:</b> <input type="text" size=50; value="<?=$article['name']?>" id="article_name_input" /></div>
		<div class="field" id="edit_controls_field">
			<div class="icon_hidden" id="save_status_icon"></div>
			<div class="button color2" id="save_button" onclick="saveArticle('<?=$article['id']?>')" style="float:right;">Save</div> 
		</div>
	</div>
	<b>About:</b>
	<textarea class="editor_textarea" id="about_textarea" rows=10 cols=95><?=$article['about']?></textarea>
	<b>Image:</b>
	<input class="editor_textarea" id="image_input" width=95 value="<?=$article['image']?>" />
	<b>Keywords:</b>
	<input class="editor_textarea" id="keywords_input" width=95 value="<?=$article['keywords']?>" />
	<b>Main text:</b>
	<textarea class="editor_textarea" id="editor_textarea" rows=25 cols=95><?=$article['content']?></textarea>
	<b>Files:</b><br><br>
	<div class="controls_block">
		<?php foreach ($fileList as $file):?>
			<div class="button color2" onclick="insertImage('<?=$file['path']?>')"><?=$file['name'] ?></div>
		<?php endforeach?>
		<div class="button color2" id="upload_button" onclick="showUploadDialog()">Upload</div> 
	</div>
</div>
