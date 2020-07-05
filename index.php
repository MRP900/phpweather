<?php
        $zip = 57783;
        $country = 'us';


        $api_key = '078f24647204e62bf274992bc5bf8e43';

        $api_url = 'api.openweathermap.org/data/2.5/weather' .
                '?zip=' . $zip . ',' .
                $country . '&appid=' . $api_key;

        $json = file_get_contents($api_url);

        $weather_array = json_decode($json, true);

        $temp = $weather_array["main"];

        $success = "Empty";
        if (!empty($weather_array)) {
            $success = "Not Empty";
        }

                // api.openweathermap.org/data/2.5/weather?zip=57783,us&appid=078f24647204e62bf274992bc5bf8e43
                // api.openweathermap.org/data/2.5/weather?zip={zip code},{country code}&appid={your api key}

                // $ch = curl_init('http://api.bitly.com/v3/shorten?login=user&apiKey=key&longUrl=url');
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // $result = curl_exec($ch);

        // // create & initialize a curl session
        // $curl = curl_init();

        // // set our url with curl_setopt()
        // curl_setopt($curl, CURLOPT_URL, "api.example.com");

        // // return the transfer as a string, also with setopt()
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // // curl_exec() executes the started curl session
        // // $output contains the output string
        // $output = curl_exec($curl);

        // // close curl resource to free up system resources
        // // (deletes the variable made by curl_init)
        // curl_close($curl);

// function callAPI($method, $url, $data)
// {
//     $curl = curl_init();
//     switch ($method) {
//         case "POST":
//             curl_setopt($curl, CURLOPT_POST, 1);
//             if ($data)
//                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//             break;
//         case "PUT":
//             curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
//             if ($data)
//                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//             break;
//         default:
//             if ($data)
//                 $url = sprintf("%s?%s", $url, http_build_query($data));
//     }
//     // OPTIONS:
//     curl_setopt($curl, CURLOPT_URL, $url);
//     curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//         'APIKEY: 111111111111111111111',
//         'Content-Type: application/json',
//     ));
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//     // EXECUTE:
//     $result = curl_exec($curl);
//     if (!$result) {
//         die("Connection Failure");
//     }
//     curl_close($curl);
//     return $result;
// }
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
    <p>Temperature: <?php echo $weather_array; ?></p>
    <p>URL: <?php echo $api_url; ?></p>
    <p>JSON: <?php echo $json; ?></p>
    <p>Success: <?php echo $success; ?></p>
</body>
</html>