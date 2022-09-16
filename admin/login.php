<?php include('../config/constants.php') ?>

<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br>
        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>
        <br>

        <!-- Login form starts here -->
        <form action="" method="POST" class="text-center">
            Username:
            <br>
            <input type="text" name="username" placeholder="Enter Username">
            <br>
            <br>
            Password:
            <br>
            <input type="password" name="password" placeholder="Enter Password">
            <br>
            <br>
            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br>
            <br>
        </form>

        <!-- Login form ends here -->
    </div>
</body>

</html>

<?php
// check whether the submit button is clicked
if (isset($_POST['submit'])) {
    // Process for login
    // get the data from login form
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Check if the user with username of password exist or not
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Count rows to check whether the user exists
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        // User available and login success
        $_SESSION['login'] = "<div class='success text-center'>Login Successful.</div>";
        $_SESSION['user'] = $username; // To check if the user is logged it and logout will unset it

        // Redirectt to homepage/dashboard
        header('location:' . SITEURL . 'admin/');
    } else {
        // User not available and login fail
        $_SESSION['login'] = "<div class='error text-center'>Username or password did not match.</div>";

        // Redirectt to homepage/dashboard
        header('location:' . SITEURL . 'admin/login.php');
    }
}
?>