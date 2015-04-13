<?php
// The Nest-Extended Configuration
require_once('../config.php');

//Connect to the Database.
$con = new mysqli($hostname, $username, $password, $dbname);
if ($con->connect_error) {
	trigger_error('Database connection failed: ' . $con->connect_error, E_USER_ERROR);
}

// Calculate date 1 month ago to limit quantity of data
$cutoff = new DateTime('now');
$cutoff->sub(new DateInterval('P1M'));
$cutoff_ = $cutoff->format('Y-m-d');

// Gather all data into one associative array
$sql = "SELECT UNIX_TIMESTAMP(log_datetime) as log_datetime, outside_temp, outside_humidity, away_status, leaf_status, current_temp, current_humidity, low_target_temp, high_target_temp, target_humidity, heat_on, humidifier_on, ac_on, fan_on, battery_level, is_online FROM nest WHERE log_datetime >= '$cutoff_'";
$query = $con->query($sql) or trigger_error('SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);
$data = array();
while ($r = $query->fetch_assoc()) {
    foreach ($r as $key => $value) {
        $data[$key][] = floatval($value); // Append row
    }
}
$query->close();

//Build the JSON
header('Content-Type: application/json');
echo json_encode($data);

$con->close();
