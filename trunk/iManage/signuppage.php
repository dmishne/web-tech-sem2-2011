<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

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
			Sign Up
			</div>
			
            <div id="content-middle">
	            <?php 
	            	if((isset($_SESSION['signupError'])))
	            	{
	            		$REG = 0;
	            		$error = $_SESSION['signupError'];
	            		echo "<div class=\"errorGrey\"> Cannot complete registration. Please review the following: </div>";
	            		if($error['Reg']){
	            			echo "<div class=\"errorGrey\"> User already exist! </div>";
	            		}
	            		
	            	}
	            ?>
	            <form method="post" action="signupVerifier.php" id="signup_form">
	            <div id="signup_personal">
		            <table>
		            	<tr>
		            		<th> Personal details: </th>
		            	</tr>
		            	<tr>
		            		<td> First Name: </td>
		            		<td><input type="text" class="inpt" style="position:relative; top:0px;" size="30" maxlength="30" id="firstname" name="firstname" /></td>
		            	</tr>
		            	<?php 
		            		if(isset($error['firstname']) && $error['firstname'] = 1){
		            			echo "<tr> <td colspan=2> <div class=\"error\"> At least 2 letters required. </div> </td> </tr>";
		            		}
		            	?>
		            	<tr>
		            		<td> Last Name: </td>
		            		<td><input type="text" class="inpt" style="position:relative; right:0px; top:0px;" size="30" maxlength="30" id="lastname" name="lastname"/></td>
		            	</tr>
		               	<?php 
		            		if(isset($error['lastname']) && $error['lastname'] = 1){
		            			echo "<tr> <td colspan=2> <div class=\"error\"> At least 2 letters required. </div> </td> </tr>";
		            		}
		            	?>
		            	<tr>
		            		<td> Date of Birth: </td>
		            		<td style="text-align: justify;">
		                   		<input type="text" size="3" maxlength="2" class="inpt" id="signUpDay"   name="signUpDay" />
		 	                    <input type="text" size="3" maxlength="2" class="inpt" id="signUpMonth" name="signUpMonth"/>
		 	                    <input type="text" size="5" maxlength="4" class="inpt" id="signUpYear"  name="signUpYear"/>
	 	                    </td>
		            	</tr>
		            	<?php 
		            		if(isset($error['date']) && $error['date'] = 1){
		            			echo "<tr> <td colspan=2> <div class=\"error\"> Date incorrect! Example: 31 12 2011 </div> </td> </tr>";
		            		}
		            	?>
		            	<tr>
		            		<td> EMail Address: </td>
		            		<td width="20px" height="16"><input type="text" class="inpt" style="position:relative; right:0px; top:0px;" size="30" maxlength="30" id="email" name="email"/></td>
		            	</tr>
		            </table>
		        </div>   
		        <div id="signup_login">
		         	<table>
			         	<tr>
			         		<th> Login information: </th>
			         	</tr>
			         	<tr>
			         		<td> Username: </td>
			         		<td><input type="text" class="inpt" style="position:relative; top:0px;" size="30" maxlength="16" id="username" name="username" /></td>
			         	</tr>
			         	<?php 
		            		if(isset($error['username']) && $error['username'] = 1){
		            			echo "<tr> <td colspan=2> <div class=\"error\"> At least 3 letters required. </div> </td> </tr>";
		            		}
		            	?>
			         	<tr>
			         		<td> Password: </td>
			         		<td><input type="password" class="inpt" style="position:relative; top:0px;" size="30" maxlength="20" id="userpassword" name="userpassword" /></td>
			         	</tr>
			         	<?php 
		            		if(isset($error['password']) && $error['password'] = 1){
		            			echo "<tr> <td colspan=2> <div class=\"error\"> Passwords are incorrect or doesn't match </div> </td> </tr>";
		            		}
		            	?>
			         	<tr>
			         		<td> Confirm Password: </td>
			         		<td><input type="password" class="inpt" style="position:relative; top:0px;" size="30" maxlength="20" id="userpasswordconfirm" name="userpasswordconfirm" /></td>
			         	</tr>
			         	<?php 
		            		if(isset($error['password']) && $error['password'] = 1){
		            			echo "<tr> <td colspan=2> <div class=\"error\"> Passwords are incorrect or doesn't match </div> </td> </tr>";
		            		}
		            	?>
			       	</table>
		        </div>
		        <br />
		        <br />
		        <br />		        
		        <div style="clear:both; width:100%; margin: 100px 0px 0px 0px; text-align:center;">
		        	<input name="signup" id="signup" type="submit" value="Sign Up" class="blue button medium" style="min-width:100px;" />
		        </div>
	            </form>
	
        	</div>  
		</div>
        <?php 
			unset($_SESSION['signupError']);
        ?>
	</div>
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
</div> <!-- wrapper -->
</body>
</html>