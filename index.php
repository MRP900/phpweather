<?php
require 'Models/functions.php';

// Default location data
if (!isset($zip)) {
	$zip = null;
}

//Check for POST
if (!empty($_POST)) {
$_POST = array_map('trim', $_POST);
}

// POST: Sanitize, set action
if (isset($_POST['action'])) {
	$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
} else if (isset($_GET['action'])) {
	$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
} else {
	$action = 'lookup';
}
// Redisplay page with results
if ($action === 'show-weather') {
	$zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING);
	
	get_weather($zip);

	include 'views/lookup.php';
}

// Display Default Page
else if ($action === 'lookup') {
	include 'views/lookup.php';
}
			
?>



