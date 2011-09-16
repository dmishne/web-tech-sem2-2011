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
				Login
			</div>
            
            <div id="content-middle">     
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
                      </font>         
			</div>
		</div>
	</div>
	
	
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
</div> <!-- wrapper -->
</body>
</html>

            
          