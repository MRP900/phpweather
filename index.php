<?php
require 'models/functions.php';

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
	$weather = array();
	$error = "";
	$state = "";

	// Zip Code Validation
	if (validate_zip_code($zip)) {
		$weather = get_weather($zip);
		$state = get_state($zip);
	}
	else {
		$error = "Error: Zip Code must be five numbers!";
	}
	if (empty($error) && ($weather["cod"]) === "404") {
		$error = "City not found";
	}
	include 'views/lookup.php';
}

// Display Default Page
else if ($action === 'lookup') {
	include 'views/lookup.php';
}			
?>



