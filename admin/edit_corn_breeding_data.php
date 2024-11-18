<?php
include "../inc/script_header.php";
include 'functions.php';

$userId = $_GET['id'] ?? null;
if (!$userId) {
  die("User ID is required.");
}

$columns = getUserColumns($conn);
// Fetch the user data to populate the form
$sql = "SELECT t.*, 
           GROUP_CONCAT(ti.image_path SEPARATOR ',') AS image_paths,
           cv1.corn_varieties_name AS first_variety_name, 
           cv2.corn_varieties_name AS second_variety_name
    FROM tbl_corn_breeding_data t 
    LEFT JOIN tbl_corn_breeding_data_images ti ON t.cbd_id = ti.cbd_id
    LEFT JOIN tbl_corn_varieties cv1 ON t.first_corn_variety = cv1.id
    LEFT JOIN tbl_corn_varieties cv2 ON t.second_corn_variety = cv2.id
    WHERE t.cbd_id = ? OR t.name_of_cut_corn_variety = ?
    GROUP BY t.cbd_id";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $userId, $userId);  // Binding both parameters for the query
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Explode the image paths into an array
$imagePaths = !empty($user['image_paths']) ? explode(',', $user['image_paths']) : [];
// // Fetch user data with associated image paths
// $sql = "SELECT t.*, 
//            GROUP_CONCAT(ti.image_path SEPARATOR ',') AS image_paths 
//            FROM tbl_corn_breeding_data t 
//            LEFT JOIN tbl_corn_breeding_data_images ti ON t.cbd_id = ti.cbd_id 
//            WHERE t.cbd_id = ? 
//            GROUP BY t.cbd_id";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $userId);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows == 0) {
//   die("User not found.");
// }

// $user = $result->fetch_assoc();
// $stmt->close();
// $imagePaths = !empty($user['image_paths']) ? explode(',', $user['image_paths']) : [];

