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

	
		<h2> <? echo $_SESSION['username']  . "'s Pictures" ?> </h2>
				
				
				<a href="albums.php?create"><img style='vertical-align:middle;' src='images/add.png'>
				<span style="">create album</span></a>
		
		
		
		<? 	//create new album
			if(isset($_GET['create'])) {
			
				echo "<form action='albums.php' method='POST'>";
				
				echo "Album Name <input type='text' name='album_name'>";
			
				echo " <input type='submit' value='Create' name='submit'>";
				echo "</form>";
			}
			
			//add new album to DB
			if(isset($_POST['submit'])) {
			
			
				include 'db_connect.php';
				
				$username = $_SESSION['username'];
				
				$strSQL=  "SELECT u.user_id FROM users u WHERE u.username = '$username';";
	 
				$result= @mysql_query($strSQL);

				while ($row = mysql_fetch_array ($result)){
					
					$user_id   = $row[0];

					}
		
				$strSQL=  "INSERT INTO album (user_id, album_name, created_on ) VALUES ($user_id, '$_POST[album_name]', CURRENT_TIMESTAMP())";
	 
				$result= @mysql_query($strSQL);
				
			}
	
			//delete album & pics from DB
			
			//implement delete album code
				
			
		
		?>
			

		<table  width="500" border='0' cellspacing = "20"  align="center" > 

		<?
		
		$username = $_SESSION['username'];
		
		include 'db_connect.php';
		
	
		//get pics 
		//$strSQL1= "SELECT id, email, sub, CASE WHEN LENGTH(BODY) > 20 THEN CONCAT(SUBSTR(body,1,20), '...')  ELSE body END body , timezone.code, recur, next_run  FROM tasks, timezone WHERE  tasks.timezone = timezone.timezone AND user_id='$session_id';";
		 $strSQL1=  "SELECT a.album_id, album_name FROM album a, users u WHERE a.user_id = u.user_id AND u.username = '$username'";
 
		$rownum = 0;
	
		$result1= @mysql_query($strSQL1);

		if(mysql_num_rows($result1)==0){
		 echo "<br /><br />No pictures uploaded. Add some now...";
		}
		else {
		
		//we have pics, display them
		
		while ($row = mysql_fetch_array ($result1)){
				
			$album_id   = $row[0];
			$album_name = $row[1];
			

			//after 4 albums we wrap using a TR 
			if( $rownum % 4 == 0){ 
				echo "<tr>";
				}
        
			echo "<td align=center><a href='pics.php?album=$album_id'><img src='images/folder.png' class='none'> 
				  <br /><center>" .$album_name . "</center></a></td>";
	 
		   // echo "<td>" . $v_body . "</td>"; 
        
		
		
			$rownum++;
		
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