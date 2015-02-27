<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?=$title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="<?=$style_path.'style.css';?>" type="text/css" />
	<link rel="stylesheet" href="xbbcode.css" type="text/css" />
	<script src="xbbcode.js" type="text/javascript"></script>
	<script src="client.js" type="text/javascript"></script>
	<script src="tools.js" type="text/javascript"></script>

	<?php include('login_dialog.php'); ?>

	<script>
		client = new Client("login.php");
		
		function logout()
		{
			deleteCookie("key");
			document.location.href = "<?=request_url()?>";
		}
		
	</script>
</head>
<body bgproperties="fixed" style="background-color: WhiteSmoke; margin:0px; font-size:14px; font-family:Arial">
	<div id="main_pole">
		<?php include('header.php'); ?>
		<div id="middle">
			<div id="container">
				<div id="content">
					<?php include($body_path); ?>
				</div>
			</div>
			<?php include('footer.php'); ?>
		</div>
	</div>

	<div id="dialog_container">
	</div>


</body>
</html>
