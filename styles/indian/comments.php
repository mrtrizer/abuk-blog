<div class="guest_book">
	<h1>Comments</h1>
	<div class="message_enter_block">
		Enter your message:
		<textarea cols="95" rows="5" id="message_textarea"></textarea>
		<div class="controls_block">
			<div class="field" id="guest_name_field">Name: <input type="text" size=25; value="" id="guest_name_input" /></div>
			<div class="field" id="guest_email_field">EMail: <input type="email" size=25; value="" id="guest_email_input" /></div>
			<div class="field" id="message_send_field">
				<div class="button color2" id="send_button" onclick="sendMessage(<?=$context?>)">Send</div> 
				<div class="icon_hidden" id="send_status_icon"></div>
			</div>
		</div>
	</div>
	
	<div class="message_list" id="message_list_<?=$context?>">
		<?php foreach ($message_list as $message): ?>
		<div class="message_block">
			<div class="message_header">
				<div class="message_name"><?=$message['name']?> <?=(($user['rights']=='admin')?$message['email']:"")?></div>
				<div class="message_date"><?=$message['date']?></div>
			</div>
			<div class="message_text"><?=$message['text']?></div>
		</div>
		<?php endforeach ?>
	</div>
	
</div>
