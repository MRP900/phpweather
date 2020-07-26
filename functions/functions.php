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
		// [99501, 99950, "AK", "Alaska"],
		// [35004, 36925, "AL", "Alabama"],
		// [71601, 72959, "AR", "Arkansas"],
		// [85001, 86556, "AZ", "Arizona"],
		// [90001, 96162, "CA", "California"],
		// [80001, 81658, "CO", "Colorado"],
		// [06001, 06389, "CT", "Connecticut"],
		// [06401, 06928, "CT", "Connecticut"],
		[20001, 20039, "DC", "District of Columbia"],
		[20042, 20599, "DC", "District of Columbia"],
		[20799, 20799, "DC", "District of Columbia"],
		// [19701, 19980, "DE", "Delaware"],
		// [32004, 34997, "FL", "Florida"],
		// [30001, 31999, "GA", "Georgia"],
		// [39901, 39901, "GA", "Georgia"],
		// [96701, 96898, "HI", "Hawaii"],
		// [50001, 52809, "IA", "Iowa"],
		// [68119, 68120, "IA", "Iowa"],
		// [83201, 83867, "ID", "Idaho"],
		// [60001, 62999, "IL", "Illinois"],
		// [46001, 47997, "IN", "Indiana"],
		// [66002, 67594, "KS", "Kansas"],
		// [40003, 42788, "KY", "Kentucky"],
		// [70001, 71232, "LA", "Louisiana"],
		// [71234, 71497, "LA", "Louisiana"],
		// [01001, 02791, "MA", "Massachusetts"],
		// [05501, 05544, "MA", "Massachusetts"],
		// [20331, 20331, "MD", "Maryland"],
		// [20335, 20797, "MD", "Maryland"],
		// [20812, 21930, "MD", "Maryland"],
		// [03901, 04992, "ME", "Maine"],
		// [48001, 49971, "MI", "Michigan"],
		// [55001, 56763, "MN", "Minnesota"],
		// [63001, 65899, "MO", "Missouri"],
		// [38601, 39776, "MS", "Mississippi"],
		// [71233, 71233, "MS", "Mississipi"],
		// [59901, 59937, "MT", "Montana"],
		// [27006, 28909, "NC", "North Carolina"],
		// [58001, 58856, "ND", "North Dakota"],
		// [68001, 68118, "NE", "Nebraska"],
		// [68122, 69367, "NE", "Nebraska"],
		// [03031, 03897, "NH", "New Hampshire"],
		// [07001, 08989, "NJ", "New Jersey"],
		// [87001, 88441, "NM", "New Mexico"],
		// [88901, 89883, "NV", "Nevada"],
		// [06390, 06390, "NY", "New York"],
		// [10001, 14975, "NY", "New York"],
		// [43001, 45999, "OH", "Ohio"],
		// [73001, 73199, "OK", "Oklahoma"],
		// [73401, 74966, "OK", "Oklahoma"],
		// [97001, 97920, "OR", "Oregon"],
		[15001, 19640, "PA", "Pennsylvania"],
		// [00600, 00799, "PR", "Puerto Rico"],
		// [00900, 00999, "PR", "Puerto Rico"],
		// [02801, 02940, "RI", "Rhodi Island"],
		// [29001, 29948, "SC", "South Carolina"],
		[57001, 57799, "SD", "South Dakota"],
		// [37010, 38589, "TN", "Tennessee"],
		// [73301, 73301, "TX", "Texas"],
		// [75001, 75501, "TX", "Texas"],
		// [75503, 79999, "TX", "Texas"],
		// [88510, 88589, "TX", "Texas"],
		// [84001, 84784, "UT", "Utah"],
		// [20040, 20041, "VA", "Virginia"],
		// [20040, 20167, "VA", "Virginia"],
		// [20042, 20042, "VA", "Virginia"],
		// [22001, 24658, "VA", "Virginia"],
		// [05001, 05495, "VT", "Vermont"],
		// [05601, 05907, "VT", "Vermont"],
		// [98001, 99403, "WA", "Washington"],
		// [53001, 54990, "WI", "Wisconsin"],
		// [24701, 26886, "WV", "West Virginia"],
		[82001, 83128, "WY", "Wyoming"]
	];

	// foreach ($states as list($a, $b, $c, $d)) {
	// 	if (($zip >= $a) && ($zip <= $b)) {
	// 		return $c;
	// 	}
	// }
	// foreach ($states as $state) {
	// 	if (($zip >= $state[0]) && ($zip <= $state[1])) {
	// 		return $state[2];
	// 	}
	// }
	
	
	for ($x = 0; $x <= sizeof($states); $x++) {
		if (($zip >= $states[$x][0]) && ($zip <= $states[$x][1])) {
			return $states[0][2];
		}
	}	
	return "Error: State not found";
}