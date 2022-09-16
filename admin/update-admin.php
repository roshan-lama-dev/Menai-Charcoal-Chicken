<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br>

        <?php
        // Get the ID of selected Admin
        $id = $_GET['id'];

        // SQL Query to get the details
        $sql = "SELECT * FROM tbl_admin WHERE id=$id";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Check if the query is executed
        if ($res == true) {
            // check if the data is available
            $count = mysqli_num_rows($res);
            // check if the admin data is available
            if ($count == 1) {
                // Get the details
                // echo "Admin available";
                $row = mysqli_fetch_assoc($res);

                $full_name = $row['full_name'];
                $username = $row['username'];
            } else {
                // Redirect to manage admin page
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        }
        ?>

        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
// Check if the submit button is clicked
if (isset($_POST['submit'])) {
    // echo "Button Clicked";
    // Get all the value from form to update
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    // Sql query to update admin
    $sql = "UPDATE tbl_admin SET
    full_name = '$full_name',
    username = '$username'
    WHERE id = '$id'
    ";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if ($res == true) {
        // Query Executed and admin updated
        $_SESSION['update'] = "<div class='success'>Admin Updated Successfully.</div>";

        // Redirect to manage admin page
        header('location:' . SITEURL . 'admin/manage-admin.php');
    } else {
        // Failed to update admin
        $_SESSION['update'] = "<div class='error'>Failed to update Admin.</div>";

        // Redirect to manage admin page
        header('location:' . SITEURL . 'admin/manage-admin.php');
    }
}
?>

<?php include('partials/footer.php') ?>