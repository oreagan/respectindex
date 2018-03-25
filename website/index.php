<?php //Presets 

//How many Ranks to display
	$ranks = 10; //Rank the top X teams in each list

	$ranks1 = $ranks; //Ranks for first two lists
	$ranks2 = $ranks; //Ranks for next two lists
	$ranks3 = $ranks; //Ranks for next two lists
	$ranks4 = $ranks; //Ranks for next two lists

	//Check for Expand List command
	if ($_GET['expand1']) {
	  $ranks1 = $_GET['expand1'];
	}

	if ($_GET['expand2']) {
	  $ranks2 = $_GET['expand2'];
	}

	if ($_GET['expand3']) {
	  $ranks3 = $_GET['expand3'];
	}

	if ($_GET['expand4']) {
	  $ranks4 = $_GET['expand4'];
	}

//How many games as minimum
	$min_games = 5;

	if ($_GET['min_games']) {
	  $min_games = $_GET['min_games'];
	}	
?>

<!DOCTYPE html>
<html>

	<?php include 'includes/head.php' ?>	
	<?php include 'includes/db_connect.php' ?>	
	
<body>		
	
	<!--HEADER-->
	<?php include 'includes/header.php' ?>
	<!--HEADER END-->

		<!--Intro text-->
		<div class="uk-container uk-container-center">
	
		<div class="uk-block-default uk-h2 uk-text-center uk-margin-large-top">
			<p>Beating the spread shows that a team did better than most people expected.<br>
			<sub>Good teams win. Great teams cover.</sub></p>
		</div>	
		<!--End intro text-->
		
		<!-- Intro Tables Grid --> 			<?php $rank_here = $ranks1; ?>
		<div class="uk-grid uk-grid-medium uk-margin-large-top">
		
		<div class="uk-width-1-1 uk-h3 uk-text-center">If you bet $100 on your team to beat the spread each week, how much money would you have right now?</div>
	
				<div class="uk-width-1-2 uk-margin-top">
										<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/bigwinners.php" ?><!-- Big Winners -->
											<i><sub>Expand List: <a href="index.php?expand1=25">Top 25</a> | <a href="?expand1=50">Top 50</a></sub></i>
										</div>
				</div>
				
				<div class="uk-width-1-2 uk-margin-top">
										<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/biglosers.php" ?><!-- Biggest Losers -->	
											<i><sub>Expand List: <a href="?expand1=25">Top 25</a> | <a href="?expand1=50">Top 50</a></sub></i>
										</div>
				</div>
			
		</div>
		<!-- END GRID-->
		
			
			
			
		<!-- 2nd GRID -->
		<div class="uk-grid uk-grid-medium"> 	<?php $rank_here = $ranks2; ?>
		
		<div class="uk-width-1-1 uk-h3 uk-text-center">Vegas doesn't set a line for every game. What teams won the highest percentage of games that did get lines?</div>
			
				<div class="uk-width-1-2 uk-margin-top">
										<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/perc_win_best.php" ?>	<!-- Highest % of games beating the spread (5+ games) -->
											<i><sub>Expand List: <a href="?expand2=25">Top 25</a> | <a href="?expand2=50">Top 50</a></sub></i>
										</div>
				</div>	
			
				<div class="uk-width-1-2 uk-margin-top">
										<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/perc_win_worst.php" ?>	<!-- Lowest % of games beating the spread (5+ games) -->
											<i><sub>Expand List: <a href="?expand2=25">Top 25</a> | <a href="?expand2=50">Top 50</a></sub></i>
										</div>
				</div>
			
		</div>
		<!-- END GRID-->		
			
			
		<!-- 3rd GRID -->				<?php $rank_here = $ranks3; ?>
		<div class="uk-grid uk-grid-medium">
				
		<div class="uk-width-1-1 uk-h3 uk-text-center">Of course, the REAL champs beat the spread while <i>winning</i></div>	

				<div class="uk-width-1-2 uk-margin-top">
										<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/winning_games.php" ?>
											<i><sub>Expand List: <a href="index.php?expand3=25">Top 25</a> | <a href="?expand3=50">Top 50</a></sub></i>
										</div>
				</div>
				
				<div class="uk-width-1-2 uk-margin-top">
										<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/winning_games_abs.php" ?>
											<i><sub>Expand List: <a href="?expand3=25">Top 25</a> | <a href="?expand3=50">Top 50</a></sub></i>
										</div>
				</div>
			
		</div>
		<!-- END GRID-->	
			
<? /* Commenting this one out for now	
		<!-- 4th GRID -->				<?php $rank_here = $ranks4; ?>
		<div class="uk-grid uk-grid-medium">
				
		<div class="uk-width-1-1 uk-h3 uk-text-center">And some teams do just what we all expected</div>
			
				<div class="uk-width-1-2 uk-margin-top">
										<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/most_wins_at_0.php" ?>
											<i><sub>Expand List: <a href="index.php?expand4=25">Top 25</a> | <a href="?expand4=50">Top 50</a></sub></i>
										</div>
				</div>
				
				<div class="uk-width-1-2 uk-margin-top">
										<div class="uk-panel uk-panel-box uk-panel-box"><?php echo "Placeholder<br><BR><BR>"; //include "tables/winning_games_abs.php" ?>
											<i><sub>Expand List: <a href="?expand4=25">Top 25</a> | <a href="?expand4=50">Top 50</a></sub></i>
										</div>
				</div>
			
		</div>
		<!-- END GRID-->		
			*/ 
?>
			
			
		<!--Full list -->
		<div class="uk-block uk-h2 uk-text-center">
			
			Full List<br>
			<div class="uk-h3">
				<i>Only showing teams who played <?php echo $min_games;?>+ games for which Vegas set odds. | Set minimum to: <a href="?min_games=1">1</a> <a href="?min_games=5">5</a> <a href="?min_games=10">10</a></i>
			</div>
		</div>		

		<div class="uk-overflow-container">	
			
			<!--Wins vs Spread (5+ games)-->
				<div class="uk-width-1-1">
						<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/list_above_5.php" ?>			
						</div>
				</div>
		<!-- End Full List-->
		
			
			
	 </div><!-- Ends center container -->
	
</body>

	
	<?php include 'includes/footer.php' ?>	

</html>