<?php session_start(); 
	    
		include 'oauth_conn.php';		
		
		$username = $_SESSION['username'];
		
	
		

$q = '';
if (isset($_GET['q'])) {
    $q = strtolower($_GET['q']);
}
if (!$q) {
    return;
}



	include 'db_connect.php';

	$strSQL = "SELECT f.twitter_name FROM users u, followers f WHERE  u.user_id = f.user_id AND username = '$username';";
			
			
			$result= @mysql_query($strSQL);

			while ($row = mysql_fetch_array ($result)){
						
				$twitter_name = $row[0];		
				
				echo  '@' . $twitter_name . "\n";  

			}
			if (!$result) {
					die("Invalid query:<font color = 'red'>  " . mysql_error(). "</font>");
			}



/*
$items = array(
    "Great Bittern" => "Botaurus stellaris",
    "Little Grebe" => "Tachybaptus ruficollis",
    "Black-necked Grebe" => "Podiceps nigricollis",
    "Little Bittern" => "Ixobrychus minutus",
    "Black-crowned Night Heron" => "Nycticorax nycticorax",
    "Purple Heron" => "Ardea purpurea",
    "White Stork" => "Ciconia ciconia",
    "Spoonbill" => "Platalea leucorodia",
    "Red-crested Pochard" => "Netta rufina",
    "Common Eider" => "Somateria mollissima",
    "Atlantic Puffin" => "Fratercula arctica",
    "Black-throated Loon" => "Gavia arctica",
    "Merlin" => "Falco columbarius",
    "Snow Goose" => "Anser caerulescens",
    "Snowy Owl" => "Bubo scandiacus",
    "Snow Bunting" => "Plectrophenax nivalis",
    "Common Grasshopper Warbler" => "Locustella naevia",
    "Golden Eagle" => "Aquila chrysaetos",
    "Black-winged Stilt" => "Himantopus himantopus",
    "Steppe Eagle" => "Aquila nipalensis",
    "Pallid Harrier" => "Circus macrourus",
    "European Storm-petrel" => "Hydrobates pelagicus",
    "Horned Lark" => "Eremophila alpestris",
    "Eurasian Treecreeper" => "Certhia familiaris",
    "Asian Desert Warbler" => "Sylvia nana",
    "Western Orphean Warbler" => "Sylvia hortensis hortensis",
);

*/

//foreach ($items as $key => $value) {
//	if (strpos(strtolower($key), $q) !== false) {
//		echo "$key|$value\n";
//	}
//}
/*
	$user_list = "";

	foreach($content as $tweet) {
	
		$user_list = $user_list . "," . $tweet; 
	
	} 
	
	$usercontent = $connection->get('users/lookup', array('user_id' => $user_list)); 
		
		foreach($usercontent as $followers) {
		
			echo $followers->screen_name . "\n";
		}
*/
//echo "paul|1\n";
//echo "jon|2\n";
//echo "steve|3\n";