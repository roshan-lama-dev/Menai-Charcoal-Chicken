<?php
// Authorization-access control
// Check if the user is logged in
if (!isset($_SESSION['user'])) // If user session is not set
{
    // User is not logged it
    // redirect to login page with message
    $_SESSION['no-login-message'] = "<div class='error text-center' > Please login to access Admin Panel. </div>";

    // Redirect to login page
    header('location:' . SITEURL . 'admin/login.php');
}
