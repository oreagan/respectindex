<?php

//Top Winners
$sql = "SELECT * FROM $table ORDER BY moneywin DESC, won_and_beat DESC";
$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
                                   . mysql_error());

echo "<B>Most Disrespected</B><br><sub>a.k.a. Big Winners</sub><br>";
echo "<table class='uk-table uk-table-striped uk-table-hover'>";

for ($i = 0; $i<$rank_here; $i++){

	$row = mysql_fetch_array($result);
	
	$team = $row['teamname'];
	$moneywin = $row['moneywin'];
	
	$rank = $i+1;
	echo "<tr><td>$rank</td><td>$team</td><td>$$moneywin</td></tr>";
}	

?>
</table>