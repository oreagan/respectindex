<?php include 'includes/db_connect.php' ?>	
<?php

	
$table_array = ['d_2011_12','d_2012_13','d_2013_14','d_2014_15','d_2015_16','d_2016_17'];
//$table_array = ['d_2017_18'];

foreach ($table_array as $table) {

	$sql = "SELECT DISTINCT date FROM $table";
	$result = mysql_query($sql) or die("MySQL error.\n\n" 
									   . mysql_error());

	while ( $row = mysql_fetch_array($result) ) {
		
		$date_old = $row['date'];
		
		$date_new = strtotime($date_old);
		$date_new = date('Y-m-d',$date_new);
		
		//echo "$date_new<br>";
		
		$update = "UPDATE $table SET date_temp = '$date_new' WHERE date = '$date_old'";

		$result_update = mysql_query($update) or die(mysql_error());	
	}		
	
	
	/*
	//print_r($data);
	foreach ($data as $pair) {
		//echo "$pair[0] = $pair[1]<br>";

		$oldname = addslashes($pair[0]);
		$newname = addslashes($pair[1]);

		$update = "UPDATE $table SET conf_h = '$newname'	WHERE conf_h = '$oldname'";

		$result_update = mysql_query($update) or die(mysql_error());	
	}

	foreach ($data as $pair) {
		//echo "$pair[0] = $pair[1]<br>";

		$oldname = addslashes($pair[0]);
		$newname = addslashes($pair[1]);

		$update = "UPDATE $table SET conf_a = '$newname'	WHERE conf_a = '$oldname'";

		$result_update = mysql_query($update) or die(mysql_error());	
	}
	echo "Done with $table<br>";
	*/
	
}	
echo "Done";
	
	
/*	
 $csvFile = file('personal/match_conf.csv');
    $data = [];
    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }
*/
	
/*
$table_array = ['d_2011_12','d_2012_13','d_2013_14','d_2014_15','d_2015_16','d_2016_17'];
//$table_array = ['d_2017_18'];

foreach ($table_array as $table) {

	//print_r($data);
	foreach ($data as $pair) {
		//echo "$pair[0] = $pair[1]<br>";

		$oldname = addslashes($pair[0]);
		$newname = addslashes($pair[1]);

		$update = "UPDATE $table SET conf_h = '$newname'	WHERE conf_h = '$oldname'";

		$result_update = mysql_query($update) or die(mysql_error());	
	}

	foreach ($data as $pair) {
		//echo "$pair[0] = $pair[1]<br>";

		$oldname = addslashes($pair[0]);
		$newname = addslashes($pair[1]);

		$update = "UPDATE $table SET conf_a = '$newname'	WHERE conf_a = '$oldname'";

		$result_update = mysql_query($update) or die(mysql_error());	
	}
	echo "Done with $table<br>";
}	
echo "Done";
	*/
	
	
/*	
$confs_old = array();
$confs_new = array();


$sql = "SELECT * FROM conferences";
$result = mysql_query($sql) or die("MySQL error.\n\n" 
                                   . mysql_error());

$count = 0;
while ( $row = mysql_fetch_array($result) ) {
	$conf = $row['conference'];
	
	$confs_old[] = $conf;
	$count++;
}	

$co = array_unique($confs_old);
asort($co);
$confs_old = array_values($co);

//print_r($confs_old);


$sql = "SELECT conf_h, conf_a FROM d_2017_18";
$result = mysql_query($sql) or die("MySQL error.\n\n" 
                                   . mysql_error());

while ( $row = mysql_fetch_array($result) ) {
	$conf = $row['conf_h'];
	$conf2 = $row['conf_a'];

	$confs_new[] = $conf;
	$confs_new[] = $conf2;
}	

//print_r($teams_new);

$confs2 = array_unique($confs_new);
$confs_new = array_values($confs2);

asort($confs_new);

$confs2 = array_values($confs_new);
$confs_new = $confs2;

print_r($confs_old);
echo "<BR><BR>";
print_r($confs_new);
echo "<BR><BR>";


echo "<table class='uk-table uk-table-striped uk-table-hover'>";

$i = 0;
foreach ($confs_new as $conf) {
	echo "<tr><td>$confs_old[$i]</td><td>$conf</td></tr>";
	$i++;
}
echo "</table>";	


echo "Hello";
*/

?>


