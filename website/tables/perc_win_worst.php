<?php

//Lowest % of games beating the spread

$sql = "SELECT * FROM $table WHERE games >= $min_games ORDER BY perc_beat ASC";
$result = mysql_query($sql) or die("MySQL error.\n\n" 
                                   . mysql_error());

echo "<b>Lowest % of games beating the spread</b><br><sub>($min_games games or more with line est'd.)</sub>";
echo "<table class='uk-table uk-table-striped uk-table-hover'>";

for ($i = 0; $i<$rank_here; $i++){

	$row = mysql_fetch_array($result);
	
	$team = $row['teamname'];
	$perc = $row['perc_beat'];
	$wins = $row['beats'];
	$losses = $row['losses'];
	$rank = $i+1;
	echo "<tr><td>$rank</td><td>$team</td><td>$perc ($wins-$losses)</td></tr>";
}	

?>
</table>