<?php

function get_weather ($zip) {
	// Array of weather attributes
	$weather = array();

	// Us as default country
	$country = 'us';
	
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

	if (curl_errno($ch)) {
	$error = 'Request Error: ' . curl_error($ch);
	return $error;
	} 
	else {
	$weather = json_decode($output, true);
	// 4. Close and free up the curl handle
	curl_close($ch);

	// Get values from JSON string, convert kelvin to Fahrenheit
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

	return $weather;
	}
}
