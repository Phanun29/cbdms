<?php include "../inc/script_header.php";

$cbd_id = $_GET['id'];

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
            <form action="" class="row mt-3 px-3">
              <div class="col-12 col-md-6 row mt-2">
                <label for="first_corn_variety" class="col-6">ពូជទី១ <span class="text-danger">*</span></label>

               
                <select class="form-control col-6" name="first_corn_variety" id="first_corn_variety" required>
                  <?php
                  // Perform SELECT query
                  $sql = "SELECT corn_varieties_name FROM tbl_corn_varieties";
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
                  $sql = "SELECT corn_varieties_name FROM tbl_corn_varieties";
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

                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['flower_day'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="male_flowering_day" class="col-6">ថ្ងៃចេញផ្កាឈ្មោល​ ៥០% <span class="text-danger">*</span></label>

                <input type="text" name="male_flowering_day" id="male_flowering_day" class="form-control col-6" value="<?= $cbd['male_flowering_day'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">គម្លាតអាយុចេញផ្កា</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['flowering_age_gap'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ចំនួនទងផ្កា</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['number_of_stalks'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ចំនួនផ្កាឈ្មោល</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['number_of_male_flower_stalks'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">អាយុចេញផ្កាឈ្មោល</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['male_flowering_age'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">អាយុចេញផ្កាញី</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['flowering_age'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">មុំស្លឹក</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['leaf_angle'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ភាពមានកន្ទុយលើចុងផ្លែ</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['the_tail_on_the_end_of_the_fruit'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ប្រវែងផ្លែ <span class="text-danger">*</span></label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['fruit_length'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ភាពជាប់ផ្លែ</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['fertility'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ទំហំដើម</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['original_size'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ប្រវែងគល់ផ្លែ</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['stem_length'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ប្រព័ន្ធឫស</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['root_system'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">អត្រាដំណុះ</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['germination_rate'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">កម្រិតកើត Albino</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['albino_birth_level'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">កម្រិតបំផ្លាញរបស់ដង្កូវ</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['worm_damage_level'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ភាពរឹងមាំ</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['strength'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">គម្លាតអាយុផ្កាញីនិងឈ្មោល</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['age_gap_between_male_and_female_flowers'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">កើតជំងឺ(Seuthern Rast)</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['seuthern_rast'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">អង្កត់ផ្ចិតផ្លែបកសំបក</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['peeled_fruit_diameter'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">កម្រិតការកើតជំងឺ</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['disease_level'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ប្រវែងផ្លែបបកសំបក</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['peel_length'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ចំនួនជួរគ្រាប់ក្នុងមួយផ្លែ</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['number_of_rows_of_seeds_per_fruit'] ?>">
              </div>

              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">សំបកផ្លែ</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['fruit_peel'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ទម្ងន់</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['weight'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ដង្កូវ</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['worm'] ?>">
              </div>

              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ភាពរឹងមាំរបស់កូន</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['seedling_vigor'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ការរៀងជួររបស់គ្រាប់</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['row_of_corn_kernels'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ចំនួនឫស</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['number_of_roots'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">ប្រវែងចុងស្នៀត(cm)</label>
                <input type="text" name="" id="" class="form-control col-6" value="<?= $cbd['tip_length'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="total" class="col-6">សរុប</label>
                <input type="text" name="total" id="total" class="form-control col-6" value="<?= $cbd['total'] ?>">
              </div>
              <div class="col-12 col-md-6 row mt-2">
                <label for="" class="col-6">រូបភាព</label>
                <input type="file" class="form-control col-6" id="issue_image" name="issue_image[]"
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
                      echo '<div class="image-container col-4 col-md-1" style="">';
                      echo '<img style="width:100%;" src="' . ($image_path) . '" alt="Issue Image" class="issue-image">';
                      echo '<button type="button" class="close-button btn-sm delete-image" data-image="' . ($image_path) . '">&times;</button>';
                      echo '</div>';
                    }
                  }
                }
                ?>

                <div class="col-12 row mt-3" id="imagePreview">
                  <div class="col-12 py-3">
                    <button type="submit" class="btn btn-primary">submit</button>
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

  <script src="../scripts/PreViewImage.js"></script>



</body>

</html>