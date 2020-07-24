<?php
include 'Models/functions.php';


//Check for POST
if (!empty($_POST)) {
$_POST = array_map('trim', $_POST);
}

			// // POST: Sanitize, set action
			// if (isset($_POST['action'])) {
			// 	$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
			// } else if (isset($_GET['action'])) {
			// 	$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
			// } else {
			// 	$action = 'list-pets';
			// }

// Default location data
if (!isset($zip)) {
	$zip = null;
}

// POST: Sanitize, set action
if (!empty($_POST)) {
	$zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING);

	get_weather($zip);
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
			<h2 id="title">Weather Zip</h2>
			<form class="form-group align-content-center" action="." method="post">

				<input id="input-zip" type="text" name="zip" placeholder="Enter Zip Code">

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
				echo '<p>' . $output . '</p>';
			}
			?>
		</div>
	</div>
</body>

