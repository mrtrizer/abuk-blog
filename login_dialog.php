<?php
//*********************************************************************
//Backend
//*********************************************************************

echo '<script type="text/template" id="login_dialog_template">';
include($style_path.'login_dialog.php');
echo '</script>';

//*********************************************************************
//Frontend
//*********************************************************************
?><script>
		function onLoginSuccess(data)
		{
			document.getElementById("login_status_icon").className = "icon icon_success";
			setCookie("key",data.key,{expires:3600 * 24 * 30});
			document.location.href = "<?=request_url()?>";
		}
		
		function onLoginError(errCode,errMsg)
		{
			document.getElementById("login_status_icon").className = "icon icon_error";
			var errStr = "Login error.\nError code: " + errCode;
			if (errMsg != "")
				errStr += "\nError message: " + errMsg;
		}
		
		function login()
		{
			
			var login = document.getElementById("login_input").value;
			var pass = document.getElementById("pass_input").value;

			markField("login_field",login);
			markField("password_field",pass);
				
			var passHash = MD5(pass);
			client.sendRequest("login", {login:login, pass_hash:passHash},"POST",onLoginSuccess,onLoginError);
			return true;
		}
		
		function displayLogin()
		{
			document.getElementById("dialog_container").innerHTML = document.getElementById("login_dialog_template").innerHTML;
			return true;
		}
		
		function closeDialog()
		{
			document.getElementById("dialog_container").innerHTML = "";
			return true;
		}
</script>
