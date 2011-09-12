<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
<head>
<title> iManage </title>
<meta http-equiv="X-UA-Compatible" content="IE=9" />

<?php include "include.php" ?>

</head>

<body>

<?php include "header.php" ?>

<table class="mainTable">
	<tr valign="top">
		<td nowrap="nowrap" id="menu" valign="top" align="left" width="17%">
			<?php include "menu.php"; ?>
		</td>
		<td class="rmiddle" valign="center" align="center" width="83%" bgcolor="CCCCCC">
            <div class="bluHeadPane">LOGIN:</div>
            <div class="middleContentPane" align="center" valign="center">
                 <br/><br/><br/>
                 <font style="font-size:13px; position:relative;" face="arial" color="black">
                      UserName:&nbsp;<input type="text" style="font-size:13px; position:relative; top:0px;" size="14" maxlength="20" id="usrnmfield" />
                      <br/>
                      Password:&nbsp;<input type="password" style="font-size:13px; position:relative; right:-3px; top:0px;" size="14" maxlength="14" id="usrpsw"/>
                      <br/>
                      <br/>
                      <input type="image" src="images/sbmt.png" style="position:relative; right:-12px; top:0px;" alt="submit"  
                         width="75" height="18" onclick="document.getElementById('usrnmfield').value" value="Submit"/>  
                      <br/>
                      <br/>
                      <br/>
                      <p>Bla Bla Bla..&nbsp;.&nbsp;.&nbsp;&nbsp;&nbsp;.&nbsp;Bla Bla .&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;Blaaaaa!</p> 
           </div>  
           </div>
		</td>
	</tr>
</table>

<?php include "footer.php"; ?>

</body>
</html>