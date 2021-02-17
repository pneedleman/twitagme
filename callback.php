<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

/* Start session and load lib */
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

  header('Location: index.php?msg=beta');

ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

/* If the oauth_token is old redirect to the connect page. */
if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  header('Location: clearsessions.php');
}

/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

/* Request access tokens from twitter */
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

/* Save the access tokens. Normally these would be saved in a database for future use. */
$_SESSION['access_token'] = $access_token;


/* Remove no longer needed request tokens */
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);


/* If HTTP response is 200 continue otherwise send to connect page to retry */
if (200 == $connection->http_code) {

  /* The user has been verified and the access tokens can be saved for future use */
  $_SESSION['status'] = 'verified';
  
	
  		//connect to db
		include 'db_connect.php';
		
		$user = $connection->get('account/verify_credentials');
		
		//save username into session
		$_SESSION['username'] = $user->screen_name;
		
		$username =  $user->screen_name;
		
		//check for beta user
		$strSQL = "SELECT allow_beta from users WHERE username = '$username'";
		
		$result1= @mysql_query($strSQL);
		
		if (!$result1) {
				die("Invalid query:<font color = 'red'>  " . mysql_error(). "</font>");
			}

				while ($row = mysql_fetch_array ($result1)){
					
					$allow_beta   = $row[0];

				}
			
		echo "beta". $allow_beta;
		
		if (empty($allow_beta) OR  $allow_beta == 'No') {
	
			  header('Location: index.php?msg=beta');
		
		}
		
		
		$user_img = $user->profile_image_url;
		
		
		$sqlID = "SELECT user_id FROM users WHERE username = '$user->screen_name';";
		
		//echo $sqlID;
		
		$result2= @mysql_query($sqlID);

				while ($row = mysql_fetch_array ($result2)){
					
					$user_id   = $row[0];

				}
		
		
		//echo $user->screen_name;
		

		
		//insert or update user info to DB 
		$strSQL=  "INSERT IGNORE INTO users ( 	display_name,	username,	token,	token_secret , created_on, profile_img) VALUES ('$user->name', '$_SESSION[username]', '$access_token[oauth_token]', '$access_token[oauth_token_secret]', CURRENT_TIMESTAMP(), '$user_img') 
		ON DUPLICATE KEY UPDATE profile_img='$user_img';";
	 
		$result= @mysql_query($strSQL);
				
			if (!$result) {
				die("Invalid query:<font color = 'red'>  " . mysql_error(). "</font>");
			}
			
		//insert or update follower info
		
		$follower_list = $connection->get('friends/ids', array('screen_name' => $_SESSION['username']));
		
		$user_list = "";
		$counter = 1;
		
		foreach($follower_list as $tweet) {
		
			$user_list = $user_list . "," . $tweet; 
			
			//if we get to 100 followers or the end of the list we call the user lookup api to insert followers to DB
			if ($counter%99 == 0 OR $tweet == end($follower_list)) {
			
				//echo "user list #" . $counter . " " . $user_list;
				
				$usercontent = $connection->get('users/lookup', array('user_id' => $user_list)); 
			
				foreach($usercontent as $follower_names) {
							
					$strSQL1= "INSERT IGNORE INTO followers ( 	user_id, twitter_name, created_on) VALUES ( '$user_id', '$follower_names->screen_name', CURRENT_TIMESTAMP());";
							
					$result1= @mysql_query($strSQL1);
					
					if (!$result1) {
						die("Invalid query:<font color = 'red'>  " . mysql_error(). "</font>");
					}
				
					
				}
				$user_list = "";
			}

			$counter++;
				
		} 
		
			
		
  header('Location: feed.php');
} else {
  /* Save HTTP status for error dialog on connnect page.*/
  header('Location: clearsessions.php');
}
