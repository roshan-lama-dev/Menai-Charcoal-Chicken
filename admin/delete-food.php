<?php
// Include constants file
include('../config/constants.php');

// echo "Delete page";
// Check if the id annd image_name value is set
if (isset($_GET['id']) and isset($_GET['image_name'])) {
    // Get the value and delete
    // echo "Get value and delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // Remove the physical image file if available
    if ($image_name != "") {
        // Image is availabe, so remove it
        $path = "../images/food/" . $image_name;

        // Remove the image
        $remove = unlink($path);

        // If failed to remove image then add an error message and stop the process
        if ($remove == false) {
            $_SESSION['remove'] = "<div class='error'>Failed to remove food image.</div>";

            // Redirect to manage food page
            header('location:' . SITEURL . 'admin/manage-food.php');

            // Stop the process
            die();
        }
    }

    // Delete from database
    // Sql query to delete data from database
    $sql = "DELETE FROM tbl_food WHERE id=$id";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check if the data is deleted from database
    if ($res == true) {
        $_SESSION['delete'] = "<div class='success'> Food deleted successfully. </div>";

        // redirect to manage food
        header('location:' . SITEURL . 'admin/manage-food.php');
    } else {
        $_SESSION['delete'] = "<div class='success'> Failed to delete food. </div>";

        // redirect to manage food
        header('location:' . SITEURL . 'admin/manage-food.php');
    }
} else {
    // redire to manage food page with a message
    header('location:' . SITEURL . 'admin/manage-food.php');
}
