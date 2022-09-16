<?php

//  Include constants.php for siteurl
include('../config/constants.php');

// Destroy the session
session_destroy(); // unsets $_SESSION['user']

// Redirect to login page
header('location:' . SITEURL . 'admin/login.php');
