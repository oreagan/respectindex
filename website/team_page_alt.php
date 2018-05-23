<!DOCTYPE html>
<html>

	<?php include 'includes/head.php' ?>	
	<?php include 'includes/db_connect.php' ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
	<script src="includes/utils.js"></script>
	
	
<?php //Presets 
	$team = "Virginia Cavaliers"; //Rank the top X teams in each list
	
	if ($_GET['team']) {
	  $team = $_GET['team'];
	}
		
?>

<?php //Gather the data

$sql = "
SELECT date,beat FROM d_results 
WHERE teamname='$team' AND line<>'N/A'
ORDER BY date ASC";
$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
                                   . mysql_error());

$bank = 0;
$reinvest = 0.0; // Percentage of winnings you bet extra next time

$string = " ";
while ( $row = mysql_fetch_array($result) ) {
	
	$string .= "{x: '";
	$date = $row['date'];
	$beat = $row['beat'];	
	
	if ($bank > 0) { //Only doubling down on wins
		$bet = 110+$bank*$reinvest;
		//$bank = $bank-$bank*$reinvest;
	}
	else {$bet = 110;}
	
	$bank = $bank-$bet;
	
	if ($beat == 'Win') {$bank = $bank+$bet*1.9091;}
	$bank = round($bank);
	
	$string .= "$date', y: $bank},";
}
$string = substr($string,0,-1); //Removes trailing comma
	
	//echo $string;
?>
	
	
<body>		
	
	<!--HEADER-->
	<?php include 'includes/header.php' ?>
	<!--HEADER END-->

		<!--Chart-->
		<div class="uk-container uk-container-center">
		
			<div class="uk-block-default uk-h2 uk-text-center uk-margin-large-top">
				<p><?php echo "$team Timeseries"; ?><br>
					<sub>Based on $110 weekly bet to beat the spread.</sub>
			</div>
			
			<div class="uk-block-default">
				<!--Chart.js -->
				<canvas id="canvas"></canvas>
				<script>				

				var dataset = [<?php echo $string; ?>];

				var timeFormat = 'YYYY-MM-DD';

						var color = Chart.helpers.color;
						var config = {
							type: 'line',
							data: {

								datasets: [{
									label: 'Winnings for <?php echo $team; ?>',
									backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
									borderColor: window.chartColors.red,
									fill: false,
									data: dataset,
								}]
							},
							options: {
								title: {
									text: 'Chart.js Time Scale'
								},
								scales: {
									xAxes: [{
										type: 'time',
										time: {
											format: timeFormat,
											// round: 'day'
											tooltipFormat: 'll HH:mm'
										},
										scaleLabel: {
											display: true,
											labelString: 'Date'
										}
									}],
									yAxes: [{
										scaleLabel: {
											display: true,
											labelString: 'Dollars Won'
										}
									}]
								},
							}
						};

					window.onload = function() {
							var ctx = document.getElementById('canvas').getContext('2d');
							window.myLine = new Chart(ctx, config);

						};

				</script>	
			</div>
				
				
		</div><!-- Ends center container -->
	
</body>

	
	<?php include 'includes/footer.php' ?>	

</html>


