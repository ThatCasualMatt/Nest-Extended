<?php
// Your Nest username and password.
define('USERNAME', 'USERNAME');
define('PASSWORD', 'PASSWORD');

// The timezone you're in.
// See http://php.net/manual/en/timezones.php for the possible values.
date_default_timezone_set('America/New_York');

//Database settings
$hostname='localhost';
$username='USERNAME';
$password='PASSWORD';
$dbname='DATABASE';

//Automatically set humidity target based on outside temperature? 1 = yes, 0 = no
$set_humidity=1;