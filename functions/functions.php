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
	$states = [
		[99501, 99950, "AK"],
		[35004, 36925, "AL"],
		[71601, 72959, "AR"],
		[85001, 86556, "AZ"],
		[90001, 96162, "CA"],
		[80001, 81658, "CO"],
		[06001, 06389, "CT"],
		[06401, 06928, "CT"],
		[20001, 20039, "DC"],
		[20042, 20599, "DC"],
		[20799, 20799, "DC"],
		[19701, 19980, "DE"],
		[32004, 34997, "FL"],
		[30001, 31999, "GA"],
		[39901, 39901, "GA"],
		[96701, 96898, "HI"],
		[50001, 52809, "IA"],
		[68119, 68120, "IA"],
		[83201, 83867, "ID"],
		[60001, 62999, "IL"],
		[46001, 47997, "IN"],
		[66002, 67594, "KS"],
		[40003, 42788, "KY"],
		[70001, 71232, "LA"],
		[71234, 71497, "LA"],
		[01001, 02791, "MA"],
		[05501, 05544, "MA"],
		[20331, 20331, "MD"],
		[20335, 20797, "MD"],
		[20812, 21930, "MD"],
		[03901, 04992, "ME"],
		[48001, 49971, "MI"],
		[55001, 56763, "MN"],
		[63001, 65899, "MO"],
		[38601, 39776, "MS"],
		[71233, 71233, "MS"],
		[59901, 59937, "MT"],
		[27006, 28909, "NC"],
		[58001, 58856, "ND"],
		[68001, 68118, "NE"],
		[68122, 69367, "NE"],
		[03031, 03897, "NH"],
		[07001, 08989, "NJ"],
		[87001, 88441, "NM"],
		[88901, 89883, "NV"],
		[06390, 06390, "NY"],
		[10001, 14975, "NY"],
		[43001, 45999, "OH"],
		[73001, 73199, "OK"],
		[73401, 74966, "OK"],
		[97001, 97920, "OR"],
		[15001, 19640, "PA"],
		[00600, 00799, "PR"],
		[00900, 00999, "PR"],
		[02801, 02940, "RI"],
		[29001, 29948, "SC"],
		[57001, 57799, "SD"],
		[37010, 38589, "TN"],
		[73301, 73301, "TX"],
		[75001, 75501, "TX"],
		[75503, 79999, "TX"],
		[88510, 88589, "TX"],
		[84001, 84784, "UT"],
		[20040, 20041, "VA"],
		[20040, 20167, "VA"],
		[20042, 20042, "VA"],
		[22001, 24658, "VA"],
		[05001, 05495, "VT"],
		[05601, 05907, "VT"],
		[98001, 99403, "WA"],
		[53001, 54990, "WI"],
		[24701, 26886, "WV"],
		[82001, 83128, "WY"]
	];

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