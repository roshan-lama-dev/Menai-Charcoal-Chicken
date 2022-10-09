<?php
// Start session
session_start();

// Create Constants to store non repeating values
define('SITEURL', 'menaicharcoal.42web.io');
define('LOCALHOST', 'sql305.epizy.com');
define('DB_USERNAME', 'epiz_32749741');
define('DB_PASSWORD', 'cO492LYo6Y4S');
define('DB_NAME', 'epiz_32749741_chicken_shop');

// Execute Query and save data in database
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD); // Database connection
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
    