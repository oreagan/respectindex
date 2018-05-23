<!DOCTYPE html>
<html>

	<?php include 'includes/head.php' ?>	
	<?php include 'includes/db_connect.php' ?>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
	
<body>		
	
	<!--HEADER-->
	<?php include 'includes/header.php' ?>
	<!--HEADER END-->

	<div class="uk-container uk-container-center">
	
		<div class="uk-block-default uk-margin-large-top">
			<h3><b>Data</b></h3>
			
			<p>This site is built from data on the closing lines provided by Las Vegas casinos, as recorded on <a href="VegasInsider.com">VegasInsider.com</a> (<a href="http://www.vegasinsider.com/college-basketball/teams/">http://www.vegasinsider.com/college-basketball/teams/</a>).</p>
			
			<p><b>NOTE:</b> I chose to stop collecting data beyond the start of March Madness (i.e. pre-March 13, 2018). The presence of Cinderella teams at the top of some of these rankings is much more interesting than it might otherwise be!</p>
			
			<p>After grabbing the data, I processed basic derivitive statistics (e.g. "net wins vs. the spread") using Python scripts, then entered this information into a MySQL database.</p>
			
			<p>From there, PHP code grabs the appropriate data and embeds it in the different tables. The specific code is availble at <a href="https://github.com/oreagan/respectindex">https://github.com/oreagan/respectindex</a> .</p>
		</div>
		
		<div class="uk-block-default uk-margin-large-top">
			<h3><b>Full-Season Stats</b></h3>
			
			<p>Is this overall data set any good? We would expect Vegas to win in the end. Using the entire data set for the 2017-2018 college basketball season:</p>
			
			<div class="uk-panel uk-width-1-3 uk-panel-box uk-panel-box">
				<table class='uk-table uk-table-striped uk-table-hover'>	
					<tr><td>Games played</td><td>11,252</td></tr>
					<tr><td>Team beat the spread</td><td>3,854</td></tr>				
					<tr><td>Team lost to spread</td><td>3,856</td></tr>
					<tr><td>Pushes</td><td>164</td></tr>
					<tr><td>Losses if bet $110 on every game</td><td>$38,760</td></tr>				
					<tr><td>Games both won & beat spread</td><td>2,990 (38%)</td></tr>
					<tr><td>Teams beating spread more than not</td><td>134 (45%)</td></tr>
					<tr><td>Teams losing to spread more than not</td><td>135 (45%)</td></tr>
				</table>
			</div>
			
			
			<div class="uk-block-default">
				<!--Chart.js -->
				<canvas id="bar-chart"></canvas>
				<script>				
						new Chart(document.getElementById("bar-chart"), {
						type: 'bar',
						data: {
						  labels: ["-14","-13","-12","-11","-10","-9","-8","-7","-6","-5","-4","-3","-2","-1","0","1","2","3","4","5","6","7","8","9","10","11","12","13","14"],
						  datasets: [
							{
							  label: "Teams with net wins (5+ games with lines set)",
							  backgroundColor: "#3e95cd",
							  data: [1,0,3,3,3,3,2,8,16,7,21,26,13,30,28,30,20,17,11,17,7,6,9,8,4,4,0,0,1]
							}
						  ]
						},
						options: {
							scales: {
								xAxes: [{
									scaleLabel: {
										display: true,
										labelString: 'Net Wins vs. Spread'
									}
								}],
								yAxes: [{
									ticks: {max: 30},
									scaleLabel: {
										display: true,
										labelString: '# of Teams'
									}
								}]
							},
						}
					});
				
				</script>	
			
			</div>
			
			<div><br>This basically fits a normal distribution. Two standard deviations from the mean is a little under 10 wins (or losses) vs. the spread.<br><br>
			
				9 teams (~3%) had 10 or more wins, 10 (~3%) lost 10+ net times to the spread. 6% beyond two standard deviations is a bit high.<br>If we consider (+/-)11+ to be the mark, it's 12 teams (4%) truly beyond (not just at) two standard devs - almost exactly what we would expect.<br><br>
				
				So, does the overall metric tell us anything of statistical significance about a given team? Probably not, at least in a rigorous way. There are other caveats, too - not all teams had equal numbers of lines set, for example. But it's fun!		
			</div>
			
			
		</div>
		
		
			
			
	 </div><!-- Ends center container -->
	
</body>

	
	<?php include 'includes/footer.php' ?>	

</html>