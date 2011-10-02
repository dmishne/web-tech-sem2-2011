<?php session_start();
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
			Sign Up
			</div>
			
            <div id="content-middle">  
            <table class="shead" border="0" width="98%">
              <tr>
               <td align="left" width="10"><font style="font-size:13px; position:relative;font-weight:bold; text-decoration:none;
                   color:#FE2712" face="arial"> *Please fill in all fields below</font></td>
               <td align="left" width="20"></td>
              </tr>
              <tr><td></td></tr>
              <tr>
               <td align="left" width="10"><font style="font-size:13px; ;font-weight:bold; text-decoration:none; 
                   color:gray;" face="arial"> Personal details:</font>
               <font style="font-size:13px; font-weight:bold; text-decoration:none; 
                   color:gray; margin-left:160px;" face="arial">Login information:</font></td>
              </tr>
              <tr><td></td></tr>
             <tr> <td>
             <form method="post" action="signupVerifier.php" id="signup_form">
	             <table class="sbody" border="0" align="left" valign="top" style="font-family:"arial", arial, sans-serif; font-size:13px; position:relative;">                
	                      <tr>
	                          <td>First Name:</td>
	                          <td><input type="text" class="inpt" style="font-size:11px; position:relative; top:0px;" size="30" maxlength="30" id="firstname" name="firstname" /></td>
	                          <td></td>
	                          <td>UserName:</td>
	                          <td><input type="text" class="inpt" style="font-size:11px; position:relative; top:0px;" size="30" maxlength="16" id="username" name="username" /></td>
	                      </tr>
	                      <tr>
	                          <td>Last Name:</td>
	                          <td><input type="text" class="inpt" style="font-size:11px; position:relative; right:0px; top:0px;" size="30" maxlength="30" id="lastname" name="lastname"/></td>
	                          <td></td>
	                          <td>Password:</td>
	                          <td><input type="password" class="inpt" style="font-size:11px; position:relative; top:0px;" size="30" maxlength="20" id="userpassword" name="userpassword" /></td>
	                      </tr>
	                      <tr>
	                          <td>Date of birth:</td>
	                          <td width="20px" height="16">
	                          		<input type="text" size="1" maxlength="2" class="inpt" id="signUpDay"   name="signUpDay" />
	                          		<input type="text" size="1" maxlength="2" class="inpt" id="signUpMonth" name="signUpMonth"/>
	                          		<input type="text" size="1" maxlength="4" class="inpt" id="signUpYear"  name="signUpYear"/>
	                          </td>
	                          <td></td>
	                          <td>Confirm Password:</td>
	                          <td><input type="password" class="inpt" style="font-size:11px; position:relative; top:0px;" size="30" maxlength="20" id="userpasswordconfirm" name="userpasswordconfirm" /></td>
	                      </tr>
	                      <tr>
	                          <td>eMail address:</td>
	                          <td width="20px" height="16"><input type="text" class="inpt" style="font-size:11px; position:relative; right:0px; top:0px;" size="30" maxlength="30" id="email" name="email"/></td>
	                      </tr>
	                      <tr><td><br /><br />
	                      <input name="signup" id="signup" type="submit" value="Sign Up" class="blue button medium" style="min-width:100px;" />
	                      </td></tr>
	                </table>
             	</form>
             	</td>
             	</tr>
            </table> 
           </div>  
          </div>
	</div>
	
	
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
</div> <!-- wrapper -->
</body>
</html>