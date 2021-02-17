<? session_start();  ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>TwiTagMe</title>
<LINK REL=StyleSheet HREF="style_idx.css" TYPE="text/css" MEDIA=screen>
</head>


<body>

<?php

//include 'EPI/EpiCurl.php';
//include 'EPI/EpiOAuth.php';
//include 'EPI/EpiTwitter.php';
//include 'EPI/secret.php';


//$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
?>


<div id="page">
			
			<?php include 'header.php' ?>
			
			<?php include 'menu.php' ?>
			
	</div>

	<div id="mainarea">
	<div id="contentarea">
		<h2>Welcome</h2>
		
			
		TwiTagMe allows you to tag twitter followers in Pictures, create albums, and share with friends.
		
		
		<br />
        <br />
		
		<strong>We are currently in private pre-beta. If you are interested in gaining access <a href='beta.php'>please register here.</a> 
		If you already have access, login below. </strong> <br /><br />
		
		 <? if(isset($_GET["msg"]) && $_GET["msg"]  == "login") {
			
				session_start();
				session_destroy();
				
				unset($_SESSION['username']);
	
				echo "<strong><font color=gray>Your session has timed out. Please login again. </font></strong><br /><br />";
			}
		
		?>
		
		<? 
			require_once('config.php');
			if (CONSUMER_KEY === '' || CONSUMER_SECRET === '') {
			  echo 'You need a consumer key and secret to test the sample code. Get one from <a href="https://twitter.com/apps">https://twitter.com/apps</a>';
			  exit;
			}

			/* Build an image link to start the redirect process. */
			$content = '<a href="redirect.php"><img src="images/sign-in-with-twitter-l.png" alt="Sign in with Twitter"/></a>';
			echo $content;
		
		
		 //if authenticated redirect to feed
			if (isset($_SESSION['username']))
			{
				 header('Location: feed.php');
			}
	
	   
		
		?>

		
		<br/>
		<br/>
		<br/>
		<br /> 

		
	</div>
	
	

	<div id="sidebar">
		<h2> 	</h2>

		

	</div>
	
</div>

		<?php include 'footer.php' ?>
	


</div>

</body>

</html>