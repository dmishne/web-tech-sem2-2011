<div id="transBlackbox">
		<div id="logo">  <!-- <img id="underConstruction" src="images/under-construction.png" /> --> </div> 
		<div id="logoHeading">Imanage </div>
		<div id="loginBox">
		<?php
			if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0')) {
				echo "<a class=\"blue buttonStyle medium\" href=\"login.php\"> Login </a>
				      <br />
					  <a class=\"blue buttonStyle medium\" href=\"signuppage.php\" style=\"margin-top:5px\"> Sign Up </a>";
			}
			else {
				if ($_SESSION['update'])
				{
					$connection = new mysqli("remote-mysql4.servage.net", "webtech", "12345678");
					if (mysqli_connect_errno()) {
						die('Could not connect: ' . mysqli_connect_error());
					}
					$connection->select_db('webtech');
					$username = $_SESSION['login'];
					$newres = $connection->query("CALL getBalance('$username')") or die(mysqli_error());
					$bal = $newres->fetch_array(MYSQLI_NUM);
					if($newres->num_rows > 0) {
						$_SESSION['balance'] = $bal[0];
						$_SESSION['update'] = 0;
					}
					
				}
				echo "Hey {$_SESSION['firstname']},
					  <br />
					  Balance: {$_SESSION['balance']} 
					  <br />
					  <a class=\"blue buttonStyle medium\" href=\"index.php?logout=1\"> Logout </a>";
				
			}
		?>
			
		</div>
</div>