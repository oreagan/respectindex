<?php //Presets
	$dataset = "d_2016_17"; //Rank the top X teams in each list
	
	if ($_GET['dataset']) {
	  $dataset = $_GET['dataset'];
	}
?>

<?php //Get teams in the conference 
	$conference = "ACC"; //Rank the top X teams in each list

	if ($_GET['conf']) {
	  $conference = $_GET['conf'];
	}

	if ($conference == "ae") { $conference = "America East"; }
	if ($conference == "a10") { $conference = "Atlantic 10"; }
	if ($conference == "asun") { $conference = "Atlantic Sun"; }
	if ($conference == "big12") { $conference = "Big 12"; }
	if ($conference == "bigeast") { $conference = "Big East"; }
	if ($conference == "bigsky") { $conference = "Big Sky"; }
	if ($conference == "bigsouth") { $conference = "Big South"; }
	if ($conference == "b10") { $conference = "Big Ten"; }
	if ($conference == "bw") { $conference = "Big West"; }
	if ($conference == "cusa") { $conference = "Conference USA"; }
	if ($conference == "mid-a") { $conference = "Mid-American"; }
	if ($conference == "mv") { $conference = "Missouri Valley"; }
	if ($conference == "mw") { $conference = "Mountain West"; }
	if ($conference == "ov") { $conference = "Ohio Valley"; }
	if ($conference == "pl") { $conference = "Patriot League"; }
	if ($conference == "sl") { $conference = "Summit League"; }
	if ($conference == "sb") { $conference = "Sun Belt"; }
	if ($conference == "wc") { $conference = "West Coast"; }

	$colors = ["#1f78b4","#33a02c","#e31a1c","#ff7f00","#6a3d9a","#ffff99","#b15928","#c7c7c7","#a6cee3","#b2df8a","#fb9a99","#fdbf6f","#cab2d6","#565656","##0fff00"];

?>

<!DOCTYPE html>
<html>

	<?php include 'includes/head.php' ?>	
	<?php include 'includes/db_connect.php' ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
	<script src="includes/utils.js"></script>
	
	<script src="node_modules/angular-chart.js/dist/angular-chart.min.js"></script>
	
	
<?php 
//---------------------------
//Get teams in the conference 
	$sql = "
		SELECT * FROM conferences WHERE conference = '$conference'";
		$result = mysql_query($sql) or die("Unable to create list of users.\n\n" 
										   . mysql_error());

	$team_array = array();
	while ( $row = mysql_fetch_array($result) ) {
		$team = $row['teamname'];
		$team_array[] = $team;
	}
	//print_r($team_array);	

//---------------------------
//Gather the data
$datasets = " ";

	$c = 0;
	foreach ($team_array as $team) {
		//----------------------------------
		//Gather data set for this one team	$team
			$sql = "
			SELECT * FROM $dataset 
			WHERE (team_h='$team' OR team_a='$team') AND (gametype = 'Regular Season' OR gametype = 'Conf. Tournament')
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
		
			//echo "<br><BR>$string<BR><BR>";
		//-------------
		//Now, add this data to the datasets

		$color = "red";
		
			$datasets .= "{
					label: '$team',
					borderColor: '$colors[$c]',
					fill: false,
					data: [$string]
				},";
			$c++;
		//----------------------------------
	}
	$datasets = substr($datasets,0,-1); //Removes trailing comma
	
	//echo $datasets;
