<?php
// The Nest-Extended Configuration
require_once('../config.php');

//Connect to the Database.
$con=mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);

if ($_GET['datatype'] === 'temp'){
//Setup arrays for Temperature Graph
$outside_temp = array(
	'label' => 'Outside Temp.',
	'color' => '#DF7401',
);

$current_temp = array(
	'label' => 'Current Temp.',
	'color' => '#B40404',
);

$low_target_temp = array(
	'label' => 'Target Temp.',
	'color' => '#848484',
);

$high_target_temp = array(
	'color' => '#848484',
);

$heat_on = array(
	'label' => 'Heat On',
	'color' => '#FF0000',
	'yaxis' => 2,
	'lines' => array('lineWidth' => 0, 'fill' => .30)
);

$ac_on = array(
	'label' => 'AC On',
	'color' => '#0000FF',
	'yaxis' => 2,
	'lines' => array('lineWidth' => 0, 'fill' => .30)
);

$fan_on = array(
	'label' => 'Fan On',
	'color' => '#FFFF00',
	'yaxis' => 2,
	'lines' => array('lineWidth' => 0, 'fill' => .50)
);

$away_status = array(
	'label' => 'Away Mode',
	'color' => '#000000',
	'yaxis' => 2,
	'lines' => array('lineWidth' => 0, 'fill' => .30)
);

$leaf_status = array(
	'label' => 'Leaf Earning',
	'color' => '#00FF00',
	'yaxis' => 2,
	'lines' => array('lineWidth' => 0, 'fill' => .30)
);


//Get data for temperature.
$query = mysql_query('SELECT log_datetime, outside_temp, current_temp, low_target_temp, high_target_temp, heat_on, ac_on, fan_on, away_status, leaf_status FROM nest');

while($r = mysql_fetch_array($query)) {
	$time = strtotime($r['log_datetime'])*1000;
	$outside_temp['data'][] = array($time, $r['outside_temp']);
	$current_temp['data'][] = array($time, $r['current_temp']);
	if ($r['low_target_temp'] !== "0"){$low_target_temp['data'][] = array($time, $r['low_target_temp']);} else {$low_target_temp['data'][] = null;};
	if ($r['high_target_temp'] !== "0.00"){$high_target_temp['data'][] = array($time, $r['high_target_temp']);} else {$high_target_temp['data'][] = null;};
	if ($r['heat_on'] === "1") {$heat_on['data'][] = array($time, $r['heat_on']);} else {$heat_on['data'][] = null;};
	if ($r['ac_on'] === "1") {$ac_on['data'][] = array($time, $r['ac_on']);} else {$ac_on['data'][] = null;};
	if ($r['fan_on'] === "1") {$fan_on['data'][] = array($time, $r['fan_on']);} else {$fan_on['data'][] = null;};
	if ($r['away_status'] === "1") {$away_status['data'][] = array($time, .2);} else {$away_status['data'][] = null;};
	if ($r['leaf_status'] === "1") {$leaf_status['data'][] = array($time, .1, 0);} else {$leaf_status['data'][] = null;};
}

//Build the JSON
$data = array($outside_temp,$current_temp,$low_target_temp,$high_target_temp,$heat_on,$ac_on,$fan_on,$away_status,$leaf_status);
print json_encode($data);

} elseif ($_GET['datatype'] === 'humid'){
//Setup arrays for Humidity Graph
$outside_humidity = array(
	'label' => 'Outside Humidity',
	'color' => '#D7DF01'
);

$target_humidity = array(
	'label' => 'Target Humidity',
	'color' => '#5882FA'
);

$current_humidity = array(
	'label' => 'Current Humidity',
	'color' => '#0B0B61'
);

//Get data for humidity.
$query = mysql_query('SELECT log_datetime, outside_humidity, target_humidity, current_humidity, humidifier_on FROM nest');

while($r = mysql_fetch_array($query)) {
	$time = strtotime($r['log_datetime'])*1000;
	$outside_humidity['data'][] = array($time, $r['outside_humidity']);
	$current_humidity['data'][]= array ($time, $r['current_humidity']);
	$target_humidity['data'][]= array ($time, $r['target_humidity']);
}
//Build the JSON
$data = array($outside_humidity,$current_humidity,$target_humidity);
print json_encode($data);

} elseif ($_GET["datatype"] === "misc"){
//Setup arrays for Misc Graph
$battery_level = array(
	'label' => 'Battery Level',
	'color' => '#088A08'
);

$is_online = array(
	'label' => 'Nest Online',
	'yaxis' => 2,
	'lines' => array("lineWidth" => 0, "fill" => .50, "shadowSize" => 0)
);

//Get data for misc.
$query = mysql_query('SELECT log_datetime, battery_level, is_online FROM nest');

while($r = mysql_fetch_array($query)) {
	$time = strtotime($r['log_datetime'])*1000;
	$battery_level['data'][] = array($time, $r['battery_level']);
	if ($r['is_online'] === "1") {$is_online['data'][] = array($time, $r['is_online']);} else {$is_online['data'][] = null;};
}

//Build the JSON
$data = array($battery_level,$is_online);
print json_encode($data);

}
mysql_close($con);
