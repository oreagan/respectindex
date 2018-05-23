<?php //Presets 

//How many Ranks to display
	$ranks = 10; //Rank the top X teams in each list

	$ranks1 = $ranks; //Ranks for first two lists
	$ranks2 = $ranks; //Ranks for next two lists
	$ranks3 = $ranks; //Ranks for next two lists

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

//How many games as minimum
	$min_games = 5;

	if ($_GET['min_games']) {
	  $min_games = $_GET['min_games'];
	}

//Which data set to use
	
	$dataset = 'd_2017_18';

	if ($_GET['dataset']) {
	  //echo "I'm seeing it<br>";
		$dataset = $_GET['dataset'];
	}

	$table = $dataset ."_r"; //Default is regular season 2017-18
	
	//echo "dataset is $dataset with table $table";
?>


<?php //Which tables? Layout:
//First two tables
$caption1 = "If you bet $110 on your team to beat the spread each week, how much money would you have right now?<br><sub>($110 bet wins $100)</sub>";

$table1 = "bigwinners";
$table2 = "biglosers";

//Next two tables
$caption2 = "Vegas doesn't set a line for every game. What teams won the highest percentage of games that did get lines?";

$table3 = "perc_win_best";
$table4 = "perc_win_worst";

//Final two tables
$caption3 = "Of course, the REAL champs beat the spread while <i>winning</i>";

$table5 = "winning_games";
$table6 = "winning_games_abs";

//Then comes the full table

$full_list = "full_list.php";
if ($min_games == '5') {$full_list = "static/full_list.html";}
?>

<?php //Now to decide if we're using the dynamic PHP lists, or the static HTML ones to save bandwidth

//Disabling this check for now

/*
if ($min_games != '5') {  //Not making static tables for all cases with different min_games. If min_games, just use php.
*/
if (1 == 1) {
	$table1 .= ".php";
	$table2 .= ".php";
	$table3 .= ".php";
	$table4 .= ".php";
	$table5 .= ".php";
	$table6 .= ".php";
}

else{
	if ($ranks1 == 10 || $ranks1 == 25 || $ranks1 == 50) { // If it fits the pre-rendered html files, use them (ie 'static/bigwinners_10.html')
		$table_1 = "static/"; $table_1 .= "$table1"; $table_1 .= "_"; $table_1 .= "$ranks1.html";
		$table1 = $table_1;

		$table_2 = "static/"; $table_2 .= "$table2"; $table_2 .= "_"; $table_2.= "$ranks1.html";
		$table2 = $table_2;	
	}
	else {
		$table1 .= ".php";
		$table2 .= ".php";		
		}

	if ($ranks2 == 10 || $ranks2 == 25 || $ranks2 == 50) { // If it fits the pre-rendered html files, use them (ie 'static/bigwinners_10.html')
		$table_3 = "static/"; $table_3 .= $table3; $table_3 .= "_"; $table_3 .= "$ranks2.html";
		$table3 = $table_3;

		$table_4 = "static/"; $table_4 .= $table4; $table_4 .= "_"; $table_4.= "$ranks2.html";
		$table4 = $table_4;	
	}
	else {
		$table3 .= ".php";
		$table4 .= ".php";		
		}

	if ($ranks3 == 10 || $ranks3 == 25 || $ranks3 == 50) { // If it fits the pre-rendered html files, use them (ie 'static/bigwinners_10.html')
		$table_5 = "static/"; $table_5 .= $table5; $table_5 .= "_"; $table_5 .= "$ranks3.html";
		$table5 = $table_5;

		$table_6 = "static/"; $table_6 .= $table6; $table_6 .= "_"; $table_6.= "$ranks3.html";
		$table6 = $table_6;	
	}
	else {
		$table5 .= ".php";
		$table6 .= ".php";		
		}					
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
		<?php include 'includes/subnav.php' ?>
	
		<div class="uk-block-default uk-h2 uk-text-center uk-margin-large-top">
			<p>Good teams win. Great teams cover.<br>
			<sub>Beating the spread shows that a team did better than most people expected.</sub></p>
		</div>	
		<!--End intro text-->
		
		<!-- Intro Tables Grid --> 			<?php $rank_here = $ranks1; ?>
		<div class="uk-grid uk-grid-medium uk-margin-large-top">
		
		<div class="uk-width-1-1 uk-h3 uk-text-center"><?php echo "$caption1"; ?></div>
	
				<div class="uk-width-1-2 uk-margin-top"><a name="list1"></a>
										<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/$table1" ?>
											<i><sub>Expand List: <a href="index.php?expand1=25#list1">Top 25</a> | <a href="?expand1=50#list1">Top 50</a></sub></i>
										</div>
				</div>
				
				<div class="uk-width-1-2 uk-margin-top">
										<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/$table2" ?>	
											<i><sub>Expand List: <a href="?expand1=25#list1">Top 25</a> | <a href="?expand1=50#list1">Top 50</a></sub></i>
										</div>
				</div>
			
		</div>
		<!-- END GRID-->
		
			
		<!-- 2nd GRID -->
		<div class="uk-grid uk-grid-medium"> 	<?php $rank_here = $ranks2; ?>
		
		<div class="uk-width-1-1 uk-h3 uk-text-center"><?php echo "$caption2"; ?></div>
			
				<div class="uk-width-1-2 uk-margin-top"><a name="list2"></a>
										<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/$table3" ?>
											<i><sub>Expand List: <a href="?expand2=25#list2">Top 25</a> | <a href="?expand2=50#list2">Top 50</a></sub></i>
										</div>
				</div>	
			
				<div class="uk-width-1-2 uk-margin-top">
										<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/$table4" ?>
											<i><sub>Expand List: <a href="?expand2=25#list2">Top 25</a> | <a href="?expand2=50#list2">Top 50</a></sub></i>
										</div>
				</div>
			
		</div>
		<!-- END GRID-->		
			
			
		<!-- 3rd GRID -->				<?php $rank_here = $ranks3; ?>
		<div class="uk-grid uk-grid-medium">
				
		<div class="uk-width-1-1 uk-h3 uk-text-center"><?php echo "$caption3"; ?></div>	

				<div class="uk-width-1-2 uk-margin-top"><a name="list3"></a>
										<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/$table5" ?>
											<i><sub>Expand List: <a href="index.php?expand3=25#list3">Top 25</a> | <a href="?expand3=50#list3">Top 50</a></sub></i>
										</div>
				</div>
				
				<div class="uk-width-1-2 uk-margin-top">
										<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/$table6" ?>
											<i><sub>Expand List: <a href="?expand3=25#list3">Top 25</a> | <a href="?expand3=50#list3">Top 50</a></sub></i>
										</div>
				</div>
			
		</div>
		<!-- END GRID-->	
			
			
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
						<div class="uk-panel uk-panel-box uk-panel-box"><?php include "tables/$full_list" ?>			
						</div>
				</div>
		<!-- End Full List-->
		
			
			
	 </div><!-- Ends center container -->
	
</body>

	
	<?php include 'includes/footer.php' ?>	

</html>