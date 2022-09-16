<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br />

        <?php
        if (isset($_SESSION['add'])) { // check whether the session is set 
            echo $_SESSION['add']; // Display session message if set
            unset($_SESSION['add']); // Remove session message
        }
        ?>

        <form action="" method="post">

            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Name">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Enter username">
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php') ?>

<?php
//  Process the value from form and save it in database
// Check whether the button is clicked or not

if (isset($_POST['submit'])) {
    // Button Clicked
    // echo "Button Clicked";

    // Get the data from form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Password encryption with MD5

    // SQL Query to save the data into database
    $sql = "INSERT INTO tbl_admin SET
        full_name='$full_name',
        username='$username',
        password='$password'
    ";


    //  Executig query ad savig data into database
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    // check whether the (query is executed) data is inserted or not and display appropriate message
    if ($res == TRUE) {
        // Data inserted
        // echo "Data inserted";
        // Create a session variable to display message
        $_SESSION['add'] = "<div class='success'>Admin added successfully</div>";

        // Redirect page
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        // Failed to insert
        // echo "Failed to insert data";
        // Create a session variable to display message
        $_SESSION['add'] = "<div class='error'>Failed to add admin</div>";

        // Redirect page
        header("location:" . SITEURL . 'admin/manage-admin.php');
    }
}
?>