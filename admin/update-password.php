<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        ?>

        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Current Password:</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
//  Check if the submit button is clicked
if (isset($_POST['submit'])) {
    // echo "clicked";
    // get the data from the form
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    // check if the user current ID and current password exist
    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        // Check if the data is available
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            // user exists and password can be changed
            // echo "User Found";
            // Check whether the new password and confirm password match
            if ($new_password == $confirm_password) {
                // Update Password
                $sql2 = "UPDATE tbl_admin SET
                password='$new_password'
                WHERE id = '$id'
                ";

                // Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                // Check whether the query is executed or not
                if ($res2 == true) {
                    // Display success message
                    $_SESSION['change-pwd'] = "<div class='success'>Password changed successfully.</div>";

                    // Redirect the User
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                } else {
                    // display error message
                    $_SESSION['change-pwd'] = "<div class='error'>Failed to change password.</div>";

                    // Redirect the User
                    header('location:' . SITEURL . 'admin/manage-admin.php');

                }
            } else {
                // Redirect to manage admin page with error message
                // User does not exist set message and redirect
                $_SESSION['pwd-not-match'] = "<div class='error'>Password does not match.</div>";

                // Redirect the User
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        } else {
            // User does not exist set message and redirect
            $_SESSION['user-not-found'] = "<div class='error'>User Not Found.</div>";

            // Redirect the User
            header('location:' . SITEURL . 'admin/manage-admin.php');
        }
    }
    // check if the new password matches with the confirm password_get_info
    // change password if all above is true
}
?>

<?php include('partials/footer.php'); ?>