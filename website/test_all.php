<!DOCTYPE html>
<html>

	<?php include 'includes/head.php' ?>	
	<?php include 'includes/db_connect.php' ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
	<script src="includes/utils.js"></script>
	
	
<?php //Presets 
//Get teams in the conference 
	$conference = "ACC";
	
	$sql = "
		SELECT * FROM conferences";
		$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
										   . mysql_error());

	$team_array = array();
	while ( $row = mysql_fetch_array($result) ) {
		$team = $row['teamname'];
		$team_array[] = $team;
	}

?>

<?php //Gather the data
	
foreach ($team_array as $team) {	

	$sql = "
	SELECT date,beat FROM d_results 
	WHERE teamname='$team' AND line<>'N/A'
	ORDER BY date ASC";
	$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
									   . mysql_error());

	$beat_string = array();

	while ( $row = mysql_fetch_array($result) ) {

		$beat = $row['beat'];

		$beat_string[] = $beat;
	}	

		//print_r($beat_string);

		$best_reinvest = 0;
		$best_bank = -3000;

	for ($i=0; $i<=100; $i++) {	

		$bank = 0;
		$reinvest = $i/100;

		foreach ($beat_string as $beat) {
			if ($bank > 0) { //Only doubling down on wins
				$bet = 110+$bank*$reinvest;
				//$bank = $bank-$bank*$reinvest;
			}
			else {$bet = 110;}

			$bank = $bank-$bet;

			if ($beat == 'Win') {$bank = $bank+$bet*1.9091;}
			if ($beat == 'Push') {$bank = $bank+$bet;}

			$bank = round($bank);

			//echo "Bet: $bet  |  $beat!  |  Bank: $bank  <br>";
		}

		if ($bank > $best_bank) {
			$best_bank = $bank;
			$best_reinvest = $reinvest;
		}

		$result = "$reinvest,$bank";
		//echo "$result <br>";
	}		

		echo "$team,$best_bank,$best_reinvest<br>";
	
}
?>