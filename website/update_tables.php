<?php 
include 'includes/db_connect.php';
$ranks = [10,25,50];
$min_games = 5;
?>	

<?php 
//Top Winners

foreach($ranks as $rank_here) {
	
$sql = "SELECT * FROM disrespect ORDER BY moneywin DESC, won_and_beat DESC";
$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
                                   . mysql_error());

$string= "<B>Most Disrespected</B><br><sub>a.k.a. Big Winners</sub>";
$string.= "<table class='uk-table uk-table-striped uk-table-hover'>";	
	
	for ($i = 0; $i<$rank_here; $i++){

		$row = mysql_fetch_array($result);

		$team = $row['teamname'];
		$moneywin = $row['moneywin'];
		
		$rank = $i+1;
		
		$string.= "<tr><td>$rank</td><td>$team</td><td>$$moneywin</td></tr>";
	}	
	$string .= "</table>";


	$myfile = "tables/static/bigwinners_$rank_here.html";
	$fh = fopen($myfile, 'w');

	fwrite($fh, $string);
	fclose($fh);
}
?>

<?php 
//Top Losers
foreach($ranks as $rank_here) {
	
$sql = "SELECT * FROM disrespect ORDER BY moneywin ASC, won_and_beat ASC";
$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
                                   . mysql_error());

$string= "<b>Most Overrated</b><br><sub>a.k.a. Biggest Losers</sub>";
$string.= "<table class='uk-table uk-table-striped uk-table-hover'>";

	for ($i = 0; $i<$rank_here; $i++){

		$row = mysql_fetch_array($result);

		$team = $row['teamname'];
		$moneywin = $row['moneywin'];
		
		$rank = $i+1;
		$string.= "<tr><td>$rank</td><td>$team</td><td>$$moneywin</td></tr>";
	}	
	$string .= "</table>";


	$myfile = "tables/static/biglosers_$rank_here.html";
	$fh = fopen($myfile, 'w');

	fwrite($fh, $string);
	fclose($fh);
}
?>

<?php //Perc_win_best

foreach($ranks as $rank_here) {
	
$sql = "SELECT * FROM disrespect WHERE games_w_line >= $min_games ORDER BY perc_won DESC";
$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
                                   . mysql_error());

$string= "<b>Highest % of games beating the spread</b><br><sub>($min_games games or more with line est'd.)</sub>";
$string.= "<table class='uk-table uk-table-striped uk-table-hover'>";

	for ($i = 0; $i<$rank_here; $i++){

		$row = mysql_fetch_array($result);

		$team = $row['teamname'];
		$perc = $row['perc_won'];
		$wins = $row['wins'];
		$losses = $row['losses'];
		$rank = $i+1;
		
		$string.= "<tr><td>$rank</td><td>$team</td><td>$perc ($wins-$losses)</td></tr>";
	}	
	$string .= "</table>";

	$myfile = "tables/static/perc_win_best_$rank_here.html";
	$fh = fopen($myfile, 'w');

	fwrite($fh, $string);
	fclose($fh);
}
?>

<?php //Perc_win_worst
foreach($ranks as $rank_here) {

$sql = "SELECT * FROM disrespect WHERE games_w_line >= $min_games ORDER BY perc_won ASC";
$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
                                   . mysql_error());

$string= "<b>Lowest % of games beating the spread</b><br><sub>($min_games games or more with line est'd.)</sub>";
$string.= "<table class='uk-table uk-table-striped uk-table-hover'>";


	for ($i = 0; $i<$rank_here; $i++){

		$row = mysql_fetch_array($result);

		$team = $row['teamname'];
		$perc = $row['perc_won'];
		$wins = $row['wins'];
		$losses = $row['losses'];
		$rank = $i+1;
		
		$string.= "<tr><td>$rank</td><td>$team</td><td>$perc ($wins-$losses)</td></tr>";
	}	
	$string .= "</table>";

	$myfile = "tables/static/perc_win_worst_$rank_here.html";
	$fh = fopen($myfile, 'w');

	fwrite($fh, $string);
	fclose($fh);
}
?>

<?php //Winning_games
foreach($ranks as $rank_here) {

$sql = "SELECT * FROM disrespect WHERE games_w_line >= $min_games ORDER BY perc_won_and_beat DESC, won_and_beat DESC";
$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
                                   . mysql_error());

$string= "<b>Highest % of games <u>winning</u> AND beating the spread</b><br><sub>($min_games games or more with line est'd.)</sub>";
$string.= "<table class='uk-table uk-table-striped uk-table-hover'>";


	for ($i = 0; $i<$rank_here; $i++){

		$row = mysql_fetch_array($result);

		$team = $row['teamname'];
		$perc = $row['perc_won_and_beat'];
		$wab = $row['won_and_beat'];
		$games = $row['games_w_line'];
		$wins = $row['wins'];
		$losses = $row['losses'];
		$rank = $i+1;
		
		$string.= "<tr><td>$rank</td><td>$team</td><td>$perc% ($wab / $games games)</td></tr>";
	}	
	$string .= "</table>";

	$myfile = "tables/static/winning_games_$rank_here.html";
	$fh = fopen($myfile, 'w');

	fwrite($fh, $string);
	fclose($fh);
}
?>

<?php //Winning_games_abs
foreach($ranks as $rank_here) {
	
$sql = "SELECT * FROM disrespect WHERE games_w_line >= $min_games ORDER BY won_and_beat DESC, perc_won_and_beat DESC";
$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
                                   . mysql_error());

$string= "<b>Most overall games <u>winning</u> AND beating the spread</b><br><font color='#f5f5f5'>_</font>";
$string.= "<table class='uk-table uk-table-striped uk-table-hover'>";

	for ($i = 0; $i<$rank_here; $i++){

		$row = mysql_fetch_array($result);

		$team = $row['teamname'];
		$wab = $row['won_and_beat'];
		$rank = $i+1;
		
		$string.= "<tr><td>$rank</td><td>$team</td><td>$wab</td></tr>";
	}	
	$string .= "</table>";

	$myfile = "tables/static/winning_games_abs_$rank_here.html";
	$fh = fopen($myfile, 'w');

	fwrite($fh, $string);
	fclose($fh);
}
?>

<?php //Full List (above 5)
$sql = "SELECT * FROM disrespect WHERE games_w_line >= $min_games ORDER BY wins_minus_losses DESC, wins DESC";
$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
                                   . mysql_error());
$string = "<table class='uk-table uk-table-striped uk-table-hover'>";

$string.= "<thead>
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
	
	$perc = $row['perc_won'];
	$wins = $row['wins'];
	$losses = $row['losses'];
	$win_loss = $row['wins_minus_losses'];
	$games_w_line = $row['games_w_line'];
	$pushes = $row['pushes'];
	$perc_won = $row['perc_won'];
	$perc_lost = $row['perc_lost'];
	$perc_push = $row['perc_push'];
	
	$rank++;
	
	$string.= "<tr>
	<td>$rank</td>
	<td><a href='team_page.php?team=$no_spaces'>$team</a></td>
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

$string .= "</tbody>
			</table>";

$myfile = "tables/static/full_list.html";
$fh = fopen($myfile, 'w');

fwrite($fh, $string);
fclose($fh);
?>