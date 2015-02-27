<?php
//*********************************************************************
//Backend
//*********************************************************************

if ($context != 0)
{

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
	loadComments(0);
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

function showPortionSelector(portionCount, currentPortion)
{
	var element = document.getElementById("portion_list_<?=$context?>");
	element.innerHTML = '';
	for (var i = 0; i < portionCount; i++)
	{
		var color = "color2";
		if (i == currentPortion)
			color = "color1";
		element.innerHTML += '<div class="portion_pointer ' + color + '" onclick="loadComments(' + i + ')">' + i + '</div> '
	}
}

function loadComments(portion)
{
	client.sendRequest(
		"getcomments", 
		{
			portion:portion,
			context:<?=$context?>
		},
		"POST",
		onLoadSuccess,
		onLoadError
		);
}

function onLoadSuccess(data)
{
	var element = document.getElementById("message_list_<?=$context?>");
	element.innerHTML = "";
	var messageList = data.message_list;
	var portionCount = data.portion_count;
	for (var i in messageList)
	{
		var message = messageList[i];
		addMessage(decodeURIComponent(message.name), message.email, 
						decodeURIComponent(message.text), message.date);
	}
	showPortionSelector(portionCount, data.portion);
}

function onLoadError(errCode,errMsg)
{
	var errStr = "Comment error.\nError code: " + errCode;
	if (errMsg != "")
		errStr += "\nError message: " + errMsg;
	alert(errStr);
}

loadComments(0);

</script>

<?php } ?>
