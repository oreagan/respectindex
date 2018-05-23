<?php

//Highest % of games beating the spread AND winning

$sql = "SELECT * FROM $table WHERE games >= $min_games ORDER BY perc_won_and_beat DESC, won_and_beat DESC";
$result = mysql_query($sql) or die("MySQL error.\n\n" 
                                   . mysql_error());

echo "<b>Highest % of games <u>winning</u> AND beating the spread</b><br><sub>($min_games games or more with line est'd.)</sub>";
echo "<table class='uk-table uk-table-striped uk-table-hover'>";

for ($i = 0; $i<$rank_here; $i++){

	$row = mysql_fetch_array($result);
	
	$team = $row['teamname'];
	$perc = $row['perc_won_and_beat'];
	$wab = $row['won_and_beat'];
	$games = $row['games'];
	$wins = $row['beats'];
	$losses = $row['losses'];
	$rank = $i+1;
	echo "<tr><td>$rank</td><td>$team</td><td>$perc% ($wab / $games games)</td></tr>";
}	

?>
</table>