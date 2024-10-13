<?php include "../inc/script_header.php";

$cbd_id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Gather form data
  $first_corn_variety = $_POST['first_corn_variety'];
  $second_corn_variety = $_POST['second_corn_variety'];
  $version = $_POST['version'];
  $fruit_height = $_POST['fruit_height'];
  $stem_height = $_POST['stem_height'];
  $flower_day = $_POST['flower_day'];
  $male_flowering_day = $_POST['male_flowering_day'];
  $flowering_age_gap = $_POST['flowering_age_gap'];
  $number_of_stalks = $_POST['number_of_stalks'];
  $number_of_male_flower_stalks = $_POST['number_of_male_flower_stalks'];
  $male_flowering_age = $_POST['male_flowering_age'];
  $flowering_age = $_POST['flowering_age'];
  $leaf_angle = $_POST['leaf_angle'];
  $the_tail_on_the_end_of_the_fruit = $_POST['the_tail_on_the_end_of_the_fruit'];
  $fruit_length = $_POST['fruit_length'];
  $fertility = $_POST['fertility'];
  $original_size = $_POST['original_size'];
  $stem_length = $_POST['stem_length'];
  $root_system = $_POST['root_system'];
  $germination_rate = $_POST['germination_rate'];
  $albino_birth_level = $_POST['albino_birth_level'];
  $worm_damage_level = $_POST['worm_damage_level'];
  $strength = $_POST['strength'];
  $age_gap_between_male_and_female_flowers = $_POST['age_gap_between_male_and_female_flowers'];
  $seuthern_rast = $_POST['seuthern_rast'];
  $peeled_fruit_diameter = $_POST['peeled_fruit_diameter'];
  $disease_level = $_POST['disease_level'];
  $peel_length = $_POST['peel_length'];
  $number_of_rows_of_seeds_per_fruit = $_POST['number_of_rows_of_seeds_per_fruit'];
  $fruit_peel = $_POST['fruit_peel'];
  $weight = $_POST['weight'];
  $worm = $_POST['worm'];
  $seedling_vigor = $_POST['seedling_vigor'];
  $row_of_corn_kernels = $_POST['row_of_corn_kernels'];
  $number_of_roots = $_POST['number_of_roots'];
  $tip_length = $_POST['tip_length'];
  $total = $_POST['total'];



  // Check if ticket_id exists in tbl_ticket
  $name_of_cut_corn_variety_query = "SELECT name_of_cut_corn_variety FROM tbl_corn_breeding_data WHERE cbd_id = '$cbd_id'";
  $name_of_cut_corn_variety_result = $conn->query($name_of_cut_corn_variety_query);
  if ($name_of_cut_corn_variety_result->num_rows > 0) {

    // Fetch existing ticket details
    $row = $name_of_cut_corn_variety_result->fetch_assoc();
    $name_of_cut_corn_variety = $row['name_of_cut_corn_variety'];


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

          // Delete from tbl_ticket_images
          $delete_image_query = "DELETE FROM tbl_corn_breeding_data_images WHERE image_path = '$deleted_image'";
          if ($conn->query($delete_image_query) == true) {
            echo "delete success";
          } else {
            echo "Error preparing delete statement: " . $conn->error;
          }
        }
      }
    }


    // Handle file uploads image
    $uploaded_images = [];
    if (!empty($_FILES['images']['name'][0])) {
      $target_dir = "../uploads/$name_of_cut_corn_variety/";
      if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

      foreach ($_FILES['images']['name'] as $key => $image) {
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);
        $unique_name = uniqid() . '.' . $image_extension;
        $target_file = $target_dir . $unique_name;

        if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $target_file)) {
          $uploaded_images[] = $target_file;

          // Secure prepared statement for inserting image paths
          $stmt_media = $conn->prepare("INSERT INTO tbl_corn_breeding_data_images (name_of_cut_corn_variety, image_path) VALUES (?, ?)");
          $stmt_media->bind_param("ss", $name_of_cut_corn_variety, $target_file);
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
  } else {
    // Ticket not found, handle this case (redirect or error message)
    $_SESSION['error_message_cbd'] = "Ticket not found.";
    header("Location: 404.php");
    exit();
  }

  // Update ticket details in the database
  $update_query = "UPDATE tbl_corn_breeding_data SET 
                    name_of_cut_corn_variety= ?,
                    first_corn_variety = ?,
                    second_corn_variety= ?,
                    version= ?,
                    fruit_height= ?,
                    stem_height= ?,
                    flower_day= ?,
                    male_flowering_day= ?,
                    flowering_age_gap= ?,
                    number_of_stalks= ?,
                    number_of_male_flower_stalks= ?,
                    male_flowering_age= ?,
                    flowering_age= ?,
                    leaf_angle= ?,
                    the_tail_on_the_end_of_the_fruit= ?,
                    fruit_length= ?,
                    fertility= ?,
                    original_size= ?,
                    stem_length= ?,
                    root_system= ?,
                    germination_rate= ?,
                    albino_birth_level= ?,
                    worm_damage_level= ?,
                    strength= ?,
                    age_gap_between_male_and_female_flowers= ?,
                    seuthern_rast= ?,
                    peeled_fruit_diameter= ?,
                    disease_level= ?,
                    peel_length= ?,
                    number_of_rows_of_seeds_per_fruit= ?,
                    fruit_peel= ?,
                    weight= ?,
                    worm= ?,
                    seedling_vigor= ?,
                    row_of_corn_kernels= ?,
                    number_of_roots= ?,
                    tip_length= ?,
                    total= ?
                  WHERE cbd_id = ?";

  $stmt_update = $conn->prepare($update_query);
  $stmt_update->bind_param(
    "ssssssssssssssssssssssssssssssssssssssi",
    $name_of_cut_corn_variety,
    $first_corn_variety,
    $second_corn_variety,
    $version,
    $fruit_height,
    $stem_height,
    $flower_day,
    $male_flowering_day,
    $flowering_age_gap,
    $number_of_stalks,
    $number_of_male_flower_stalks,
    $male_flowering_age,
    $flowering_age,
    $leaf_angle,
    $the_tail_on_the_end_of_the_fruit,
    $fruit_length,
    $fertility,
    $original_size,
    $stem_length,
    $root_system,
    $germination_rate,
    $albino_birth_level,
    $worm_damage_level,
    $strength,
    $age_gap_between_male_and_female_flowers,
    $seuthern_rast,
    $peeled_fruit_diameter,
    $disease_level,
    $peel_length,
    $number_of_rows_of_seeds_per_fruit,
    $fruit_peel,
    $weight,
    $worm,
    $seedling_vigor,
    $row_of_corn_kernels,
    $number_of_roots,
    $tip_length,
    $total,
    $cbd_id
  );

  if ($stmt_update->execute()) {

    $_SESSION['success_message_cbd'] = "cbd Updated Successfully.";
    $stmt_update->close();
    header("Location: list_corn_breeding_data.php");
    exit();
  } else {
    // Log the error
    error_log("Database error: " . $stmt_update->error);
    $_SESSION['error_message_cbd'] = "There was an error updating the data. Please try again.";
  }

  $stmt_update->close();
  header("Location: list_corn_breeding_data.php");
  exit();
}



