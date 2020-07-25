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
	
	

function debug_to_console ($data) {
	$output = $data;
	if (is_array($output))
		$output = implode(',', $output);
	echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

  
function get_state($zCode) {
	$states = array(
		array(99501, 99950, "AK", "Alaska"),
		array(35004, 36925, "AL", "Alabama"),
		array(71601, 72959, "AR", "Arkansas"),
		array(85001, 86556, "AZ", "Arizona"),
		array(90001, 96162, "CA", "California"),
		array(80001, 81658, "CO", "Colorado"),
		array(06001, 06389, "CT", "Connecticut"),
		array(06401, 06928, "CT", "Connecticut"),
		array(20001, 20039, "DC", "District of Columbia"),
		array(20042, 20599, "DC", "District of Columbia"),
		array(20799, 20799, "DC", "District of Columbia"),
		array(19701, 19980, "DE", "Delaware"),
		array(32004, 34997, "FL", "Florida"),
		array(30001, 31999, "GA", "Georgia"),
		array(39901, 39901, "GA", "Georgia"),
		array(96701, 96898, "HI", "Hawaii"),
		array(50001, 52809, "IA", "Iowa"),
		array(68119, 68120, "IA", "Iowa"),
		array(83201, 83867, "ID", "Idaho"),
		array(60001, 62999, "IL", "Illinois"),
		array(46001, 47997, "IN", "Indiana"),
		array(66002, 67594, "KS", "Kansas"),
		array(40003, 42788, "KY", "Kentucky"),
		array(70001, 71232, "LA", "Louisiana"),
		array(71234, 71497, "LA", "Louisiana"),
		array(01001, 02791, "MA", "Massachusetts"),
		array(05501, 05544, "MA", "Massachusetts"),
		array(20331, 20331, "MD", "Maryland"),
		array(20335, 20797, "MD", "Maryland"),
		array(20812, 21930, "MD", "Maryland"),
		array(03901, 04992, "ME", "Maine"),
		array(48001, 49971, "MI", "Michigan"),
		array(55001, 56763, "MN", "Minnesota"),
		array(63001, 65899, "MO", "Missouri"),
		array(388601, 39776, "MS", "Mississippi"),
		array(71233, 71233, "MS", "Mississipi"),
		array(59901, 59937, "MT", "Montana"),
		array(27006, 28909, "NC", "North Carolina"),
		array(58001, 58856, "ND", "North Dakota"),
		array(68001, 68118, "NE", "Nebraska"),
		array(68122, 69367, "NE", "Nebraska"),
		array(03031, 03897, "NH", "New Hampshire"),
		array(07001, 08989, "NJ", "New Jersey"),
		array(87001, 88441, "NM", "New Mexico"),
		array(88901, 89883, "NV", "Nevada"),
		array(06390, 06390, "NY", "New York"),
		array(10001, 14975, "NY", "New York"),
		array(43001, 45999, "OH", "Ohio"),
		array(73001, 73199, "OK", "Oklahoma"),
		array(73401, 74966, "OK", "Oklahoma"),
		array(97001, 97920, "OR", "Oregon"),
		array(15001, 19640, "PA", "Pennsylvania"),
		array(00600, 00799, "PR", "Puerto Rico"),
		array(00900, 00999, "PR", "Puerto Rico"),
		array(02801, 02940, "RI", "Rhodi Island"),
		array(29001, 29948, "SC", "South Carolina"),
		array(57001, 57799, "SD", "South Dakota"),
		array(37010, 38589, "TN", "Tennessee"),
		array(73301, 73301, "TX", "Texas"),
		array(75001, 75501, "TX", "Texas"),
		array(75503, 79999, "TX", "Texas"),
		array(88510, 88589, "TX", "Texas"),
		array(84001, 84784, "UT", "Utah"),
		array(20040, 20041, "VA", "Virginia"),
		array(20040, 20167, "VA", "Virginia"),
		array(20042, 20042, "VA", "Virginia"),
		array(22001, 24658, "VA", "Virginia"),
		array(05001, 05495, "VT", "Vermont"),
		array(05601, 05907, "VT", "Vermont"),
		array(98001, 99403, "WA", "Washington"),
		array(53001, 54990, "WI", "Wisconsin"),
		array(24701, 26886, "WV", "West Virginia"),
		array(82001, 83128, "WY", "Wyoming")
		// array(, , "", ""),
		
	);


	if (validate_zip_code($zCode) === true) {
		$zCode = intval($zCode);

		foreach ($states as $state) {
			$minZip = $state[0];
			$maxZip = $state[1];
			$stateAbbreviation = $state[2];
			//$stateFullName = $state[3];
			
			if ($zCode >= $minZip && $zCode <= $maxZip) {
				return $stateAbbreviation;
			}
		}
	}
	return "Invalid Zip Code";
}


function validate_zip_code($zipCode)
{
	if (preg_match('/^\d{5}$/', $zipCode)) {
		return true;
	} else {
		return false;
	}
}