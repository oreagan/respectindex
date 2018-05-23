<?php 

//This page, when loaded, will take the d_results raw(ish) data table, process the data, and update the disrepect table


//$table_array = ['d_2011_12','d_2012_13','d_2013_14','d_2014_15','d_2015_16','d_2016_17'];
$table_array = ['d_2016_17'];

foreach ($table_array as $table) {
	
	echo "starting $table     ";
	
	//$table = "d_2017_18";
	$table_update = $table . "_r";  $switch = "rs";//For regular season only
	//$table_update = $table . "_p";   $switch = "ps"; //For postseason included

	//echo "Table_update is $table_update<BR><BR>";

	include "includes/db_connect.php";

	//First, get the teamnames
	$sql = "SELECT teamname FROM conferences";
	$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
									   . mysql_error());

	$team_array = array();
	while($row = mysql_fetch_array($result)) {
		$team_array[] = $row['teamname'];
	}	

	foreach ($team_array as $team) {
		$games = 0;
		$beats = 0;
		$not_beat = 0;
		$push = 0;
		$wins = 0;
		$losses = 0;
		$wab = 0;

		//Second, get the results for that team's home games
		if ($switch == 'rs') {
			//Get just regular season games
			$sql = "SELECT * FROM $table WHERE team_h = '$team' AND (gametype = 'Regular Season' OR gametype = 'Conf. Tournament')";
		}
		else {
			//Get all games
			$sql = "SELECT * FROM $table WHERE team_h = '$team'";
		}
		$result = mysql_query($sql);

		while($row = mysql_fetch_array($result)) {
			$games++;

			$beat = $row['beat'];

			if ($beat == 'Beat') {$beats++;}
			if ($beat == 'Lost') {$not_beat++;}
			if ($beat == 'Push') {$push++;}

			$score_h = $row['score_h'];
			$score_a = $row['score_a'];

			if ($score_h > $score_a) {
				 $won = 1;
				 $wins++;}
			else $losses++;

			if (($beat == 'Beat') && ($won == 1) ) {$wab++;}
		}

		//Third, results for away games	
		if ($switch == 'rs') {
			//Get just regular season games
			$sql = "SELECT * FROM $table WHERE team_a = '$team' AND (gametype = 'Regular Season' OR gametype = 'Conf. Tournament')";
		}
		else {
			//Get all games
			$sql = "SELECT * FROM $table WHERE team_a = '$team'";
		}
		$result = mysql_query($sql);

		while($row = mysql_fetch_array($result)) {
			$games++;

			$beat = $row['beat'];

			if ($beat == 'Lost') {$beats++;}
			if ($beat == 'Beat') {$not_beat++;}
			if ($beat == 'Push') {$push++;}

			$score_h = $row['score_h'];
			$score_a = $row['score_a'];

			if ($score_h < $score_a) {
				 $won = 1;
				 $wins++;}
			else $losses++;

			if (($beat == 'Lost') && ($won == 1) ) {$wab++;}
		}

		$wml = $beats - $not_beat;
		$moneywin = $beats*100-$not_beat*110;
		$gwl = $games - $no_line;

		$perc_wab = (1-($gwl-$wab)/$gwl)*100;
		$perc_wab = number_format((float)$perc_wab, 2, '.', '');
		$perc_wab = "$perc_wab%";

		$perc_beat = (1-($gwl-$beats)/$gwl)*100;
		$perc_beat = number_format((float)$perc_beat, 2, '.', '');
		$perc_beat = "$perc_beat%";

		$perc_lost = (1-($gwl-$not_beat)/$gwl)*100;
		$perc_lost = number_format((float)$perc_lost, 2, '.', '');
		$perc_lost = "$perc_lost%";

		$perc_push = (1-($gwl-$push)/$gwl)*100;
		$perc_push = number_format((float)$perc_push, 2, '.', '');
		$perc_push = "$perc_push%";

		//echo "$team is Wins $beats |  Losses $not_beat   | Pushes $push<br>";

		$update = "UPDATE $table_update SET 

				games = '$games',
				games_won = '$wins',
				beats = '$beats', 
				losses = '$not_beat', 
				pushes='$push', 
				beats_net = '$wml', 
				moneywin = '$moneywin',
				won_and_beat = '$wab',
				perc_won_and_beat = '$perc_wab',
				perc_beat = '$perc_beat',
				perc_lost = '$perc_lost',
				perc_push = '$perc_push'

				WHERE teamname = '$team'";

		$result_update = mysql_query($update) or die("Unable to create list of users.\n\n" 
									   . mysql_error());
	}

	echo "Done with $table<br>";
}

echo "Hello!";

?>