// Prepared statement to prevent SQL injection
$cbd_query = $conn->prepare("SELECT t.*, GROUP_CONCAT(ti.image_path SEPARATOR ',') AS image_paths
                             FROM tbl_corn_breeding_data t 
                             LEFT JOIN tbl_corn_breeding_data_images ti 
                             ON t.name_of_cut_corn_variety = ti.name_of_cut_corn_variety
                             WHERE cbd_id = ? OR t.name_of_cut_corn_variety = ?
                             GROUP BY t.name_of_cut_corn_variety");
$cbd_query->bind_param('is', $cbd_id, $name_of_cut_corn_variety);
$cbd_query->execute();
$cbd_result = $cbd_query->get_result();
$cbd = $cbd_result->fetch_assoc();

$image_paths = !empty($cbd['image_paths']) ? explode(',', $cbd['image_paths']) : [];
$name_of_cut_corn_variety = $cbd['name_of_cut_corn_variety'];

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../inc/head.php"; ?>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->

    <?php include "../inc/sidebar.php"; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->

        <?php include "../inc/topbar.php"; ?>
        <!-- End of Topbar -->


        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">កែទិន្នន័យបង្កាត់ពូជពោត</h1>

          </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">

              <a class="btn btn-secondary" href="list_corn_breeding_data.php"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ថយក្រោយ</a>
            </div>
            <form METHOD="POST" class="row mt-3 px-3" enctype="multipart/form-data" id="editCBDForm">
              <div class="col-12 col-md-6 row mt-2">
                <label for="first_corn_variety" class="col-6">ពូជទី១ <span class="text-danger">*</span></label>


                <select class="form-control col-6" name="first_corn_variety" id="first_corn_variety" required>
                  <?php
                  // Perform SELECT query
                  $sql = "SELECT corn_varieties_name FROM tbl_corn_varieties WHERE corn_varieties_name != '$name_of_cut_corn_variety'";
                  $result = $conn->query($sql);

                  // Check if the query was successful
                  if ($result) {
                    // Fetch data and display options for the first dropdown
                    while ($row = $result->fetch_assoc()) {
                      // Set the selected option based on the value stored in the database
                      $selected = ($row['corn_varieties_name'] == $cbd['first_corn_variety']) ? 'selected' : '';
                      echo '<option value="' . $row['corn_varieties_name'] . '" ' . $selected . '>' . $row['corn_varieties_name'] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="second_corn_variety" class="col-6">ពូជទី២ <span class="text-danger">*</span></label>


                <select class="form-control col-6" name="second_corn_variety" id="second_corn_variety" required>
                  <?php
                  // Perform SELECT query
                  $sql = "SELECT corn_varieties_name FROM tbl_corn_varieties WHERE corn_varieties_name != '$name_of_cut_corn_variety'";
                  $result = $conn->query($sql);

                  // Check if the query was successful
                  if ($result) {
                    // Fetch data and display options for the first dropdown
                    while ($row = $result->fetch_assoc()) {
                      // Set the selected option based on the value stored in the database
                      $selected = ($row['corn_varieties_name'] == $cbd['second_corn_variety']) ? 'selected' : '';
                      echo '<option value="' . $row['corn_varieties_name'] . '" ' . $selected . '>' . $row['corn_varieties_name'] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="version" class="col-6">ជំនាន់ <span class="text-danger">*</span></label>

                <input type="text" name="version" id="version" class="form-control col-6" value="<?= $cbd['version'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="fruit_height" class="col-6">កម្ពស់ផ្លែ <span class="text-danger">*</span></label>

                <input type="text" name="fruit_height" id="fruit_height" class="form-control col-6" value="<?= $cbd['fruit_height'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="stem_height" class="col-6">កម្ពស់ដើម <span class="text-danger">*</span></label>

                <input type="text" name="stem_height" id="stem_height" class="form-control col-6" value="<?= $cbd['stem_height'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ថ្ងៃចេញផ្កាញី​ ៥០% <span class="text-danger">*</span></label>

                <input type="text" name="flower_day" id="flower_day" class="form-control col-6" value="<?= $cbd['flower_day'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="male_flowering_day" class="col-6">ថ្ងៃចេញផ្កាឈ្មោល​ ៥០% <span class="text-danger">*</span></label>

                <input type="text" name="male_flowering_day" id="male_flowering_day" class="form-control col-6" value="<?= $cbd['male_flowering_day'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">គម្លាតអាយុចេញផ្កា</label>
                <input type="text" name="flowering_age_gap" id="" class="form-control col-6" value="<?= $cbd['flowering_age_gap'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="number_of_stalks" class="col-6">ចំនួនទងផ្កា</label>
                <input type="text" name="number_of_stalks" id="number_of_stalks" class="form-control col-6" value="<?= $cbd['number_of_stalks'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ចំនួនផ្កាឈ្មោល</label>
                <input type="text" name="number_of_male_flower_stalks" id="number_of_male_flower_stalks" class="form-control col-6" value="<?= $cbd['number_of_male_flower_stalks'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="male_flowering_age" class="col-6">អាយុចេញផ្កាឈ្មោល</label>
                <input type="text" name="male_flowering_age" id="male_flowering_age" class="form-control col-6" value="<?= $cbd['male_flowering_age'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="flowering_age" class="col-6">អាយុចេញផ្កាញី</label>
                <input type="text" name="flowering_age" id="flowering_age" class="form-control col-6" value="<?= $cbd['flowering_age'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="leaf_angle" class="col-6">មុំស្លឹក</label>
                <input type="text" name="leaf_angle" id="leaf_angle" class="form-control col-6" value="<?= $cbd['leaf_angle'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="the_tail_on_the_end_of_the_fruit" class="col-6">ភាពមានកន្ទុយលើចុងផ្លែ</label>
                <input type="text" name="the_tail_on_the_end_of_the_fruit" id="the_tail_on_the_end_of_the_fruit" class="form-control col-6" value="<?= $cbd['the_tail_on_the_end_of_the_fruit'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="fruit_length" class="col-6">ប្រវែងផ្លែ <span class="text-danger">*</span></label>
                <input type="text" name="fruit_length" id="fruit_length" class="form-control col-6" value="<?= $cbd['fruit_length'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="fertility" class="col-6">ភាពជាប់ផ្លែ</label>
                <input type="text" name="fertility" id="fertility" class="form-control col-6" value="<?= $cbd['fertility'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="original_size" class="col-6">ទំហំដើម</label>
                <input type="text" name="original_size" id="original_size" class="form-control col-6" value="<?= $cbd['original_size'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="stem_length" class="col-6">ប្រវែងគល់ផ្លែ</label>
                <input type="text" name="stem_length" id="stem_length" class="form-control col-6" value="<?= $cbd['stem_length'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="root_system" class="col-6">ប្រព័ន្ធឫស</label>
                <input type="text" name="root_system" id="root_system" class="form-control col-6" value="<?= $cbd['root_system'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">អត្រាដំណុះ</label>
                <input type="text" name="germination_rate" id="germination_rate" class="form-control col-6" value="<?= $cbd['germination_rate'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="albino_birth_level" class="col-6">កម្រិតកើត Albino</label>
                <input type="text" name="albino_birth_level" id="albino_birth_level" class="form-control col-6" value="<?= $cbd['albino_birth_level'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="worm_damage_level" class="col-6">កម្រិតបំផ្លាញរបស់ដង្កូវ</label>
                <input type="text" name="worm_damage_level" id="worm_damage_level" class="form-control col-6" value="<?= $cbd['worm_damage_level'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="strength" class="col-6">ភាពរឹងមាំ</label>
                <input type="text" name="strength" id="strength" class="form-control col-6" value="<?= $cbd['strength'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="age_gap_between_male_and_female_flowers" class="col-6">គម្លាតអាយុផ្កាញីនិងឈ្មោល</label>
                <input type="text" name="age_gap_between_male_and_female_flowers" id="age_gap_between_male_and_female_flowers" class="form-control col-6" value="<?= $cbd['age_gap_between_male_and_female_flowers'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="seuthern_rast" class="col-6">កើតជំងឺ(Seuthern Rast)</label>
                <input type="text" name="seuthern_rast" id="seuthern_rast" class="form-control col-6" value="<?= $cbd['seuthern_rast'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="peeled_fruit_diameter" class="col-6">អង្កត់ផ្ចិតផ្លែបកសំបក</label>
                <input type="text" name="peeled_fruit_diameter" id="peeled_fruit_diameter" class="form-control col-6" value="<?= $cbd['peeled_fruit_diameter'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="disease_level" class="col-6">កម្រិតការកើតជំងឺ</label>
                <input type="text" name="disease_level" id="disease_level" class="form-control col-6" value="<?= $cbd['disease_level'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="peel_length" class="col-6">ប្រវែងផ្លែបបកសំបក</label>
                <input type="text" name="peel_length" id="peel_length" class="form-control col-6" value="<?= $cbd['peel_length'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="number_of_rows_of_seeds_per_fruit" class="col-6">ចំនួនជួរគ្រាប់ក្នុងមួយផ្លែ</label>
                <input type="text" name="number_of_rows_of_seeds_per_fruit" id="number_of_rows_of_seeds_per_fruit" class="form-control col-6" value="<?= $cbd['number_of_rows_of_seeds_per_fruit'] ?>">
              </div>

              <div class="col-12 col-md-6 row mt-2">
                <label for="fruit_peel" class="col-6">សំបកផ្លែ</label>
                <input type="text" name="fruit_peel" id="fruit_peel" class="form-control col-6" value="<?= $cbd['fruit_peel'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="weight" class="col-6">ទម្ងន់</label>
                <input type="text" name="weight" id="weight" class="form-control col-6" value="<?= $cbd['weight'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="worm" class="col-6">ដង្កូវ</label>
                <input type="text" name="worm" id="worm" class="form-control col-6" value="<?= $cbd['worm'] ?>">
              </div>

              <div class="col-12 col-md-6 row mt-2">
                <label for="seedling_vigor" class="col-6">ភាពរឹងមាំរបស់កូន</label>
                <input type="text" name="seedling_vigor" id="seedling_vigor" class="form-control col-6" value="<?= $cbd['seedling_vigor'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="row_of_corn_kernels" class="col-6">ការរៀងជួររបស់គ្រាប់</label>
                <input type="text" name="row_of_corn_kernels" id="row_of_corn_kernels" class="form-control col-6" value="<?= $cbd['row_of_corn_kernels'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="number_of_roots" class="col-6">ចំនួនឫស</label>
                <input type="text" name="number_of_roots" id="number_of_roots" class="form-control col-6" value="<?= $cbd['number_of_roots'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="tip_length" class="col-6">ប្រវែងចុងស្នៀត(cm)</label>
                <input type="text" name="tip_length" id="tip_length" class="form-control col-6" value="<?= $cbd['tip_length'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="total" class="col-6">សរុប</label>
                <input type="text" name="total" id="total" class="form-control col-6" value="<?= $cbd['total'] ?>">
              </div>
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
                <div class="col-12 py-3" style="text-align: end;">
                  <button type="submit" class="btn btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i> រក្សទុក</button>
                </div>
            </form>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php include "../inc/footer.php"; ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <!-- Bootstrap core JavaScript-->
  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../assets/js/sb-admin-2.min.js"></script>
  <!-- preview images -->
  <script src="../assets/js/PreViewImage.js"></script>
  <!-- remove images -->
  <script src="../assets/js/removeImages.js"></script>

</body>

</html>