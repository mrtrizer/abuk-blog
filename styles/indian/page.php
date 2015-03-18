<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<?php include('login_dialog.php'); ?>
	<?php include('head.php'); ?>
	<?php include($page_head_path); ?>
	<title><?=$title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="Description" content="<?=$description?>">
	<meta property="og:type" content="website" />
	<meta property="og:url" content=http://abuksigun.ru />
	<meta property="og:title" content="<?=$title; ?>" />
	<meta property="og:description" content="<?=$description?>" /> 
	<meta property="og:image" content="<?=$description_image?>" />
	<link rel="stylesheet" href="<?=$style_path.'style.css';?>" type="text/css" />
	<link rel="stylesheet" href="xbbcode.css" type="text/css" />
	<script src="xbbcode.js" type="text/javascript"></script>
	<script src="client.js" type="text/javascript"></script>
	<script src="tools.js" type="text/javascript"></script>



	<script>
		client = new Client("login.php");
		
		function logout()
		{
			deleteCookie("key");
			document.location.href = "<?=request_url()?>";
		}
		
	</script>
</head>
<body style="background-attachment: fixed; background-color: WhiteSmoke; margin:0px; font-size:14px; font-family:Arial" onload="init()">
	<div id="main_pole">
		<?php include('header.php'); ?>
		<div id="middle">
			<div id="container">
				<div id="content">
					<?php include($style_path.$template_path); ?>
				</div>
			</div>
			<?php include('footer.php'); ?>
		</div>
	</div>

	<div id="dialog_container">
	</div>


</body>
</html>
