<?php

//Highest % of games beating the spread AND winning

$sql = "SELECT * FROM $table WHERE games >= $min_games ORDER BY won_and_beat DESC, perc_won_and_beat DESC";
$result = mysql_query($sql) or die("MySQL error.\n\n" 
                                   . mysql_error());

echo "<b>Most overall games <u>winning</u> AND beating the spread</b><br><font color='#f5f5f5'>_</font>";
echo "<table class='uk-table uk-table-striped uk-table-hover'>";

for ($i = 0; $i<$rank_here; $i++){

	$row = mysql_fetch_array($result);
	
	$team = $row['teamname'];
	$wab = $row['won_and_beat'];

	$rank = $i+1;
	echo "<tr><td>$rank</td><td>$team</td><td>$wab</td></tr>";
}	

?>
</table>