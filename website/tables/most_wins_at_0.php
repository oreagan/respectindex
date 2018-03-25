<?php

//Most wins with least variation from 50/50

$sql = "SELECT * FROM disrespect WHERE wins_minus_losses = '0' AND wins > '0' ORDER BY wins DESC";
$result = mysql_query($sql) or die("MySQL error.\n\n" 
                                   . mysql_error());

echo "<b>Most wins, while beating the spread as often as not</b>";
echo "<table class='uk-table uk-table-striped uk-table-hover'>";

$i = 0;
while ($row = mysql_fetch_array($result)) {
	
	if ($i == $rank_here) break;
	
	$team = $row['teamname'];
	$wins = $row['games_won'];
	$beats = $row['wins'];
	$losses = $row['losses'];
	$beat_net = $row['wins_minus_losses'];

	$rank = $i+1;
	echo "<tr><td>$rank</td><td>$team</td><td>Results vs spread: $beats-$losses</td></tr>";
	$i++;
	
	
}

if ($i < $rank_here) {

	$sql = "SELECT * FROM disrespect WHERE wins_minus_losses = '1' OR wins_minus_losses = '-1' ORDER BY games_won DESC";
	$result = mysql_query($sql) or die("MySQL error.\n\n" 
                                   . mysql_error());
	
	while ($row = mysql_fetch_array($result)) {

		if ($i == $rank_here) break;
		
		$team = $row['teamname'];
		$wins = $row['games_won'];
		$beats = $row['wins'];
		$losses = $row['losses'];
		$beat_net = $row['wins_minus_losses'];

		$rank = $i+1;
		echo "<tr><td>$rank</td><td>$team</td><td>Results vs spread: $beats-$losses</td></tr>";
		$i++;	
	
	}
 
	
}
	
/*
for ($i = 0; $i<$rank_here; $i++){

	$row = mysql_fetch_array($result);
	
	$team = $row['teamname'];
	$wins = $row['games_won'];
	$beat_net = $row['wins_minus_losses'];

	$rank = $i+1;
	echo "<tr><td>$rank</td><td>$team</td><td>Beat spread net $beat_net ($wins wins)</td></tr>";
}
*/

?>
</table>