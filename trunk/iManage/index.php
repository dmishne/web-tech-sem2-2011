<?php session_start();
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
	session_unset();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
<head>
	<title> iManage </title>
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<link rel="icon" href="images/logo.ico" />
	<link rel="apple-touch-icon" href="images/icon_apple.png" />
	<?php include "include.php" ?>
</head>

<body>
<div id="wrapper">

	<div id="top">
		<?php include "header.php" ?>
	</div>
	
	<div id="middle">
		<div id="menu">
			<?php include "menu.php"; ?>
		</div>
				
		<div id="content">
			<div id="content-head">
		           Content Head
			</div>
			<div id="content-middle">
		           Content Here <br />
		           more content <br />
		           even more content
			</div>
		</div>
	</div>
	
	
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
	<?php include "bar.php"; ?>
</div> <!-- wrapper -->

</body>
</html>