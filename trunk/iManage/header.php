<div id="transBlackbox">
		<div id="logo"> <img id="underConstruction" src="images/under-construction.png" /> </div>
		<div id="logoHeading">Some sentence </div>
		<div id="loginBox">
		<?PHP
			if (isset($_GET['logout']) && $_GET['logout'] == 1) {
				session_start();
				session_unset();
				session_destroy();
				header ('Location: index.php');
			}
			session_start();
			if (!(isset($_SESSION['login']) && $_SESSION['login'] != '0')) {
				echo "<a class=\"blue button medium\" href=\"login.php\"> Login </a>
				      <br />
					  <a class=\"blue button medium\" href=\"signuppage.php\" style=\"margin-top:5px\"> Sign Up </a>";
			}
			else {
				echo "Hey {$_SESSION['username']},
					  <br />
					  <a class=\"blue button medium\" href=\"index.php?logout=1\"> Logout </a>";
			}
		?>
			
		</div>
</div>