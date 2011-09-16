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
               <td align="left" valign="center"><font style="font-size:13px; position:relative;font-weight:bold; text-decoration:none; text-decoration:none;
                   color:#FE2712" face="arial"> *Please fill in all fields below</font></td>
              </tr>
             <font style="font-size:13px; position:relative;" face="arial" color="black">
             <table class="sbody" border="0" align="left" valign="top">                
                      <tr>
                          <td>UserName:</td>
                          <td><input type="text" style="font-size:11px; position:relative; top:0px;" size="30" maxlength="30" id="usrnmfield" /></td>
                          <td></td>
                          <td>Credit card:</td>
                          <td><input type="text" style="font-size:11px; position:relative; top:0px;" size="30" maxlength="16" id="usrccn" /></td>
                      </tr>
                      <tr>
                          <td>Password:</td>
                          <td><input type="password" style="font-size:11px; position:relative; right:0px; top:0px;" size="30" maxlength="30" id="usrpsw"/></td>
                          <td></td>
                          <td>ID:</td>
                          <td><input type="text" style="font-size:11px; position:relative; top:0px;" size="30" maxlength="20" id="usrid" /></td>
                      </tr>
                      <tr>
                          <td>Confirm Password:</td>
                          <td width="20px" height="16"><input type="password" style="font-size:11px; position:relative; right:0px; top:0px;" size="30" maxlength="30" id="usrpswconf"/></td>
                          <td></td>
                          <td>Bank Number:</td>
                          <td><input type="text" style="font-size:11px; position:relative; top:0px;" size="14" maxlength="20" id="usrbla" /></td>
                      </tr>
                      <tr>
                          <td>EMail:</td>
                          <td width="20px" height="16"><input type="text" style="font-size:11px; position:relative; right:0px; top:0px;" size="30" maxlength="30" id="usrmail"/></td>
                      </tr>
                      <tr>
                          <td>Age:</td>
                          <td width="20px" height="16"><input type="text" style="font-size:11px; position:relative; right:0px; top:0px;" size="8" maxlength="3" id="usrage"/></td>
                      </tr>
                      <tr>
                          <td>Country:</td>
                          <td width="20px" height="16"><input type="text" style="font-size:11px; position:relative; right:0px; top:0px;" size="30" maxlength="30" id="usrmail"/></td>
                      </tr>
                      <tr>
                          <td>Bla Bla:</td>
                          <td width="20px" height="16"><input type="text" style="font-size:11px; position:relative; right:0px; top:0px;" size="30" maxlength="25" id="usrmail"/></td>
                      </tr>                
                </table>
                </font>
                <table class="sfoot" border="0" width="98%" cellspacing="20">
                      <tr align="left">
                          <td><font style="font-size:13px; position:relative; text-decoration:none; text-decoration:none" face="arial" align="center" valign="bottom">You've got ROBBED! HA HA HA...</font></td>      
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