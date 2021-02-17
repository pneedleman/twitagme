		<div id="menulinks">
				<a class="active" href="index.php"><span>Home</span></a>
				<a href="#"><span>About</span></a>
				<a href="#"><span>Privacy</span></a>
				<a href="contact.php"><span>Contact</span></a>
		<? if (isset( $_SESSION['username']) ){ echo "<a href='index.php?msg=login'><span>Exit</span></a>"; }
				else {
					echo "<a href='redirect.php'><span>Login</span></a>";
				}
		?>
			</div>