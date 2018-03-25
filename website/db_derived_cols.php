<?php 

include "includes/db_connect.php";


//UPDATES the wins_minus_losses column
$sql = "SELECT * FROM disrespect ORDER BY wins DESC";
$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
                                   . mysql_error());

while($row = mysql_fetch_array($result)) {
	$team = $row['teamname'];
	$wins = $row['wins'];
	$losses = $row['losses'];
	
	$win_minus_loss = $wins - $losses;
	
	//echo "Team is"; echo $team; echo "and Win/loss is "; echo $win_minus_loss;
	
	
	$update = "UPDATE disrespect SET wins_minus_losses = '$win_minus_loss' WHERE teamname = '$team'";
	$result_update = mysql_query($update) or die("Unable to create list of users.\n\n" 
                                   . mysql_error());
	
}	

echo "Hello!";


?>