<?php
include 'functions/functions.php';

// Code to get last 10 searches from db goes here
$recentSearches = get_top_results();
//Check for POST
if (!empty($_POST)) {
	$_POST = array_map('trim', $_POST);
}
// POST: Sanitize, set action
if (isset($_POST['action'])) {
	$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
} else {
	$action = 'lookup';
}
// Redisplay page with results
if ($action === 'show-weather') {
	$zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING);
	$weatherOut = array();
	$weatherOut = get_weather($zip);
	$recentSearches = get_top_results();
	include 'views/lookup.php';
}
// Display Default Page
else if ($action === 'lookup') {
	include 'views/lookup.php';
}			
?>



