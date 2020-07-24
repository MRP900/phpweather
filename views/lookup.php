<?php include 'header.php'; ?>

<body>
    <div class="container">
        <div class="col-lg mx-auto text-center">
            <h2 id="title">Weather Zip</h2>
            <form class="form-group align-content-center" action="." method="post">

                <input id="input-zip" type="text" name="zip" placeholder="Enter Zip Code">

                <div class="form-group">
                    <input type="hidden" name="action" value="show-weather">
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

<?php include 'footer.php'; ?>