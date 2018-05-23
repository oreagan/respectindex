<?php 

//This page, when loaded, will take the d_results raw(ish) data table, process the data, and update the disrepect table

include "includes/db_connect.php";

//Second, get the results for that team
$sql = "SELECT * FROM d_results";
$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
									   . mysql_error());

$games = 0;
$beats = 0;
$not_beat = 0;
$push = 0;
$wins = 0;
$losses = 0;
$no_line = 0;
$wab = 0;
	
while($row = mysql_fetch_array($result)) {
	$games++;
		
	$beat = $row['beat'];

	if ($beat == 'Win') {$beats++;}
	if ($beat == 'Loss') {$not_beat++;}
	if ($beat == 'Push') {$push++;}
	if ($beat == 'N/A') {$no_line++;}

	$winlose = $row['winlose'];
		
	if ($winlose == 'Lost') {$losses++;}
	if ($winlose == 'Won') {$wins++;}
		
	if (($beat == 'Win') && ($winlose == 'Won') ) {$wab++;}
}
	
$wml = $beats - $not_beat;
$moneywin = $beats*100-$not_beat*110;
$gwl = $games - $no_line;

$perc_wab = (1-($gwl-$wab)/$gwl)*100;
$perc_wab = number_format((float)$perc_wab, 2, '.', '');
$perc_wab = "$perc_wab%";

$perc_wl = (1-($games-$gwl)/$games)*100;
$perc_wl = number_format((float)$perc_wl, 2, '.', '');
$perc_wl = "$perc_wl%";
	
$perc_won = (1-($gwl-$beats)/$gwl)*100;
$perc_won = number_format((float)$perc_won, 2, '.', '');
$perc_won = "$perc_won%";
	
$perc_lost = (1-($gwl-$not_beat)/$gwl)*100;
$perc_lost = number_format((float)$perc_lost, 2, '.', '');
$perc_lost = "$perc_lost%";

$perc_push = (1-($gwl-$push)/$gwl)*100;
$perc_push = number_format((float)$perc_push, 2, '.', '');
$perc_push = "$perc_push%";
	
//echo "$team is Wins $beats |  Losses $not_beat   | Pushes $push<br>";
	
$string = "
		games = '$games',<br>
		games_won = '$wins',<br>
		beats = '$beats', <br>
		misses = '$not_beat', <br>
		pushes='$push', <br>
		wins_minus_losses = '$wml', <br>
		moneywin = '$moneywin',<br>
		games_w_line = '$gwl',<br>
		won_and_beat = '$wab',<br>
		perc_won_and_beat = '$perc_wab',<br>
		perc_w_line = '$perc_wl',<br>
		perc_won = '$perc_won',<br>
		perc_lost = '$perc_lost',<br>
		perc_push = '$perc_push'<br>
		";
	
echo "$string";

?>