// // Fetch corn varieties for dropdown
// $roles = [];
// $sql = "SELECT id, corn_varieties_name FROM tbl_corn_varieties WHERE corn_varieties_name = ''";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
//   while ($row = $result->fetch_assoc()) {
//     $roles[] = $row;
//   }
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $userId = $_POST['users_id'];
  $data = [];
  $setFields = [];

  foreach ($columns as $column) {
    if (isset($_POST[$column]) && $_POST[$column] !== '' && $column !== 'users_id') {
      $value = $_POST[$column];

      if ($column == 'first_corn_variety') {
        $stmt1 = $conn->prepare("SELECT corn_varieties_name FROM tbl_corn_varieties WHERE id = ?");
        $stmt1->bind_param('i', $value);
        $stmt1->execute();
        $first_variety_name = $stmt1->get_result()->fetch_assoc()['corn_varieties_name'];
        $stmt1->close();
      } elseif ($column == 'second_corn_variety') {
        $stmt2 = $conn->prepare("SELECT corn_varieties_name FROM tbl_corn_varieties WHERE id = ?");
        $stmt2->bind_param('i', $value);
        $stmt2->execute();
        $second_variety_name = $stmt2->get_result()->fetch_assoc()['corn_varieties_name'];
        $stmt2->close();
      } elseif ($column == 'version') {
        $version = $value;
      }

      if (isset($first_variety_name, $second_variety_name, $version)) {
        $name_of_cut_corn_variety = "$first_variety_name x $second_variety_name $version";

        $query_check = "SELECT COUNT(*) FROM tbl_corn_varieties WHERE corn_varieties_name = ?";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bind_param('s', $name_of_cut_corn_variety);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        $stmt_check->close();

        $query_namecut = "SELECT name_of_cut_corn_variety FROM tbl_corn_breeding_data WHERE cbd_id = ?";
        $stmt_namecut = $conn->prepare($query_namecut);
        $stmt_namecut->bind_param('i', $userId);
        $stmt_namecut->execute();
        $nameCUT = $stmt_namecut->get_result()->fetch_assoc()['name_of_cut_corn_variety'];
        $stmt_namecut->close();

        if ($name_of_cut_corn_variety != $nameCUT && $count > 0) {
          $_SESSION['error_message_cbd'] = "ការបង្កាត់ពូជពោតនេះមានរួចហើយ $name_of_cut_corn_variety";
          header("Location: edit_corn_breeding_data.php?id=$userId");
          exit();
        } else {
          $update_variety = "UPDATE tbl_corn_varieties SET corn_varieties_name = ? WHERE corn_varieties_name = ?";
          $stmt_update_variety = $conn->prepare($update_variety);
          $stmt_update_variety->bind_param('ss', $name_of_cut_corn_variety, $nameCUT);
          $stmt_update_variety->execute();
          $stmt_update_variety->close();

          $update_namecut = "UPDATE tbl_corn_breeding_data SET name_of_cut_corn_variety = ? WHERE cbd_id = ?";
          $stmt_namecut_update = $conn->prepare($update_namecut);
          $stmt_namecut_update->bind_param('si', $name_of_cut_corn_variety, $userId);
          $stmt_namecut_update->execute();
          $stmt_namecut_update->close();
        }
      }

      $data[] = $value;
      $setFields[] = "$column = ?";
    }
  }

  // Handle deleted images
  if (!empty($_POST['delete_images'])) {
    foreach ($_POST['delete_images'] as $deleted_image) {
      if (!empty($deleted_image) && file_exists($deleted_image)) {
        unlink($deleted_image);

        $delete_image_query = "DELETE FROM tbl_corn_breeding_data_images WHERE image_path = ?";
        $stmt_delete_image = $conn->prepare($delete_image_query);
        $stmt_delete_image->bind_param('s', $deleted_image);
        $stmt_delete_image->execute();
        $stmt_delete_image->close();
      }
    }
  }

  $new_dir = "../uploads/$userId/";
  if (!is_dir($new_dir)) mkdir($new_dir, 0777, true);

  if (!empty($_FILES['images']['name'][0])) {
    foreach ($_FILES['images']['name'] as $key => $image) {
      $image_extension = pathinfo($image, PATHINFO_EXTENSION);
      $unique_name = uniqid() . '.' . $image_extension;
      $target_file = $new_dir . $unique_name;

      if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $target_file)) {
        $stmt_media = $conn->prepare("INSERT INTO tbl_corn_breeding_data_images (cbd_id, image_path) VALUES (?, ?)");
        $stmt_media->bind_param("is", $userId, $target_file);
        $stmt_media->execute();
        $stmt_media->close();
      } else {
        $_SESSION['error_message_cbd'] = "Error uploading image: $image";
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
      }
    }
  }

  $setFieldsStr = implode(", ", $setFields);
  $sql = "UPDATE tbl_corn_breeding_data SET $setFieldsStr WHERE cbd_id = ?";
  $stmt = $conn->prepare($sql);

  $bindTypes = str_repeat("s", count($data)) . "i";
  $data[] = $userId;
  $stmt->bind_param($bindTypes, ...$data);

  if ($stmt->execute()) {
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
                  

                    <?php
                    if ($column === 'first_corn_variety' || $column === 'second_corn_variety'): ?>
                      <!-- Dropdown for 'corn_varieties' column, populated from the roles table -->
                      <!-- <select class="form-control col-6" name="<?php echo $column; ?>">
                        <?php foreach ($roles as $role): ?>
                          <option value="<?php echo $role['id']; ?>"
                            <?php echo ($user[$column] == $role['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($role['corn_varieties_name']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select> -->


                      <?php
                      $nameCut = $user['name_of_cut_corn_variety'];

                      $cornQuery = "SELECT id, corn_varieties_name FROM tbl_corn_varieties WHERE corn_varieties_name != '$nameCut' ";
                      $cornResult = $conn->query($cornQuery);
                      ?>
                      <select class="col-6 form-control" name="<?= $column; ?>" required>
                        <option value="">ជ្រើសរើសពូជ</option>
                        <?php while ($cornRow = $cornResult->fetch_assoc()): ?>
                          <option value="<?= $cornRow['id']; ?>" <?= ($user[$column] == $cornRow['id']) ? 'selected' : ''; ?>>
                            <?= $cornRow['corn_varieties_name']; ?>
                          </option>
                        <?php endwhile; ?>
                      </select>

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