?>
	
	
<body>		
	
	<!--HEADER-->
	<?php include 'includes/header.php' ?>
	<!--HEADER END-->

	<!--Center container -->
	
	<div class="uk-container uk-container-center">
	<?php include 'includes/subnav.php' ?>
		
		<div class="uk-block-default uk-h2 uk-text-center uk-margin-large-top">
			<p><?php echo "$conference Conference Timeseries"; ?><br>
				<sub>Click the school's color to remove that line.</sub>
		</div>
		
		<div class="uk-block-default">
			<!--Chart.js -->
			<canvas id="canvas"></canvas>
			<script>				
			function getRandomColor() {
				var letters = '0123456789ABCDEF'.split('');
				var color = '#';
				for (var i = 0; i < 6; i++ ) {
					color += letters[Math.floor(Math.random() * 16)];
				}
				return color;
			}

			var timeFormat = 'YYYY-MM-DD';

					var color = Chart.helpers.color;
					var config = {
						type: 'line',
						data: {
							datasets: [
								<?php echo $datasets; ?>
							]
						},
						options: {
							title: {
								text: 'Conference Timescale'
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
										labelString: 'Dollars Won on $110 Weekly Bet'
									}
								}]
							},
						}
					};

				window.onload = function() {
						var ctx = document.getElementById('canvas').getContext('2d');
						window.myLine = new Chart(ctx, config);

					};

				var colorNames = Object.keys(window.chartColors);
					document.getElementById('addDataset').addEventListener('click', function() {
						var colorName = colorNames[config.data.datasets.length % colorNames.length];
						var newColor = window.chartColors[colorName];
						var newDataset = {
							label: 'Dataset ' + config.data.datasets.length,
							backgroundColor: newColor,
							borderColor: newColor,
							data: [],
							fill: false
						};

						for (var index = 0; index < config.data.labels.length; ++index) {
							newDataset.data.push(randomScalingFactor());
						}

						config.data.datasets.push(newDataset);
						window.myLine.update();
					});

			</script>
		
		</div>
		
		<div class="uk-grid uk-grid-medium"> 	
		
		<div class="uk-width-1-3 uk-h3 uk-text-center">
			<div class="uk-panel uk-panel-box uk-panel-box">
				<table class='uk-table uk-table-striped uk-table-hover'>
					<tr><td><a href='conference.php?conf=ACC'>ACC</a></td></tr>
					<tr><td><a href='conference.php?conf=ae'>America East</a></td></tr>
					<tr><td><a href='conference.php?conf=American'>American</a></td></tr>
					<tr><td><a href='conference.php?conf=a10'>Atlantic 10</a></td></tr>
					<tr><td><a href='conference.php?conf=asun'>Atlantic Sun</a></td></tr>
					<tr><td><a href='conference.php?conf=big12'>Big 12</a></td></tr>
					<tr><td><a href='conference.php?conf=bigeast'>Big East</a></td></tr>
					<tr><td><a href='conference.php?conf=bigsky'>Big Sky</a></td></tr>	
					<tr><td><a href='conference.php?conf=bigsouth'>Big South</a></td></tr>
					<tr><td><a href='conference.php?conf=b10'>Big Ten</a></td></tr>
					<tr><td><a href='conference.php?conf=bw'>Big West</a></td></tr>
				</table>
			</div>
		</div>
		
		<div class="uk-width-1-3 uk-h3 uk-text-center">
			<div class="uk-panel uk-panel-box uk-panel-box">
				<table class='uk-table uk-table-striped uk-table-hover'>
					<tr><td><a href='conference.php?conf=Colonial'>Colonial</a></td></tr>
					<tr><td><a href='conference.php?conf=cusa'>Conference USA</a></td></tr>
					<tr><td><a href='conference.php?conf=Horizon'>Horizon</a></td></tr>
					<tr><td><a href='conference.php?conf=Ivy'>Ivy</a></td></tr>
					<tr><td><a href='conference.php?conf=MAAC'>MAAC</a></td></tr>
					<tr><td><a href='conference.php?conf=MEAC'>MEAC</a></td></tr>
					<tr><td><a href='conference.php?conf=mid-a'>Mid-American</a></td></tr>
					<tr><td><a href='conference.php?conf=mv'>Missouri Valley</a></td></tr>
					<tr><td><a href='conference.php?conf=mw'>Mountain West</a></td></tr>
					<tr><td><a href='conference.php?conf=Northeast'>Northeast</a></td></tr>	
					<tr><td><a href='conference.php?conf=ov'>Ohio Valley</a></td></tr>
				</table>
			</div>
		</div>
		
		<div class="uk-width-1-3 uk-h3 uk-text-center">
			<div class="uk-panel uk-panel-box uk-panel-box">
				<table class='uk-table uk-table-striped uk-table-hover'>

					<tr><td><a href='conference.php?conf=Pac-12'>Pac-12</a></td></tr>
					<tr><td><a href='conference.php?conf=pl'>Patriot League</a></td></tr>
					<tr><td><a href='conference.php?conf=SEC'>SEC</a></td></tr>
					<tr><td><a href='conference.php?conf=Southern'>Southern</a></td></tr>
					<tr><td><a href='conference.php?conf=Southland'>Southland</a></td></tr>
					<tr><td><a href='conference.php?conf=sl'>Summit League</a></td></tr>
					<tr><td><a href='conference.php?conf=sb'>Sun Belt</a></td></tr>
					<tr><td><a href='conference.php?conf=SWAC'>SWAC</a></td></tr>
					<tr><td><a href='conference.php?conf=WAC'>WAC</a></td></tr>
					<tr><td><a href='conference.php?conf=wc'>West Coast</a></td></tr>
				</table>
			</div>
		</div>
			
		</div>	
			
	</div>
	<!-- Ends center container -->
	
</body>

	
	<?php include 'includes/footer.php' ?>	

</html>


