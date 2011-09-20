<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>

<head>
	<title> iManage </title>
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	
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
              <tr height="30">
               <td align="left" valign="center" width="10"><font style="font-size:13px; position:relative;font-weight:bold; text-decoration:none;
                   color:#FE2712" face="arial"> *Please fill in all fields below</font></td>
               <td align="left" valign="center" width="20"></td>
              </tr>
              <tr height="30">
               <td align="left" valign="center" width="10"><font style="font-size:13px; ;font-weight:bold; text-decoration:none; 
                   color:gray;" face="arial"> Personal details:</font></td>
               <td align="left" valign="center" width="20"><font style="font-size:13px;;font-weight:bold; text-decoration:none; 
                   color:gray;" face="arial">Login information:</font></td>
              </tr>
              
              
             <font style="font-size:13px; position:relative;" face="arial" color="black">
             <table class="sbody" border="0" align="left" valign="top">                
                      <tr>
                          <td>First Name:</td>
                          <td><input type="text" style="font-size:11px; position:relative; top:0px;" size="30" maxlength="30" id="usrfname" /></td>
                          <td></td>
                          <td>UserName:</td>
                          <td><input type="text" style="font-size:11px; position:relative; top:0px;" size="30" maxlength="16" id="usrnmfield" /></td>
                      </tr>
                      <tr>
                          <td>Last Name:</td>
                          <td><input type="text" style="font-size:11px; position:relative; right:0px; top:0px;" size="30" maxlength="30" id="usrlname"/></td>
                          <td></td>
                          <td>Password:</td>
                          <td><input type="password" style="font-size:11px; position:relative; top:0px;" size="30" maxlength="20" id="usrpsw" /></td>
                      </tr>
                      <tr>
                          <td>Date of birth:</td>
                          <td width="20px" height="16"><input type="text" style="font-size:11px; position:relative; right:0px; top:0px;" size="30" maxlength="30" id="usrdob"/></td>
                          <td></td>
                          <td>Confirm Password:</td>
                          <td><input type="password" style="font-size:11px; position:relative; top:0px;" size="30" maxlength="20" id="usrpswconf" /></td>
                      </tr>
                      <tr>
                          <td>eMail address:</td>
                          <td width="20px" height="16"><input type="text" style="font-size:11px; position:relative; right:0px; top:0px;" size="30" maxlength="30" id="usrmail"/></td>
                      </tr>
 
               
                </table>
                </font>
                <table class="sfoot" border="0" width="98%" cellspacing="20">
                      <tr align="left">
                          <td><font style="font-size:13px; position:relative; text-decoration:none;  face="arial" align="center" valign="bottom">You've got ROBBED! HA HA HA...</font></td>      
                      </tr>
                      <tr >    
                          <td align="right" valign="bottom"><input type="image" src="images/signbuttpix.png" style="position:relative; right:-12px; top:0px;" alt="submit"  
                                 width="75" height="18" onclick="document.getElementById('usrnmfield').value" value="Submit"/> </td>                
                      </tr>
                </table>
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