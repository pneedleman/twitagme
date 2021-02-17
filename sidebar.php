	<?      	//get current page name for activating link

				$currentFile = $_SERVER["PHP_SELF"];
				$parts = Explode('/', $currentFile);
				$page = $parts[count($parts) - 1]; ?>


	


	<div id="sidebar">

	<h2>Menu</h2>



		<a <? if($page == 'feed.php')  { echo "class='active'"; } ?> href="feed.php">My Feed</a><br/>
		<a <? if($page == 'albums.php' || $page == 'pics.php' || $page == 'view_pic.php') { echo "class='active'"; } ?> href="albums.php">My Pictures  </a><br/>
		<a <? if($page == 'follower_tags.php' || $page == 'view_user.php') { echo "class='active'"; } ?> href="follower_tags.php">My Followers Pictures </a><br/>
		<a <? if($page == 'timeline.php') { echo "class='active'"; } ?> href="timeline.php">My Timeline</a><br/>
		<a <? if($page == 'ttmsettings.php') { echo "class='active'"; } ?> href="#">My Settings </a><br/>
		<a href="index.php?msg=login">Exit</a><br/>


		<br />


	</div>





	