<?php

// Include constants.php file
include('../config/constants.php');

// get id of admin to be deleted
$id = $_GET['id'];

// SQL query to delete admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

// Execute the query
$res = mysqli_query($conn, $sql);

// Check whether the query is executed successfully
if ($res == TRUE) {
    // Query Executed successfully
    // echo "Admin Deleted";
    // Create session variable to display message
    $_SESSION['delete'] = "<div class='success'>Admin deleted successfully.</div>";

    // Redirect to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
} else {
    // Failed to delete admin
    // echo "Failed to delete Admin.";
    // Create session variable to display message

    $_SESSION['delete'] = "<div class='error'>Failed to delete Admin.</div>";

    // Redirect to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');

}

// Redirect to manage admin page with message
