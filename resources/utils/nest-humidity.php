<?php
//Set humidity target based on outside temperature

// Don't change this unless you're very very sure, or you may cause damage to your home!
$safelimit=60;

function setHumidity($nest, $humidity) {
		$target=intval($humidity);
		if ($target > $GLOBALS['safelimit']) {
			return(1);
		} elseif ($target < 0 ) {
			$target=0;
		}
		$success=$nest->setHumidity($target);
		return($success);
}

$exttemp = $nest->temperatureInCelsius($locations[0]->outside_temperature);
if ($exttemp>=0) {
	$autotarget=$maxhumidity;
} else {
	// Drop target humidity 5% for every 5degree C drop below 0
	$autotarget = max(0, round($maxhumidity + $exttemp));
	}
$success=setHumidity($nest, $autotarget);
