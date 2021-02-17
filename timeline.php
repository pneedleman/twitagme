<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">		
<html>


<head>
<title>TwiTagMe</title>
<LINK REL=StyleSheet HREF="style.css" TYPE="text/css" MEDIA=screen>
</head>


<body>

<?php
 	session_start(); 
				
	include 'oauth_conn.php';		

//ini_set('display_errors',1);
//error_reporting(E_ALL|E_STRICT);

		/* Load required lib files. */
	
	if(empty($_GET["page"])){
		$page_num = 1;
	} else {
	    $page_num = $_GET["page"];
		}
	

	
	

	  //get username
	  $user = $connection->get('account/verify_credentials');
	  
	  //get timeline
	  $content = $connection->get('statuses/home_timeline', array('page' => $page_num));
	  
	
?>

<div id="page">
			
			<?php include 'header.php' ?>
			
			<?php include 'menu.php' ?>
			
	</div>

	<div id="mainarea">
	<div id="contentarea">
		<h2> <a href="http://twitter.com/<?echo($user->screen_name); ?>">@<?echo($user->screen_name)."'s</a> timeline"; ?></h2>
		
	 <? 	
		
			
		
		 
	     //$content = $connection->get('account/verify_credentials');
	 
		
	 
		echo "<table cellspacing=5>";
		foreach($content as $tweet) {
			
				echo "<tr>";
				echo "<td><a href=http://twitter.com/". $tweet->user->screen_name .">
					<img src='". str_replace("_normal", "_mini", $tweet->user->profile_image_url) ."' alt='". $tweet->user->screen_name . "' title='". $tweet->user->screen_name . "'></a> </td>";
			
				$text_w_link = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\" rel=\"nofollow\">\\0</a>", $tweet->text);
				
				echo "<td>" . $text_w_link .  "<br><font color='#cccccc' size='1'>from: ". $tweet->source ." </font></td>";
				

				
				echo "</tr>";
				
				
				
			}
	echo "</table>"	;
	 ?>

	 <br />
	 <a href="timeline.php?page=<? echo $page_num + 1;?> "> More</a>
	 

		<br/>
		
	</div>
	
	
	<?php include 'sidebar.php'?>

</div>
	
	<?php include 'footer.php' ?>


</div>

</body>

</html>