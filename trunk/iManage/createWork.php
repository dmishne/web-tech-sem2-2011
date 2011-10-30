<?php session_start();
// Verifies that user has logged in. Redirect to login page in case not logged in.
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0')) {
	header("location:login.php");
}
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
</head>

<body>
<div id="wrapper">

	<div id="top">
		<?php include "header.php"; ?>
	</div>
	
	<div id="middle">
		<div id="menu">
			<?php include "menu.php"; ?>
		</div>
				
		<div id="content">
			<div id="content-head">
		           Create Work Information
			</div>
			<div id="content-middle">
				   <form  method="post" action="createWorkVerifier.php" id="createWork_form">
			           <div id="createWork" class="greyCube">
				           <table style="margin-left:auto; margin-right:auto; text-align:left;">
				           		<tr style="text-align:center;"> 
				           			<th colspan=2> Create Work Form </th> 
				           		</tr>
				           		<tr>
				           			<td> Name: </td>
				           			<td> <input type="text" class="inpt" style="position:relative; top:0px;" size="30" maxlength="16" id="creatework_jobsname" name="creatework_jobsname" /> </td>
				           		</tr>
				           		<tr>
				           			<td> Wage Per Hour: </td>
				           			<td> <input type="text" class="inpt" style="position:relative; top:0px;" size="30" maxlength="16" id="creatework_wagehour" name="creatework_wagehour" /> </td>
				           		</tr>
				           		<tr>
				           			<td> Payment Date: </td>
				           			<td style="text-align: justify;">
			                   			<input type="text" size="3" maxlength="2" class="inpt" id="creatework_pDay"   name="creatework_pDay" />
			 	                    	<input type="text" size="3" maxlength="2" class="inpt" id="creatework_pMonth" name="creatework_pMonth"/>
					 	                <input type="text" size="5" maxlength="4" class="inpt" id="creatework_pYear"  name="creatework_pYear"/>
	 	            			    </td>
				           		</tr>
				           		<tr>
				           			<td style="vertical-align: text-top "> Notes/Description: </td>
				           			<td><textarea name="creatework_desc" rows="8" cols="32" class="inpt"> </textarea></td>
				           		</tr>
				           </table>
			           </div>
			           <div style="clear:both; width:100%; margin: 40px 0px 0px 0px; text-align:center;">
			           	   <input name="Submit" id="submit" type="submit" value="Create Work" class="blue button medium" style="min-width:100px;" />
			           </div>
		           </form>
			</div>
		</div>
	</div>
	
	
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
</div> <!-- wrapper -->
</body>
</html>