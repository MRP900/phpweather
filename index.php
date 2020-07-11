<?php
        $zip = 57783;
        $country = 'us';


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
        $temp = $weather["weather"];

                
                // api.openweathermap.org/data/2.5/weather?zip={zip code},{country code}&appid={your api key}

               

        
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php weather</title>
</head>
<body>
    <p>Zip Code: <?php echo $zip; ?></p>
    <p>Temperature: <?php echo $temp; ?></p>
    <p>Temperature: <?php print_r($temp); ?></p>
    <!-- <p>URL: <?php echo $api_url; ?></p> -->
    <p><?php echo $output; ?></p>
    
</body>
</html>