<? session_start();  ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>TwiTagMe</title>
<LINK REL=StyleSheet HREF="style_idx.css" TYPE="text/css" MEDIA=screen>
</head>


<body>


<div id="page">
			
			<?php include 'header.php' ?>
			
			<?php include 'menu.php' ?>
			
	</div>

	<div id="mainarea">
	<div id="contentarea">
		<h2>Beta Registration</h2>
	
	
	<? 
	

	// form submitted
	if(isset($_POST['submit'])) {
		
					
			
					include 'db_connect.php';
					
					$strSQL = "SELECT username, email FROM users WHERE allow_beta = 'No'";
				
					
					 $result= @mysql_query($strSQL);
		
						while ($row = mysql_fetch_array ($result)){
								
					}
	}
	
		
	?>
	  
		Enter your info below. We will contact you when your invite is ready. 
		<form name ='register' method ='POST' action='beta.php'>
			<input type='text' name = "twitter_name" value="Twitter Name"> <br />
			<input type='text' name = "email" value="Email Address"> <br />
			<input type='text' name = "email" value="Verify Email Address"> 
			<input type="submit" value="Submit">
		
	
		</form>



		
		
		<br />
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