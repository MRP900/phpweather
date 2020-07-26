<?php

function get_weather ($zip) {
	// $error = null;
	// Array of weather attributes
	$weather = array();
	// Us as default country
	$country = 'us';
	// Validate Zip Code
	
	// Build API url
	$api_key = $_ENV["api_key"];
	$api_url = 'api.openweathermap.org/data/2.5/weather' .
		'?zip=' . $zip . ',' .
		$country . '&appid=' . $api_key;

	// Initialize cURL
	$ch = curl_init();

	// Set Options
	// URL Request
	curl_setopt($ch, CURLOPT_URL, $api_url);

	// Return instead of outputting directly
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// Whether to include the header in the output. Set to false here
	curl_setopt($ch, CURLOPT_HEADER, 0);

	// 3 Execute the request and fetch the response, check for errors
	$output = curl_exec($ch);

	// if (curl_errno($ch)) {
	// $error = 'Request Error: ' . curl_error($ch);
	// return $error;
	// } 
	// else {
	$weather = json_decode($output, true);
	// 4. Close and free up the curl handle
	curl_close($ch);

	// Get values from JSON string
	// Convert kelvin to Fahrenheit
	$temp_k = $weather["main"]["temp"];
	$temp_f = round(($temp_k - 273.15) * 9 / 5 + 32, 1);
	$weather['tempf'] = $temp_f;
	// Town
	$town = $weather["name"];
	$weather['town'] = $town;
	// Humidity
	$humidity = $weather["main"]["humidity"];
	$weather['humidity'] = $humidity;
	// Wind
	$wind = $weather["wind"]["speed"];
	$weather['wind'] = $wind;

	debug_to_console($weather);
	debug_to_console($output);
	
	return $weather;
}

function validate_zip_code($zipCode)
{
	if (preg_match('/^\d{5}$/', $zipCode)) {
		return true;
	} else {
		return false;
	}
}	

function debug_to_console ($data) {
	$output = $data;
	if (is_array($output))
		$output = implode(',', $output);
	echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

  
function get_state($zip) {
	require 'arrays.php';

	foreach ($states as list($a, $b, $c)) {
		if (($zip >= $a) && ($zip <= $b)) {
			return $c;
		}
	}
	// foreach ($states as $state) {
	// 	if (($zip >= $state[0]) && ($zip <= $state[1])) {
	// 		return $state[2];
	// 	}
	// }
	
	
	// for ($x = 0; $x <= sizeof($states); $x++) {
	// 	if (($zip >= $states[$x][0]) && ($zip <= $states[$x][1])) {
	// 		return $states[0][2];
	// 	}
	// }	
	return "Error: State not found";
}