<?php include "beforeLoadCheck.php"; ?>
<div id="transBlackbox">
		<div id="logo"> </div> 
		<div id="logoHeading"></div>
		<div id="loginBox">
		<?php 
			if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0')) {
				echo "<a style=\"float:left; margin:5px auto 5px 15px;\" class=\"blue buttonStyle medium\" href=\"login.php\"> Login </a>
				      <br />
					  <a style=\"float:left; margin:5px auto 5px 15px; margin-top:5px;\" class=\"blue buttonStyle medium\" href=\"signuppage.php\"> Sign Up </a>";
			}
			else {
				if (isset($_SESSION['update']) && $_SESSION['update'])
				{
					$connection = new mysqli($serverInfo["address"], $serverInfo["username"], $serverInfo["password"]);
					if (mysqli_connect_errno()) {
						die('Could not connect: ' . mysqli_connect_error());
					}
					$connection->select_db($serverInfo["db"]);
					$username = $_SESSION['username'];
					$newres = $connection->query("CALL getBalance('$username')") or die(mysqli_error());
					$bal = $newres->fetch_array(MYSQLI_NUM);
					if($newres->num_rows > 0) {
						$_SESSION['balance'] = round($bal[0],2);
						$_SESSION['update'] = 0;
					}
				}
				$title = "title=\"Balance\"";
				if ($_SESSION['balance'] < 0){
					$div = "<div style=\"white-space: nowrap; \" class=\"redh roundedh meduim\" {$title}>";
				}				
				else {
					$div = "<div style=\"white-space: nowrap; \" class=\"greenh roundedh meduim\" {$title}>";
				}
				echo "<span style=\"white-space: nowrap;  width:100%; \"> Hello {$_SESSION['firstname']}, </span>
					  <br />
					  {$div} {$_SESSION['balance']}$ </div>
					  <a class=\"blue buttonStyle medium\" href=\"index.php?logout=1\"> Logout </a>";
				
			}
		?>
			
		</div>
</div>