<?php
//*********************************************************************
//Backend
//*********************************************************************

if ($context != 0)
{

	$result = mysql_query("SELECT id,name,text,email,date FROM message WHERE context=".$context,$link) or die('Ubable to get message list.');

	$message_list = [];
		
	while ($row = mysql_fetch_array($result))
		$message_list[] = ['id' => $row['id'], 'name' => urldecode($row['name']), 'text' => urldecode($row['text']), 'email' => $row['email'], 'date' => $row['date']];

	$message_list = array_reverse($message_list);

	include($style_path.'comments.php');

//*********************************************************************
//Frontend
//*********************************************************************
?><script>
function sendMessage(context)
{
	var name = document.getElementById("guest_name_input").value;
	var email = document.getElementById("guest_email_input").value;
	var text = document.getElementById("message_textarea").value;
	client.sendRequest("addcomment", 
		{
			email:encodeURIComponent(email),
			name:encodeURIComponent(name),
			text:encodeURIComponent(text),
			context:encodeURIComponent(context)
		},
		"POST",
		onSendSuccess,
		onSendError);
}

function onSendSuccess(data)
{
	document.getElementById("send_status_icon").className = "icon icon_success";
	addMessage(decodeURIComponent(data.name), data.email, decodeURIComponent(data.text), data.date);
}

function onSendError(errCode,errMsg)
{
	document.getElementById("send_status_icon").className = "icon icon_error";
	var errStr = "Comment error.\nError code: " + errCode;
	if (errMsg != "")
		errStr += "\nError message: " + errMsg;
	alert(errStr);
}

function addMessage(name, email, text, date)
{
	var message = '';
	message += '<div class="message_block">';
	message += '<div class="message_header">';
	message += '<div class="message_name">' + name + ' ' + email + '</div>';
	message += '<div class="message_date">' + date + '</div>';
	message += '</div>';
	message += '<div class="message_text">'+ text +'</div>';
	message += '</div>';
	
	var element = document.getElementById("message_list_<?=$context?>");
	
	element.innerHTML = message + element.innerHTML;
	
}

</script>

<?php } ?>
