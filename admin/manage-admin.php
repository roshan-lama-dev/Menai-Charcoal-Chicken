<?php include('partials/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>MANAGE ADMIN</h1>
        <br />
        <br />

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; // Display session message
            unset($_SESSION['add']); // Remove session message
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if (isset($_SESSION['user-not-found'])) {
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }

        if (isset($_SESSION['pwd-not-match'])) {
            echo $_SESSION['pwd-not-match'];
            unset($_SESSION['pwd-not-match']);
        }

        if (isset($_SESSION['change-pwd'])) {
            echo $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']);
        }
        ?>

        <br />
        <br />
        <br />

        <!-- Button to Add Admin -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br />
        <br />
        <br />

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
            // Query to get all admin
            $sql = "SELECT * FROM tbl_admin";

            // Execute query
            $res = mysqli_query($conn, $sql);

            // Check whether the query is executed
            if ($res == TRUE) {
                // Count rows to check whether there is data in dataabase
                $count = mysqli_num_rows($res); // get all rows in database

                $symbol_number = 1; // create a variable for symbol number and assign it

                // check number of rows
                if ($count > 0) {
                    // data is present in database
                    while ($rows = mysqli_fetch_assoc($res)) {
                        // using while loop to get all the data from database
                        // get individual data
                        $id = $rows['id'];
                        $full_name = $rows['full_name'];
                        $username = $rows['username'];

                        // Display the values in webpage
            ?>

                        <tr>
                            <td><?php echo $symbol_number++ ?>.</td>
                            <td><?php echo $full_name ?></td>
                            <td><?php echo $username ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">
                                    Update
                                </a>
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">
                                    Delete
                                </a>
                            </td>
                        </tr>
            <?php
                    }
                } else {
                    // No data present in database
                }
            }
            ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>