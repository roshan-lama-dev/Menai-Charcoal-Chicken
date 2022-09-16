<?php
// Start session
session_start();

// Create Constants to store non repeating values
define('SITEURL', 'http://localhost:81/chicken-shop/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'chicken-shop');

// Execute Query and save data in database
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD); // Database connection
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
