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

            <div><h2>Recent</h2></div>
            <ul id="recent">
                <?php foreach ($recentSearches as $recent) : ?> 
                    <li>
                        <form action="." method="post">
                            <input type="hidden" name="action" value="show-weather">
                            <input id="input-zip" type="hidden" name="zip" value="<?php echo $recent["zip"]; ?>"> 
                            <input class="btn btn-dark" class="btn btn-outline-dark" id="input-zip" type="submit" value="<?php echo $recent["city"] . " " . $recent["state"] . ", " . $recent["zip"]; ?>">     
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            
            <?php
            if (!empty($error)) {
                echo '<p class="alert-danger">' . $error . '</p>';
            } 
            elseif (!empty($weather)) {
                echo '<h3>Current Weather for ' . $weather['town'] . ', '. $state . ' ' . $zip . '</h3>';
                echo '<p>Temperature: ' . $weather['tempf'] . '&#8457;</p>';
                echo '<p>Humidity: ' . $weather['humidity'] . '</p>';
                echo '<p>Wind: ' . $weather['wind'] . '</p>';
            }
            ?>
        </div>
    </div>
</body>

<?php include 'footer.php'; ?>