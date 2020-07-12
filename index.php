<?php
// Default location data
if (!isset($zip)) {$zip = "";} 
$country = 'us';

// Check for POST
if (!empty($_POST)) {
    $_POST = array_map('trim', $_POST);
}

// POST: Sanitize, set action
if (isset($_POST)) {
    $zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING);
} 


// Build API url
$api = $_ENV["api_key"];
$api_url = 'api.openweathermap.org/data/2.5/weather' .
		   '?zip=' . $zip . ',' .
		    $country . '&appid=' . $api;

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

$weather = json_decode($output, true);
// 4. Close and free up the curl handle
curl_close($ch);

// Get values from JSON string, convert kelvin to Fahrenheit
$temp_k = $weather["main"]["temp"];
$temp_f = round(($temp_k - 273.15) * 9 / 5 + 32, 1);


?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>php weather</title>
	<link rel="stylesheet" href="styles/bootstrap.min.css">
	<link rel="stylesheet" href="styles/styles.css">
</head>

<body>

	<form action="." method="post">
		<label>Enter Zip Code:</label>
		<input type="text" name="zip">

		<div class="form-group">
			<!-- <input type="hidden" name="action" value="display-weather"> -->
			<input type="submit" value="Display Weather" class="btn btn-outline-dark">
		</div>
	</form>

	<div id="output-div">
		<?php if (isset($_POST)) { ?>
		<h3>Displaying weather for Zip Code: <?php echo $zip ?></h3>
		<p>Temperature: <?php echo $temp_f; ?> &#8457;</p>
		<p><?php echo $output; ?></p>
		<?php } ?>
	</div>

</body>

</html>