<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>
        <br><br>

        <!-- Add Food form starts -->
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Food Title">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Food Description"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" placeholder="Food Price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            // PHP code to display categories from database
                            $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";

                            $res = mysqli_query($conn, $sql);

                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $id = $row['id'];
                                    $title = $row['title'];

                            ?>

                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                <?php
                                }
                            } else {
                                ?>
                                <option value="0">No Category Found</option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
        <!-- Add Food form ends -->
    </div>
</div>
<?php include('partials/footer.php'); ?>

<?php
// Check if the submit button is clicked
if (isset($_POST['submit'])) {
    // echo "Clicked";

    // get the value from the form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    // echo $title;

    // For radio input type, we need to check if a button is selected
    if (isset($_POST['featured'])) {
        // get the value from the form
        $featured = $_POST['featured'];
    } else {
        // set a default value
        $featured = "No";
    }
    // echo $featured;

    if (isset($_POST['active'])) {
        // get the value from the form
        $active = $_POST['active'];
    } else {
        // set a default value
        $active = "No";
    }
    // echo $active;

    // Check whether the image is selected and set value for image name accordingly
    // print_r($_FILES['image']);
    // die();

    if (isset($_FILES['image']['name'])) {
        // Upload the image
        // to upload image we need image name, source path and destination path
        $image_name = $_FILES['image']['name'];
        // echo $image_name;

        // Upload image only if image is selected
        if ($image_name != "") {

            // Auto rename our image
            // Get the extension of the image
            $ext = end(explode('.', $image_name));

            // rename the image
            $image_name = "Food-Name-" . rand(0000, 9999) . '.' . $ext;

            $source_path = $_FILES['image']['tmp_name'];
            // echo $source_path;
            $destination_path = "../images/food/" . $image_name;
            // echo $destination_path;

            // Finally upload the image
            $upload = move_uploaded_file($source_path, $destination_path);

            // Check if the image is uploaded
            // if the image is not uploaded stop the process and redirect
            if ($upload == false) {
                // set message
                $_SESSION['upload'] = "<div class='error'> Failed to upload image " . $_FILES['image']['tmp_name'] . "</div>";

                // Redirect to add Food page
                header('location:' . SITEURL . 'admin/add-food.php');

                // Stop the process
                die();
            }
        }
    } else {
        // Don't upload the image and set the image_name value as blank
        $image_name = "";
    }

    // Create Sql query to insert the Food into database
    $sql2 = "INSERT INTO tbl_food SET
        title='$title',
        description='$description',
        price=$price,
        image_name='$image_name',
        category_id=$category,
        featured='$featured',
        active='$active'
    ";

    // Execute the query and save to database
    $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));


    // Check if the query is executed and data is added
    if ($res2 == TRUE) {
        // Query executed and Food added
        $_SESSION['add'] = "<div class='success'>Food added successfully.</div>";
        // Redirect to manage Food page
        header('location:' . SITEURL . 'admin/manage-food.php');
    } else {
        // failed to add Food
        $_SESSION['add'] = "<div class='error'>Failed to add food.</div>";
        // Redirect to manage Food page
        header('location:' . SITEURL . 'admin/add-food.php');
    }
}

?>