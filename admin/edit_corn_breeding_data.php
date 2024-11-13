<?php
include "../inc/script_header.php";
include 'functions.php';

// Get user ID from the URL
$userId = $_GET['id'] ?? null;

if (!$userId) {
  die("User ID is required.");
}

// Get columns for the users table
$columns = getUserColumns($conn);

// Fetch the user data to populate the form
$sql = "SELECT t.*, 
           GROUP_CONCAT(ti.image_path SEPARATOR ',') AS image_paths 
           FROM tbl_corn_breeding_data t 
           LEFT JOIN tbl_corn_breeding_data_images ti ON t.cbd_id = ti.cbd_id 
           WHERE t.cbd_id = ? 
           GROUP BY t.cbd_id";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
  die("User not found.");
}

$user = $result->fetch_assoc();
$stmt->close();
$imagePaths = !empty($user['image_paths']) ? explode(',', $user['image_paths']) : [];


// Fetch options for the corn_varieties dropdown
$roles = [];
$sql = "SELECT id, corn_varieties_name FROM tbl_corn_varieties";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $roles[] = $row;
  }
}

// Handle the form submission for updating user data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $userId = $_POST['users_id'];

  // Prepare the fields to update
  $data = [];
  $setFields = [];

  foreach ($columns as $column) {
    // Only include non-empty fields that are not the users_id
    if (isset($_POST[$column]) && $_POST[$column] !== '' && $column !== 'users_id') {

      $data[] = $_POST[$column];
      $setFields[] = "$column = ?";
    }
  }

  // If no data to update, show an error
  if (empty($data)) {
    echo "No data to update.";
    exit;
  }

  // Handle deleted images
  if (!empty($_POST['delete_images'])) {
    foreach ($_POST['delete_images'] as $deleted_image) {
      // Validate and delete image file
      if (!empty($deleted_image) && file_exists($deleted_image)) {
        unlink($deleted_image);

        // Remove from database record
        $existing_images_array = !empty($prev_issue_images) ? array_map('trim', explode(', ', $prev_issue_images)) : [];
        $existing_images_array = array_diff($existing_images_array, [$deleted_image]);
        $prev_issue_images = implode(', ', $existing_images_array);

        // Delete from tbl_corn_breeding_data_images
        $delete_image_query = "DELETE FROM tbl_corn_breeding_data_images WHERE image_path = '$deleted_image'";
        if ($conn->query($delete_image_query) == true) {
          echo "Image deleted successfully";
        } else {
          echo "Error preparing delete statement: " . $conn->error;
        }
      }
    }
  }
  $new_dir = "../uploads/$userId/";
  // Handle file uploads for images
  $uploaded_images = [];
  if (!empty($_FILES['images']['name'][0])) {
    // Create the new directory if it doesn't exist
    if (!is_dir($new_dir)) mkdir($new_dir, 0777, true);

    foreach ($_FILES['images']['name'] as $key => $image) {
      $image_extension = pathinfo($image, PATHINFO_EXTENSION);
      $unique_name = uniqid() . '.' . $image_extension;
      $target_file = $new_dir . $unique_name;

      if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $target_file)) {
        $uploaded_images[] = $target_file;

        // Insert image path into the database
        $stmt_media = $conn->prepare("INSERT INTO tbl_corn_breeding_data_images (cbd_id, image_path) VALUES (?, ?)");
        $stmt_media->bind_param("is", $userId, $target_file);
        if ($stmt_media->execute()) {
          echo "Image added successfully";
        } else {
          echo "Error adding image: " . $stmt_media->error;
        }
        $stmt_media->close();
      } else {
        $_SESSION['error_message_cbd'] = "Error uploading image: " . $image;
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
      }
    }
  }


  // Build the SQL query with placeholders
  $setFieldsStr = implode(", ", $setFields);
  $sql = "UPDATE tbl_corn_breeding_data SET $setFieldsStr WHERE cbd_id = ?";

  // Prepare the statement for execution
  $stmt = $conn->prepare($sql);

  // Create bind_param string (e.g., "sssi" for 3 string fields and 1 integer)
  $bindTypes = str_repeat("s", count($data)) . "i";  // 's' for string, 'i' for integer (userId)

  // Manually bind the parameters
  $data[] = $userId; // Add $userId to the end of $data
  $stmt->bind_param($bindTypes, ...$data);

  // Execute the query and check the result
  if ($stmt->execute()) {
    echo "User updated successfully!";
    header("Location: list_corn_breeding_data.php");
    exit();
  } else {
    echo "Error updating user: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "../inc/head.php"; ?>
</head>

<body id="page-top">

  <div id="wrapper">
    <?php include "../inc/sidebar.php"; ?>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include "../inc/topbar.php"; ?>

        <div class="container-fluid">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">កែទិន្នន័យបង្កាត់ពូជពោត</h1>
            <?php
            if (isset($_SESSION['success_message_cbd'])) {
              echo "<div class='alert alert-success alert-dismissible fade show mb-0' role='alert'>
                        <strong>{$_SESSION['success_message_cbd']}</strong>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='this.parentElement.style.display=\"none\";'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
              unset($_SESSION['success_message_cbd']);
            }

            if (isset($_SESSION['error_message_cbd'])) {
              echo "<div class='alert alert-danger alert-dismissible fade show mb-0' role='alert'>
                        <strong>{$_SESSION['error_message_cbd']}</strong>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='this.parentElement.style.display=\"none\";'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
              unset($_SESSION['error_message_cbd']);
            }
            ?>
          </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <a class="btn btn-secondary" href="javascript:history.back()"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ថយក្រោយ</a>
            </div>

            <!-- Form for updating user details -->
            <form action="" method="post" class="row mt-3 px-3" enctype="multipart/form-data" id="editCBDForm">
              <input type="hidden" name="users_id" value="<?php echo htmlspecialchars($userId); ?>">

              <?php foreach ($columns as $column): ?>

                <?php if ($column != "users_id" && $column != 'cbd_id' && $column != 'name_of_cut_corn_variety' && $column != 'users_id'): ?>
                  <div class="col-12 col-md-6 mt-2 row">
                    <?php

                    if ($column == "first_corn_variety") {
                      echo "<label class='col-6'>ពូជទី១</label>";
                    } elseif ($column == "second_corn_variety") {
                      echo "<label class='col-6'>ពូជទី២</label>";
                    } elseif ($column == "version") {
                      echo "<label class='col-6'>ជំនាន់</label>";
                    } else {
                      echo "<label class='col-6'>$column</label>";
                    }



                    ?>
                    <!-- <label class="col-6"><?php echo ucfirst($column); ?>:</label> -->

                    <?php
                    if ($column === 'first_corn_variety' || $column === 'second_corn_variety'): ?>
                      <!-- Dropdown for 'corn_varieties' column, populated from the roles table -->
                      <select class="form-control col-6" name="<?php echo $column; ?>">
                        <?php foreach ($roles as $role): ?>
                          <option value="<?php echo $role['id']; ?>"
                            <?php echo ($user[$column] == $role['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($role['corn_varieties_name']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select><br>

                    <?php else: ?>
                      <!-- Text input for other columns -->
                      <input class="form-control col-6" type="text" name="<?php echo $column; ?>" value="<?php echo htmlspecialchars($user[$column]); ?>"><br>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>

              <?php endforeach; ?>

              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">រូបភាព</label>
                <input type="file" class="form-control col-6" id="images" name="images[]"
                  multiple accept="">
              </div>
              <div class="form-group col-sm-12 row mt-2">
                <?php
                if (!empty($imagePaths)) {
                  foreach ($imagePaths as $image_path) {
                    // Check the file extension to determine if it's an image or a video
                    $file_extension = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));

                    // Determine if the file is an image or video
                    if (in_array($file_extension, ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'webp'])) {
                      // Image
                      echo '<div class="image-container col-4 col-md-3" style="">';
                      echo '<img style="width:100%;" src="' . ($image_path) . '" alt="Image" class="issue-image">';
                      echo '<button type="button" class="close-button btn-sm delete-image" data-image="' . ($image_path) . '">&times;</button>';
                      echo '</div>';
                    }
                  }
                }
                ?>

                <div class="col-12 row mt-3" id="imagePreview">
                </div>
                <div class="col-12 my-2" style="text-align:end;">
                  <button type="submit" class="btn btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i> រក្សាទុក</button>
                </div>
            </form>
            <!-- <form method="POST" class="row mt-3 px-3" enctype="multipart/form-data" id="editCBDForm">
              <?php foreach ($columns as $column): ?>
                <?php if ($column === 'users_id'): ?>
                  <input type="hidden" name="users_id" value="<?= $user['users_id'] ?>">
                <?php endif; ?>

                <?php if ($column != 'cbd_id' && $column != 'name_of_cut_corn_variety' && $column != 'users_id'): ?>
                  <div class="col-12 col-md-6 mt-2 row">
                    <label class="col-6"><?php echo ucfirst($column); ?>:</label>
                    <?php if ($column === 'first_corn_variety' || $column === 'second_corn_variety'): ?>
                    
                      <select name="<?php echo $column; ?>">
                        <?php foreach ($roles as $role): ?>
                          <option value="<?php echo $role['id']; ?>"
                            <?php echo ($user[$column] == $role['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($role['corn_varieties_name']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select><br>

                    <?php else: ?>
                    
                      <input type="text" name="<?php echo $column; ?>" value="<?php echo htmlspecialchars($user[$column]); ?>"><br>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">រូបភាព</label>
                <input type="file" class="form-control col-6" id="images" name="images[]"
                  multiple accept="">
              </div>
              <div class="form-group col-sm-12 row mt-2">
                <?php
                if (!empty($image_paths)) {
                  foreach ($image_paths as $image_path) {
                    // Check the file extension to determine if it's an image or a video
                    $file_extension = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));

                    // Determine if the file is an image or video
                    if (in_array($file_extension, ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'webp'])) {
                      // Image
                      echo '<div class="image-container col-4 col-md-3" style="">';
                      echo '<img style="width:100%;" src="' . ($image_path) . '" alt="Image" class="issue-image">';
                      echo '<button type="button" class="close-button btn-sm delete-image" data-image="' . ($image_path) . '">&times;</button>';
                      echo '</div>';
                    }
                  }
                }
                ?>

                <div class="col-12 row mt-3" id="imagePreview">
                </div>
                <div class="col-12 my-2" style="text-align:end;">
                  <button type="submit" class="btn btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i> រក្សាទុក</button>
                </div>
            </form> -->
          </div>
        </div>
      </div>

      <?php include "../inc/footer.php"; ?>
    </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../assets/js/sb-admin-2.min.js"></script>
  <script src="../assets/js/PreViewImage.js"></script>
  <script src="../assets/js/removeImages.js"></script>

</body>

</html>