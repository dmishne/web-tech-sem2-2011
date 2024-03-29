<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title> iManage </title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<link rel="icon" href="images/logo.ico" />
	<link rel="apple-touch-icon" href="images/icon_apple.png" />
	<?php include "include.php"; ?>
	<script type="text/javascript" src="JQueryUI/jquery-ui-1.8.16.custom.min.js"> </script>
	<link rel="stylesheet" href="JQueryUI/jquery-ui-1.8.16.custom.css" type="text/css"/>
	<style type="text/css">
	
	.ui-widget {
		font-size: 0.8em;
	}	
	
	</style>
	
	<style type="text/css">
	html,body{
		height:100%;
		width:100%;
		margin:0;
		padding:0;
		overflow-y: auto;
		overflow-x: hidden;
	}
	body{
		text-align:center;
		min-width:600px;
		min-height:400px;
	}
	#vertical{
		float:left;
		height:50%;
		margin-top:-375px;
		width:100%;
	}
	#hoz {
		background: rgba(255,255,255,0.6);
		width:100%;
		margin-left:auto;
		margin-right:auto;
		height:750px;
		border:1px solid silver;
		overflow:auto;/* allow content to scroll inside element */
		text-align:left;
		clear:both;
	}
	#ins_logo {
		text-align: center;
		height: 135px;
		width: 100%;
		//background-image:url('images/logo.png');
		background-repeat:no-repeat;
		background-position:40% 0%;
		position: relative;
		text-align: center;
		vertical-align: middle;
		font:Arial, Helvetica, sans-serif;
		font-size:100px;
		color: dodgerblue;
	}
	#ins_content
	{
		text-align: center;
		margin-left:auto;
		margin-right:auto;
		width:100%
	}
	#ins_form
	{
		color:#fff;
		width:330px;			
		margin-left:auto;
		margin-right:auto;
		padding:0;
	}
	#ins_form legend {display:none;}
	#ins_form h3 {
		padding:0;
		margin:0;
		border:1px solid #000;
		border-bottom:none;
		font-size:20px;
		height: 35px;
		background-color: LightSkyBlue;
		text-align:left;
	}
	#ins_form h3 span 
	{
		margin:0;
		padding:5px 20px;
		display:block;
		font-size:18px;
		margin:auto;
	}
	#ins_form fieldset{
		margin:0;
		padding:0;
		border:none;	
		border-top:3px solid #000;
		background:#000 url(../images/form2/form_top.gif) repeat-x;		
		padding-bottom:1em;
	}		
	#ins_form label{
		display:block;
		text-align:left;
		font-size:14px;
	}
	#ins_form p{margin:.5em 20px;}
	.ins_inp{	
		display:block;	
		width:272px;
		border:1px solid #111;
		background:#282828;
		padding:5px 3px;
		color:#fff;
		text-align:left;
	}
</style>
<script type="text/javascript">
var progress = 0;
function verifyInformation()
{
	 $("#ins_bu").attr('disabled', true);
	document.getElementById("ins_error").innerHTML="<img src=\"images/loading.gif\" height=\"42\" width=\"42\" />";
	mysql_address = document.getElementById("ins_mysql_add").value;
	mysql_username = document.getElementById("ins_mysql_username").value;
	mysql_password = document.getElementById("ins_mysql_password").value;
	mysql_db = document.getElementById("ins_mysql_database").value;
	mysql_demo_info = document.getElementById("ins_demo_info").checked?1:0;

	username = document.getElementById('ins_admin_username').value;
	password = document.getElementById('ins_admin_password').value;
	passwordr = document.getElementById('ins_admin_password_v').value;
	// send user information
	// validate user information
	if(password == passwordr && username != "")
	{
		progress = 0;
		$.post("installVerifier.php",{mysql_address:mysql_address,mysql_username:mysql_username ,mysql_password:mysql_password,mysql_db:mysql_db,mysql_demo_info:mysql_demo_info,username:username,password:password,passwordr:passwordr},function(data) {
			switch(data)
			{
			case "1":
				document.getElementById("ins_error").innerHTML="Ok - <a href='index.php' style='color:lightGreen;'> Go To Site </a> ";
				break;
			case "0":
				document.getElementById("ins_error").innerHTML="Problem with MySQL Information";
				break;
			case "-1":
				document.getElementById("ins_error").innerHTML="Site already installed! <br/> Please email Webadmin or recopy the original files";
				break;
			default:
				document.getElementById("ins_error").innerHTML="Problem, Can't install at the moment";
				break;
			}
			$( "#progress" ).toggle();
		})
		.error(function() {document.getElementById("ins_error").innerHTML="Problem, Can't install at the moment";});
		$( "#progress" ).toggle();
		$( "#progress" ).progressbar({
			value: 0
		});
		setTimeout("progressbar()", 1100);
	}
	else
	{
		document.getElementById("ins_error").innerHTML="Problem with User information";
	}
	 $("#ins_bu").attr('disabled', false);
}

function progressbar()
{
	progress++;
	$( "#progress" ).progressbar( "option", "value", progress*10 );
	if(progress < 10)
	{
		setTimeout("progressbar()", 1100);
	}
}

</script>

</head>

<body>
<div id="vertical"></div>
<div id="hoz">
	<div id="ins_logo">
		<img style="vertical-align:-30%; margin:0px 10px 0px -10px;" src='images/logo.png' width='162px' height='134px'/>Install
	</div>
	<div id="ins_content">
		<form id="ins_form" action="" method="get">
			<h3><span> MySQL Install Information</span></h3>
			<fieldset>
				<legend> MySQL Information</legend>
				<p>
					<label for="ins_mysql_add">Server Address</label>
					<input class="ins_inp" type="text" name="ins_mysql_add" id="ins_mysql_add" />
				</p>
				<p>
					<label for="ins_mysql_username">Username </label> 
					<input class="ins_inp" type="text" name="ins_mysql_username" id="ins_mysql_username" />
				</p>
				<p>
					<label for="ins_mysql_password">Password </label>
					<input class="ins_inp" type="password" name="ins_mysql_password" id="ins_mysql_password" />
				</p>
				<p>
					<label for="ins_mysql_database">Database </label>
					<input class="ins_inp" type="text" name="ins_mysql_database" id="ins_mysql_database" />
				</p>
				<p>
					<label style="display:inline;" for="ins_demo_info"> Add Demo Information </label>
					<input type="checkbox" id="ins_demo_info" name="ins_demo_info" value="1"/>
				</p>
				<h3><span> Admin User Information</span></h3>
				<p>
					<label for="ins_admin_username">Username </label>
					<input class="ins_inp" type="text" name="ins_admin_username" id="ins_admin_username" />
				</p>
				<p>
					<label for="ins_admin_password">Password </label>
					<input class="ins_inp" type="password" name="ins_admin_password" id="ins_admin_password" />
				</p>
				<p>
					<label for="ins_admin_password_v">Re-type Password</label>
					<input class="ins_inp" type="password" name="ins_admin_password_v" id="ins_admin_password_v" />
				</p>
				<p><input id="ins_bu" class="blue buttom medium" type="button" value="Install" onclick="verifyInformation()"></input></p>
			<div id="ins_error" class="error"></div>
			<div id="progress" style="display:none;"></div>
			</fieldset>
		</form>
	</div>	
	
</div>  <!-- wrapper -->

</body>
</html>