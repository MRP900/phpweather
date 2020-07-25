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
	// debug_to_console($weather);
	// debug_to_console($weather);

	return $weather;
}
	
	// // Build API url
	// $api_key = $_ENV["api_key"];
	// $api_url = 'api.openweathermap.org/data/2.5/weather' .
	// '?zip=' . $zip . ',' .
	// $country . '&appid=' . $api_key;

	// // Initialize cURL
	// $ch = curl_init();

	// // Set Options
	// // URL Request
	// curl_setopt($ch, CURLOPT_URL, $api_url);

	// // Return instead of outputting directly
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// // Whether to include the header in the output. Set to false here
	// curl_setopt($ch, CURLOPT_HEADER, 0);

	// // 3 Execute the request and fetch the response, check for errors
	// $output = curl_exec($ch);

	// // if (curl_errno($ch)) {
	// // $error = 'Request Error: ' . curl_error($ch);
	// // return $error;
	// // } 
	// // else {
	// $weather = json_decode($output, true);
	// // 4. Close and free up the curl handle
	// curl_close($ch);

	// // Get values from JSON string, convert kelvin to Fahrenheit
	// $temp_k = $weather["main"]["temp"];
	// $temp_f = round(($temp_k - 273.15) * 9 / 5 + 32, 1);
	// $weather['tempf'] = $temp_f;
	// // Town
	// $town = $weather["name"];
	// $weather['town'] = $town; 
	// // Humidity
	// $humidity = $weather["main"]["humidity"];
	// $weather['humidity'] = $humidity;
	// // Wind
	// $wind = $weather["wind"]["speed"];
	// $weather['wind'] = $wind;
	
	// // debug_to_console($weather);
	
	// return $weather;
	// }


function debug_to_console ($data) {
	$output = $data;
	if (is_array($output))
		$output = implode(',', $output);

	echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

// Test validity of zip: length, characters
// function valid_zip($zip) {
// 	$zip_errors = array();

	
// 	if (!preg_match('\d{5}', $zip)) {
// 		array_push($zip_errors, "Error: Zip Code must be five numbers.");
// 	}
// 	// Return error array
// 	if (!empty($zip_errors)) {
// 		return $zip_errors;
// 	}
// 	else {
// 		return 'valid';
// 	}
// }


