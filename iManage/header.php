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
				echo "Hey {$_SESSION['firstname']},
					  <br />
					  Balance: {$_SESSION['balance']} 
					  <br />
					  <a class=\"blue buttonStyle medium\" href=\"index.php?logout=1\"> Logout </a>";
				
			}
		?>
			
		</div>
</div>