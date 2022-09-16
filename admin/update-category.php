<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
        if (isset($_GET['id'])) {
            // echo "Getting The Data";
            $id = $_GET['id'];

            // Sql query to get all details
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Count the row to check whether the id is valid or not
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                // Get all the data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                // Redirect to manage category with session message
                $_SESSION['no-category-found'] = "<div class='error'>Category not found. </div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        } else {
            header('location:' . SITEURL . 'admin/manage-category.php');
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            // Display image
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" alt="" width="150px">
                        <?php
                        } else {
                            // Display message
                            echo "<div class = 'error'> Image not added. </div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include('partials/footer.php'); ?>

<?php
if (isset($_POST['submit'])) {
    // echo "Clicked";
    // Get all the values from form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    // Updating new image if selecting
    if (isset($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];

        if ($image_name != "") {
            if ($image_name != "") {
                // Auto rename our image
                // Get the extension of the image
                $ext = end(explode('.', $image_name));

                // rename the image
                $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;

                $source_path = $_FILES['image']['tmp_name'];
                // echo $source_path;
                $destination_path = "../images/category/" . $image_name;
                // echo $destination_path;

                // Finally upload the image
                $upload = move_uploaded_file($source_path, $destination_path);

                // Check if the image is uploaded
                // if the image is not uploaded stop the process and redirect
                if ($upload == false) {
                    // set message
                    $_SESSION['upload'] = "<div class='error'> Failed to upload image " . $_FILES['image']['tmp_name'] . "</div>";

                    // Redirect to add category page
                    header('location:' . SITEURL . 'admin/manage-category.php');

                    // Stop the process
                    die();
                }

                if ($current_image != "") {
                    $remove_path = "../images/category/" . $current_image;
                    $remove = unlink($remove_path);

                    if ($remove == false) {
                        $_SESSION['failed-remove'] = "<div class='error'> Failed to remove current image. </div>";
                        header('location:' . SITEURL . 'admin/manage-category.php');
                        die();
                    }
                }
            }
        } else {
            $image_name = $current_image;
        }
    } else {
        $image_name = $current_image;
    }
    // Update the database
    $sql2 = "UPDATE tbl_category SET
        title = '$title',
        image_name = '$image_name',
        featured = '$featured',
        active='$active'
        WHERE id = $id
    ";

    // Execute the query
    $res2 = mysqli_query($conn, $sql2);

    // Redirect to manage category with message
    // check if executed or nont
    if ($res2 == true) {
        // category updated
        $_SESSION['update'] = "<div class='success'> Category Updated Successfully.</div>";
        header('location:' . SITEURL . 'admin/manage-category.php');
    } else {
        // fail to update category
        $_SESSION['update'] = "<div class='error'> Failed to update category. </div>";
        header('location:' . SITEURL . 'admin/manage-category.php');
    }
}
?>