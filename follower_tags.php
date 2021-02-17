<?php 	session_start(); 
	
		include 'oauth_conn.php';		
		
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

		/* Load required lib files. */
		

?>

<div id="page">
	
			
			<?php include 'header.php' ?>
			
			<?php include 'menu.php'?>
			
	</div>

	<div id="mainarea">
	<div id="contentarea">	

		
		<?  $username = $_SESSION['username']; ?>
	
		<h2>  <a href='view_user.php?username=<? echo $username . "'>" . $username  . "'s</a> Followers" ?> </h2>
				
				
	
			

		<table  width="200" border='0' cellspacing = "0"  align="left" > 

		<?
		
		
		include 'db_connect.php';
		
	
		//get pics 
		//$strSQL1= "SELECT id, email, sub, CASE WHEN LENGTH(BODY) > 20 THEN CONCAT(SUBSTR(body,1,20), '...')  ELSE body END body , timezone.code, recur, next_run  FROM tasks, timezone WHERE  tasks.timezone = timezone.timezone AND user_id='$session_id';";
		 $strSQL1=  "SELECT f.twitter_name, count(*) cnt  			
		              FROM users u,  `followers` f, picture_tag pt
					 WHERE u.user_id = f.user_id
					   AND f.twitter_name = pt.twitter_name
					   AND u.username = '$username'
				  GROUP BY f.twitter_name;";

	
		$result1= @mysql_query($strSQL1);

		if(mysql_num_rows($result1)==0){
		 echo "<br /><br />No followers with tags :(";
		}
		else {
		
		//we have pics, display them
		
		while ($row = mysql_fetch_array ($result1)){
				
			$twitter_name   = $row[0];
			$tag_count = $row[1];
			

				echo "<tr>";
		
				echo "<td align=left><a href='view_user.php?username=$twitter_name'> 
				  <br /><font size=4>" .$twitter_name . " (" . $tag_count . ") </font></a></td>";
	 
		   // echo "<td>" . $v_body . "</td>"; 
        
	
			} 
		
	}
		?>
	 
		<!--/tr-->
		</table>
		
		
		<br/>
		
	</div>
	
	
	<?php include 'sidebar.php'?>

	</div>
	
	<?php include 'footer.php'?>


</div>

</body>

</html>