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
		           Users Management
			</div>
			<div id="content-middle" align="center">
		           <div id="mainUMbox" class="greyCube" style="width:70%; margin-top:20px;">	             
		                   <table style="margin-left:auto; margin-right:auto; text-align:left;">
				           		<tr style="text-align:center;"> 
				           			<th colspan="3"> Manage User </th> 
				           		</tr>
				           	<form method="post" action="" id="MU">
				           		<tr>
				           			<td> Search: </td>
				           			<td> <input type="text" class="inpt" style="position:relative; top:0px;" size="30" maxlength="16" id="srchuser" name="searchUser"></input> </td>
				           			<td><input type="submit" value="Search" class="blue button small bround"></input></td>
				           		</tr>
				           	</form>
				           		<tr>
				           		    <td>User status:</td>
				           		    <td colspan="2"><input type="text" class="inpt" style="position:relative; top:0px;" size="30" maxlength="16" readonly="readonly"></input></td>
				           		</tr>
				           		<tr>
				           		   <td style="vertical-align:top"> User profile:</td>
				           		   <td colspan="2"><textarea rows="12" cols="50" class="inpt"></textarea> </td>
				           		</tr>
				           		<tr align="center">
				           		    <td colspan="3"><input type="submit" value="Unlock" class="blue button small bround"></input>
				           		    <input type="submit" value="Lock" class="blue button small bround"></input>
				           		    <input type="submit" value="Delete User" class="blue button small bround"></input></td>
				           		</tr>			           		
				           </table>		
		           
		           
		           
		           
		           
		           
		           
		           
		              
		          </div>   		         
			</div>
		</div>
	</div>
	
	
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
</div> <!-- wrapper -->
</body>
</html>
