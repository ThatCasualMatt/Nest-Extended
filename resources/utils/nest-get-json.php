<?php
// The Nest-Extended Configuration
require_once('../config.php');

//Connect to the Database.
$con = new mysqli($hostname, $username, $password, $dbname);
if ($con->connect_error) {
	trigger_error('Database connection failed: ' . $con->connect_error, E_USER_ERROR);
}

$str = '';
$cutoff = new DateTime('now');
switch ($_GET['datatype']) {
case 'current':
	// Calculate date 1 month ago to limit quantity of data
	$cutoff->sub(new DateInterval('P1M'));
	$cutoff_ = $cutoff->format('Y-m-d');

	$sql = "SELECT UNIX_TIMESTAMP(log_datetime) as timestamp, outside_temp, outside_humidity, away_status, leaf_status, current_temp, current_humidity, low_target_temp, high_target_temp, target_humidity, heat_on, humidifier_on, ac_on, fan_on, battery_level, is_online FROM nest WHERE log_datetime >= '$cutoff_' ORDER BY log_datetime";
	break;

case 'daily':
	// Calculate date 6 months ago to limit quantity of data
	$cutoff->sub(new DateInterval('P6M'));
	$cutoff_ = $cutoff->format('Y-m-d');

	$sql = "SELECT UNIX_TIMESTAMP(date) as timestamp, total_heating_time, total_cooling_time, heating_degree_days, cooling_degree_days FROM energy_reports WHERE date >= '$cutoff_'";
	break;
}

// Gather all data into one associative array
$data = array();
$query = $con->query($sql) or trigger_error('SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);
while ($r = $query->fetch_assoc()) {
	foreach ($r as $key => $value) {
		if (($key == "outside_temp" or $key == "outside_humidity") and (floatval($value) == 0)){
			$data[$key][] = end($data[$key]); // Append previous row value if current value is zero
		}
		else {
			$data[$key][] = floatval($value); // Append row	
		}
	}
}
$query->close();

//Build the JSON
header('Content-Type: application/json');
echo json_encode($data);

$con->close();
