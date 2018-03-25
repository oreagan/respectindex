<?php

//Biggest Losers / Most Overrated
$sql = "SELECT * FROM disrespect ORDER BY wins_minus_losses ASC, wins ASC";
$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
                                   . mysql_error());

echo "<b>Most Overrated<br>a.k.a. Biggest Losers<br></b>";
echo "<table class='uk-table uk-table-striped uk-table-hover'>";

for ($i = 0; $i<$rank_here; $i++){

	$row = mysql_fetch_array($result);
	
	$team = $row['teamname'];
	$win_minus_loss = $row['wins_minus_losses'];
	$dollas = $win_minus_loss * 100;
	$rank = $i+1;
	echo "<tr><td>$rank</td><td>$team</td><td>$$dollas</td></tr>";
}	

?>
</table>