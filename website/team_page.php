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
	
	$dataset = "d_2017_18"; //Rank the top X teams in each list
	
	if ($_GET['dataset']) {
	  $dataset = $_GET['dataset'];
	}
		
?>

<?php //Gather the data


$sql = "
SELECT * FROM $dataset
WHERE team_h='$team' OR team_a='$team'
ORDER BY date ASC";
$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
                                   . mysql_error());

$profit = 0;
$string = " ";
while ( $row = mysql_fetch_array($result) ) {
	
	$team_h = $row['team_h'];
	$team_a = $row['team_a'];
	$date = $row['date'];
	$beat = $row['beat'];
	
	if ($team_h == $team) {
		if ($beat == 'Lost') {$profit = $profit-110;}
		if ($beat == 'Beat') {$profit = $profit+100;}
	}
	else {
		if ($beat == 'Beat') {$profit = $profit-110;}
		if ($beat == 'Lost') {$profit = $profit+100;}			
	}
	
	$string .= "{x: '";
	
	$string .= "$date', y: $profit},";
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
		<?php include 'includes/subnav.php' ?>
		
			<div class="uk-block-default uk-h2 uk-text-center uk-margin-large-top">
				<p><?php echo "$team Timeseries"; ?><br>
					<sub>Based on $110 weekly bet to beat the spread.</sub>
			</div>
			
			
			
			<div class="uk-grid uk-grid-medium"> 	
		
				<div class="uk-width-1-4 uk-h3 uk-text-center">
					<table class='uk-table uk-table-striped uk-table-hover'>
					
					<?php
						
						//Get full list of teams 
						$sql = "
							SELECT teamname FROM conferences";
							$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
															   . mysql_error());

						$team_array = array();
						while ( $row = mysql_fetch_array($result) ) {
							$t = $row['teamname'];
							$team_array[] = $t;
						}
						
						foreach ($team_array as $t) {
							$team_link = str_replace(' ','+',$t);
							
							echo "<tr><td><a href='team_page.php?dataset=$dataset&team=$team_link'>$t</a></td></tr>";
							
						}
						
					?>
								
						
					</table>
				
				</div>
				
				<div class="uk-width-3-4 uk-h3 uk-text-center">
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
				
				</div>
			</div>

				
				
		</div><!-- Ends center container -->
	
</body>

	
	<?php include 'includes/footer.php' ?>	

</html>


