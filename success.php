<?php 	session_start(); 
	    
		include 'oauth_conn.php';		
		
		$content = $connection->get('account/verify_credentials');
		
		//save username into session
		$_SESSION['username'] = $content->screen_name;
		
			//connect to db
		include 'db_connect.php';
		
		$strSQL=  "INSERT IGNORE INTO users ( 	display_name,	username,	token,	token_secret , created_on) VALUES ('$content->name', '$_SESSION[username]', '$access_token[oauth_token]', '$access_token[oauth_token_secret]', CURRENT_TIMESTAMP())";
	 
		$result= @mysql_query($strSQL);
				
			if (!$result) {
				die("Invalid query:<font color = 'red'>  " . mysql_error(). "</font>");
			}
		
		
		
		?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">		
<html>


<head>
<title>TwiTagMe</title>
<LINK REL=StyleSheet HREF="style.css" TYPE="text/css" MEDIA=screen>
</head>


<body>

<?php


ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

		
		
	     

?>

<div id="page">
	<div id="header">
			<div id="headerleft">
				<h1><img src="images/TwiTagMe.png"></h1>
				
				<div class="description"></div>
			</div>
			<div id="menulinks">
				<a class="active" href="#"><span>Home</span></a>
				<a href="#"><span>About</span></a>
				<a href="#"><span>Privacy</span></a>
				<a href="#"><span>Contact</span></a>

			</div>
			
	</div>

	<div id="mainarea">
	<div id="contentarea">
	
	
		<h2>Welcome <a href="http://twitter.com/<? echo($_SESSION['username']); ?>"> @<?echo($content->screen_name); ?></a></h2>
		
		<? 
		$big_image = str_replace("_normal", "_bigger", $content->profile_image_url);
		
	     echo "<img src=".$big_image .">"; 
		 
		 ?>
		
		
		
		<br /><br />
		TwiTagMe allows you to tag twitter followers in Pictures, create albums, and share with friends.
		
		
		<br/>
		<br/>
		<br/>
		<br/>
	<?	


		
		//print_r($content);

		/* If method is set change API call made. Test is called by default. */
		//$content = $connection->get('account/verify_credentials');

		/* Some example calls */
		//$connection->get('users/show', array('screen_name' => 'abraham')));

		//$connection->post('statuses/update', array('status' => date(DATE_RFC822)));
		//$connection->post('statuses/destroy', array('id' => 5437877770));
		//$connection->post('friendships/create', array('id' => 9436992)));
		//$connection->post('friendships/destroy', array('id' => 9436992)));
	

?>
		<br/>
		
	</div>
	
	
	<?php include 'sidebar.php'?>

	</div>
	
	<div id="footer">
				<a class="active" href="#"><span>Home</span></a> |
				<a href="#"><span>About</span></a> |
				<a href="#"><span>Privacy</span></a> |
				<a href="#"><span>Contact</span></a>

		</div>


</div>

</body>

</html>