<?php
// Return an associative array of results from API or an error
function fetch_api ($zip_code, $country) {
    if (strlen($zip_code != 5)) {
        return "Invalid Zip Code";
    } 
    else {
        // Build API url
        $api_key = $_ENV["api_key"];
        $api_url = 'api.openweathermap.org/data/2.5/weather' .
            '?zip=' . $zip_code . ',' .
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

        $output_as_array = json_decode($output, true);
        // 4. Close and free up the curl handle
        curl_close($ch);
    }
}

