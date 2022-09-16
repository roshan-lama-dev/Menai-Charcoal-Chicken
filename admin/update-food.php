<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
ob_start();
?>

<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <?php
        if (isset($_GET['id'])) {
            // echo "Getting The Data";
            $id = $_GET['id'];

            // Sql query to get all details
            $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

            // Execute the query
            $res2 = mysqli_query($conn, $sql2);

            // Count the row to check whether the id is valid or not
            $count2 = mysqli_num_rows($res2);

            if ($count2 == 1) {
                // Get all the data
                $row2 = mysqli_fetch_assoc($res2);
                $title = $row2['title'];
                $description = $row2['description'];
                $price = $row2['price'];
                $current_image = $row2['image_name'];
                $current_category = $row2['category_id'];
                $featured = $row2['featured'];
                $active = $row2['active'];
            } else {
                // Redirect to manage food with session message
                $_SESSION['no-food-found'] = "<div class='error'>Food not found. </div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            }
        } else {
            header('location:' . SITEURL . 'admin/manage-food.php');
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
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            // Display image
                        ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" alt="" width="150px">
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
                                    $category_id = $row['id'];
                                    $category_title = $row['title'];

                            ?>

                                    <option <?php if ($current_category == $category_id) {
                                                echo 'selected';
                                            } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

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
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            // echo "Clicked";
            // Get all the values from form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            // Updating new image if selected
            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];

                if ($image_name != "") {
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

                            // Redirect to add food page
                            header('location:' . SITEURL . 'admin/manage-food.php');

                            // Stop the process
                            die();
                        }

                        // Remove image
                        if ($current_image != "") {
                            $remove_path = "../images/food/" . $current_image;
                            $remove = unlink($remove_path);

                            if ($remove == false) {
                                $_SESSION['failed-remove'] = "<div class='error'> Failed to remove current image. </div>";
                                header('location:' . SITEURL . 'admin/manage-food.php');
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
            $sql3 = "UPDATE tbl_food SET
        title = '$title',
        description='$description',
        price=$price,
        image_name = '$image_name',
        category_id=$category,
        featured = '$featured',
        active='$active'
        WHERE id = $id
    ";

            // Execute the query
            $res3 = mysqli_query($conn, $sql3);

            // Redirect to manage food with message
            // check if executed or nont
            if ($res3 == true) {
                // food updated
                $_SESSION['update'] = "<div class='success'> Food Updated Successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            } else {
                // fail to update food
                $_SESSION['update'] = "<div class='error'> Failed to update food. </div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            }
        }
        ?>
    </div>
</div>
<?php include('partials/footer.php'); ?>