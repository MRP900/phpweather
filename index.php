<?php

// Default location data
if (!isset($zip)) {
$zip = null;
}
// Us as default country
$country = 'us';
// Array to hold errors
$error = null;

//Check for POST
if (!empty($_POST)) {
$_POST = array_map('trim', $_POST);
}

// POST: Sanitize, set action
if (!empty($_POST)) {
	$zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING);

	if ((strlen($zip) < 5)) {
	$error = "Error: Invalid Zip Code";
	} else {
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
		} else {
		$weather = json_decode($output, true);
		// 4. Close and free up the curl handle
		curl_close($ch);

		// Get values from JSON string, convert kelvin to Fahrenheit
		$temp_k = $weather["main"]["temp"];
		$temp_f = round(($temp_k - 273.15) * 9 / 5 + 32, 1);

		// Town
		$town = $weather["name"];
		// Humidity
		$humidity = $weather["main"]["humidity"];
		// Wind
		$wind = $weather["wind"]["speed"];
		}

	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>php weather</title>

	<script>
		window.onload = () => {
			document.getElementById('input-zip').focus().select();
		}
	</script>

	<link rel="stylesheet" href="styles/bootstrap.min.css">
	<link rel="stylesheet" href="styles/styles.css">
</head>

<body>
	<div class="container">
		<div class="col-lg mx-auto text-center">
			<h2 id="title">Weather Lookup</h2>
			<form class="form-group align-content-center" action="." method="post">

				<input id="input-zip" type="text" name="zip" placeholder="Enter a 5 digit Zip Code">

				<div class="form-group">
					<input type="submit" value="Display Weather" class="btn btn-outline-dark">
				</div>
			</form>

			<?php
			if ($error != null) {
				echo '<p class="alert-danger">' . $error . '</p>';
			} elseif (!empty($_POST) && (!empty($zip))) {
				echo '<h3>Current Weather for ' . $town . ', ' . $zip . '</h3>';
				
				echo '<p>Temperature: ' . $temp_f . '&#8457;</p>';
				echo '<p>Humidity: ' . $humidity . '</p>';
				echo '<p>Wind: ' . $wind . '</p>';

				// Debugging
				// echo '<p>' . $output . '</p>';
			}
			?>
		</div>
	</div>
</body>

</html>