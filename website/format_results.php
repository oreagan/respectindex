<?php


include "includes/db_connect.php";



//UPDATES the wins_minus_losses column
$sql = "SELECT * FROM disrespect";
$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
                                   . mysql_error());

/*Get won-and-beat info
while($row = mysql_fetch_array($result)) {
	$team = $row['teamname'];	
	
	$sql_count = "SELECT * FROM d_results WHERE teamname = '$team' AND winlose = 'Won' AND beat = 'Win' ";
	$count = mysql_query($sql_count);
	
	$c = mysql_num_rows($count);
	
	//echo "Team $team Count is $c<br>";
	
	$update = "UPDATE disrespect SET won_and_beat = '$c' WHERE teamname = '$team'";
	$result_update = mysql_query($update) or die("MySql Error.\n\n" 
                                   . mysql_error());	
	
}
*/

/*Get how_many_won info
while($row = mysql_fetch_array($result)) {
	$team = $row['teamname'];	
	
	$sql_count = "SELECT * FROM d_results WHERE teamname = '$team' AND winlose = 'Won'";
	$count = mysql_query($sql_count);
	
	$c = mysql_num_rows($count);
	
	//echo "Team $team Count is $c<br>";
	
	$update = "UPDATE disrespect SET games_won = '$c' WHERE teamname = '$team'";
	$result_update = mysql_query($update) or die("MySql Error.\n\n" 
                                   . mysql_error());	
	
}
*/

/*This section takes the score element (ie Win 73 - 30) and makes it into score and win columns
while($row = mysql_fetch_array($result)) {
	
	$score = $row['score'];
	
	$date = $row['date_temp'];
	$team = $row['teamname'];
	
	$points_scored = $row['points_scored'];
	
	if ($points_scored == 0) {
	
	$pieces = explode(" ",$score);	
	
	$winlose = $pieces[0];
	$points_for = $pieces[1];
	$points_against = $pieces[3];
	
	echo "Team: $team | $winlose  $points_for - $points_against<br>";
	
	$update = "UPDATE d_results SET winlose = '$winlose', points_scored='$points_for', points_oppo='$points_against' WHERE date_temp = '$date' AND teamname = '$team'";
	$result_update = mysql_query($update) or die("MySql Error.\n\n" 
                                   . mysql_error());	
	
	}
}
*/


/* This section took the date (ie Nov 12) and made it into a MYSQL date
while($row = mysql_fetch_array($result)) {
	
	$date_check = $row['date'];
	if ($date_check == '0000-00-00') {
	
	$date = $row['date_temp'];
	$team = $row['teamname'];
	
	//echo "Date is $date<br>";
		
	$pieces = explode(" ",$date);
	
	//echo "Pieces are $pieces[0] and $pieces[1]";
	
	$month = $pieces[0];	
	
	if ($pieces[0] == "Nov") {
		$month = "11";
	}
	if ($pieces[0] == "Dec") {
		$month = "12";
	}	
	if ($pieces[0] == "Jan") {
		$month = "01";		
	}
	if ($pieces[0] == "Feb") {
		$month = "02";			
	}
	if ($pieces[0] == "Mar") {
		$month = "03";			
	}
	
	$day = $pieces[1];
		
	if (($month == 11) || ($month == 12)) {
		$year = 2017;
	}
	else $year = 2018;
	
	$date_new = "$year-$month-$day";
	
	//echo $date_new;
	//echo "<br>";
	
	//$date_new = date($date_new);
	
	//echo $date_new;
	//echo "<br><Br>";
	
	$update = "UPDATE d_results SET date = '$date_new' WHERE date_temp = '$date' AND teamname = '$team'";
	$result_update = mysql_query($update) or die("MySql Error.\n\n" 
                                   . mysql_error());
	
}	
	}
*/

/*This section takes the won_and_beat element and makes it into per_won_and_beat
while($row = mysql_fetch_array($result)) {
	
	$wab = $row['won_and_beat'];
	$games = $row['games_w_line'];
	
	$date = $row['date'];
	$team = $row['teamname'];
	
	$a = (1-($games-$wab)/$games)*100;
	$a = number_format((float)$a, 2, '.', '');
	
	$perc = "$a%";
	
	
	
	$update = "UPDATE disrespect SET perc_won_and_beat = '$perc' WHERE teamname = '$team'";
	$result_update = mysql_query($update) or die("MySql Error.\n\n" 
                                   . mysql_error());	
	
	//}
*/



	
echo "Hello!";


?>