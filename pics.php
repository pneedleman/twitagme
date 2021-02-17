<?php 	session_start(); 		?>
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
				

		
	<? //get albumn name to display and navigation 
	
		$username = $_SESSION['username'];
		
		if(isset($_REQUEST['album'])){
		
			$album_id = $_REQUEST['album'];		
		}
		else 
		{
			$album_id = "";
		}
		
		//connect to db
		include 'db_connect.php';
	
		$strSQL=  "SELECT album_name , user_id FROM  album a WHERE  a.album_id = '$album_id';";
 
	    $result= @mysql_query($strSQL);
		
		if(mysql_num_rows($result)==0){
			
			$album_name = "";
			}
		else {
		
		while ($row = mysql_fetch_array ($result)){
				
			$album_name = $row[0];
			$user_id = $row[1];
			
			}
		}
		
		
	
	?>
		

	    
	    <a href="pics.php?upload&album=<? echo $album_id; ?>"><img style='vertical-align:middle;' src='images/add.png'>
				<span style="">add pics</span></a> <br/><br/>
		
		<a href="albums.php">Albums</a> > <? echo $album_name; ?> Album Pictures  		
				
		
		<? 	//addd new pic
			if(isset($_GET['upload'])) {
			
				echo "<form action='pics.php' method='POST' enctype='multipart/form-data'>";
				
				echo " <input type='file' name='image'>";
				echo " <br><input type='text' name='caption' onclick=\"this.value='';\" onfocus=\"this.select()\" onblur=\"this.value=!this.value?'Enter a caption':this.value;\" value=\"Enter a caption\" />";
				echo "<input type='hidden' name='album' value=" . $album_id .">" ;
				echo "  <input type='submit' value='Upload' name='submit'>";
		
				echo "</form>";
			}
		
		//delete a pic
			if(isset($_GET['delete'])) {
			
				$picture_id = $_GET['pic'];
			
				$strSQL=  "DELETE FROM picture WHERE picture_id=$picture_id";
	 
				$result= @mysql_query($strSQL);
				
				$strSQL1=  "DELETE FROM picture_tag WHERE picture_id=$picture_id";
	 
				$result1= @mysql_query($strSQL1);
				
				if (!$result) {
					die("Invalid query:<font color = 'red'>  " . mysql_error(). "</font>");
				} else {
				
				echo "<br> <br> <strong>Your picture has been deleted</strong>";
				}
				
			
			}
		
		//upload picture
		//define a maxim size for the uploaded images in Kb
		 define ("MAX_SIZE","1024"); 

		//This function reads the extension of the file. It is used to determine if the file  is an image by checking the extension.
		 function getExtension($str) {
				 $i = strrpos($str,".");
				 if (!$i) { return ""; }
				 $l = strlen($str) - $i;
				 $ext = substr($str,$i+1,$l);
				 return $ext;
		 }

		//This variable is used as a flag. The value is initialized with 0 (meaning no error  found)  
		//and it will be changed to 1 if an errro occures.  
		//If the error occures the file will not be uploaded.
		 $errors=0;
		//checks if the form has been submitted
		 if(isset($_POST['submit'])) 
		 {
			//reads the name of the file the user submitted for uploading
			$image=$_FILES['image']['name'];
			//if it is not empty
			if ($image) 
			{
			//get the original name of the file from the clients machine
				$filename = stripslashes($_FILES['image']['name']);
			//get the extension of the file in a lower case format
				$extension = getExtension($filename);
				$extension = strtolower($extension);
			//if it is not a known extension, we will suppose it is an error and will not  upload the file,  
			//otherwise we will do more tests
		 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
				{
				//print error message
					echo '<br /><br /><strong>This extension is not supported. Only JPG, PNG or GIF </strong>';
					$errors=1;
				}
				else
				{
		//get the size of the image in bytes
		 //$_FILES['image']['tmp_name'] is the temporary filename of the file
		 //in which the uploaded file was stored on the server
		 $size=filesize($_FILES['image']['tmp_name']);

		//compare the size with the maxim size we defined and print error if bigger
		if ($size > MAX_SIZE*1024)
		{
			echo '<br /><br /><strong>You have exceeded the size limit of 1MB!</strong>';
			$errors=1;
		}

		//we will give an unique name, for example the time in unix time format
		$image_name=time().'.'.$extension;
		//the new name will be containing the full path where will be stored (images folder)
		$newname="user_images/".$image_name;
		//we verify if the image has been uploaded, and print error instead
		$copied = copy($_FILES['image']['tmp_name'], $newname);
		
		
		
		if (!$copied) 
		{
			echo '<br /><br /><strong>Copy unsuccessfull!</strong>';
			$errors=1;
		}}}
		


		//If no errors registred, print the success message
		 if(isset($_POST['submit']) && !$errors) 
		 {
			$strSQL=  "INSERT INTO picture (album_id, user_id, path ,caption, created_on ) VALUES ($album_id, $user_id, '$newname', '$_POST[caption]', CURRENT_TIMESTAMP())";
	 
			$result= @mysql_query($strSQL);
				
			if (!$result) {
				die("Invalid query:<font color = 'red'>  " . mysql_error(). "</font>");
			}
		}
			//echo "<br /><br /><strong>Picture Uploaded Successfully!</strong>";
		 }

		
		
		
		
		//get pics to displau in album
		 $strSQL1=  "SELECT picture_id, caption,	path  FROM picture p WHERE  p.album_id = '$album_id';";
 
	
		$result1= @mysql_query($strSQL1);

		$rownum = 0;

		if(mysql_num_rows($result1)==0){
		 echo "<br /><br /><br /> No pictures uploaded. Add some now...";
		}
		else {
		
		echo "<table  border='0' cellspacing = '15' align = 'center'>"; 

		
		while ($row = mysql_fetch_array ($result1)){
				
			$picture_id = $row[0];
			$caption   = $row[1];
			$img_path   = $row[2];	

		
		//after 4 pics we wrap using a TR 
	    if( $rownum % 4 == 0){ 
			echo "<tr>";
			}

		//trim lengh of long captions
		if( strlen($caption) > 20 ) {
			$caption = substr($caption, 0, 17) . "..." ;
		}
		
	    //echo "<tr>";
        //echo "<td>". $v_email . "</td>";
		echo "<td>" . "<a href='view_pic.php?pic=$picture_id' class='borderit'><img class='borderit' src='". $img_path . "' class='none' width='100' height='100' border='5'> <br /><center>" . $caption .  "</a> <a href='pics.php?delete&pic=$picture_id&album=$album_id' alt='delete' title='delete' onclick=\"return confirm('Are you sure you want to delete this picture and all tags?')\">[x]</center></a></td>";
 
       // echo "<td>" . $v_body . "</td>"; 
        
		$rownum++;
		
			} 
		
		}
		?>
	 
		<!--/tr-->
		</table>
		

		
		
		
		<br /><br />
		
	<?	

	
	

?>
		<br/>
		
	</div>
	
	
	<?php include 'sidebar.php'?>

	</div>
	
	<?php include 'footer.php'?>


</div>

</body>

</html>