<?php
//Set humidity target based on outside temperature
// Max automatic target humidity levels
$maxhumidity=45;

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

$locationinfo = $nest->getUserLocations();
$exttemp=round($locationinfo[0]->outside_temperature,0);
if ($exttemp>=0) {
	$autotarget=$maxhumidity;
} else {
	// Drop target humidity 5% for every 5degree C drop below 0
	$autotarget=$maxhumidity-(5*round(abs($exttemp/5)));
	}
$success=setHumidity($nest, $autotarget);