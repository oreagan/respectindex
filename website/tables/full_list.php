<?php

//Full List ($min_games+)

$sql = "SELECT * FROM $table WHERE games >= $min_games ORDER BY beats_net DESC, wins DESC";
$result = mysql_query($sql) or die("MySQL error.\n\n" 
                                   . mysql_error());

echo "<table class='uk-table uk-table-striped uk-table-hover'>";


echo "<thead>
		<tr>
			<th>Rank</th>
			<th>Team</th>
			<th>Games w/ Line Set</th>
			<th>Wins vs Spread</th>
			<th>Losses vs Spread</th>
			<th>Pushes</th>
			<th>Net Wins vs Spread</th>
			<th>% Won vs Spread</th>
			<th>% Lost vs Spread</th>
			<th>% Push</th>
		</tr>
	</thead>
	
	<tbody>
	";
	
$rank = 0;
while ( $row = mysql_fetch_array($result) ) {
	
	$team = $row['teamname'];
	
		$no_spaces = preg_replace('/\s+/', '+', $team);
	
	$perc = $row['perc_beat'];
	$beats = $row['beats'];
	$losses = $row['losses'];
	$win_loss = $row['beats_net'];
	$games_w_line = $row['games'];
	$pushes = $row['pushes'];
	$perc_won = $row['perc_beat'];
	$perc_lost = $row['perc_lost'];
	$perc_push = $row['perc_push'];
	
	$rank++;
	
	echo "<tr>
	<td>$rank</td>
	<td><a href='team_page.php?dataset=$dataset&team=$no_spaces'>$team</a></td>
	<td>$games_w_line</td>
	<td>$wins</td>
	<td>$losses</td>
	<td>$pushes</td>
	<td>$win_loss</td>
	<td>$perc_won</td>
	<td>$perc_lost</td>
	<td>$perc_push</td>
	</tr>";
}	

?>
</tbody>
</table>