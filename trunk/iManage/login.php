<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title> iManage </title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<link rel="icon" href="images/logo.ico" />
	<link rel="apple-touch-icon" href="images/icon_apple.png" />
	<?php include "include.php"; ?>
	
	<script type="text/javascript">
		$(document).ready(function(){setLogin();});
	</script>
	
</head>

<body>
<div id="wrapper">

	<div id="top">
		<?php include "header.php"; ?>
	</div>
	
	<div id="middle">
		<div class="menu">
			<?php include "menu.php"; ?>
		</div>
				
		<div id="content">
			<div id="content-head">
		    	Login
			</div>
			<div id="content-middle">
				<!--  Content  -->
				
				<div id="login">
					<form method="post" action="" id="login_form">
						<div> 
							Username
							<br /> 
							<input name="username" type="text" id="username" value="" maxlength="20" />
						</div>
						<div id="loginText"> 
							Password
							<br /> 
							<input name="password" type="password" id="password" value="" maxlength="20" />
						</div>
		  				<br />
		  				<div style="text-align:center;">
		  					<input name="Submit" id="submit" type="submit" value="Login" class="blue button medium" style="min-width:100px;" />
		  					<span id="msgBox"></span>
		  				</div>  
					</form>
					
				</div>
				
	        	<!--  End of Content -->
			</div>
		</div>
	</div>
	
	
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
</div> <!-- wrapper -->
</body>
</html>