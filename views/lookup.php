<?php include 'header.php'; ?>



<body>
    <div class="container">
        <div class="col-lg mx-auto text-center">
            <h2 id="title">Weather Zip</h2>
            <form class="form-group align-content-center" action="." method="post">

                <input id="input-zip" type="text" name="zip" placeholder="Enter Zip Code Here">

                <div>
                    <input type="hidden" name="action" value="show-weather">
                    <input class="btn btn-dark" type="submit" value="Display Weather" class="btn btn-outline-dark">
                </div>
            </form>

            <?php
            if (!empty($validation_errors)) {
                foreach($validation_errors as $error) {
                    echo '<p class="alert-danger">'. 'Error: ' . $error . '</p>';
                }
            }
            else {
                echo '<h3>Current Weather for ' . $weather['town'] . ', ' . $zip . '</h3>';
                echo '<p>Temperature: ' . $weather['tempf'] . '&#8457;</p>';
                echo '<p>Humidity: ' . $weather['humidity'] . '</p>';
                echo '<p>Wind: ' . $weather['wind'] . '</p>';

            }
            ?>
        </div>
    </div>
</body>

<?php include 'footer.php'; ?>