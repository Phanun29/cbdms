<?php include "../inc/script_header.php";

$name_of_cut_corn_variety = $_GET['name_of_cut_corn_variety'];

$cbd_query = "SELECT  t.*, GROUP_CONCAT(ti.image_path SEPARATOR ',') AS image_paths
              FROM tbl_corn_breeding_data t 
              LEFT JOIN tbl_corn_breeding_data_images ti ON t.name_of_cut_corn_variety = ti.name_of_cut_corn_variety
              WHERE   t.name_of_cut_corn_variety = '$name_of_cut_corn_variety'
              GROUP BY t.name_of_cut_corn_variety";
$cbd_result = $conn->query($cbd_query);
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
            <h1 class="h3 mb-0 text-gray-800">មើលទិន្នន័យបង្កាត់ពូជពោត</h1>

          </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">

              <a class="btn btn-secondary" href="javascript:history.back()"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ថយក្រោយ</a>
              <p class="btn text-white"><?= $cbd['name_of_cut_corn_variety'] ?></p>
            </div>
            <form action="" class="row mt-3 px-3">
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ពូជទី១ </label>
                <?php
                $first_corn_variety =  $cbd['first_corn_variety'];
                // query select corn variety
                $query_first_corn_variety = "SELECT *FROM tbl_corn_varieties WHERE corn_varieties_name = '$first_corn_variety' ";
                $fcv_result = $conn->query($query_first_corn_variety);
                $fcv = $fcv_result->fetch_assoc();

                $status = $fcv['status'];

                if ($status) {
                  echo " <a href='view_corn_breeding_data_more.php?name_of_cut_corn_variety={$cbd['first_corn_variety']}' class='form-control col-6 text-primary mb-3'>{$cbd['first_corn_variety']}</a>";
                } else {
                  echo " <p class='form-control col-6'>{$cbd['first_corn_variety']}</p>";
                }

                ?>

              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ពូជទី២ </label>
                <?php
                $second_corn_variety =  $cbd['second_corn_variety'];
                $query_second_corn_variety = "SELECT *FROM tbl_corn_varieties WHERE corn_varieties_name = '$second_corn_variety' ";
                $scv_result = $conn->query($query_second_corn_variety);
                $scv = $scv_result->fetch_assoc();

                $status = $scv['status'];

                if ($status) {
                  echo " <a href='view_corn_breeding_data_more.php?name_of_cut_corn_variety={$cbd['second_corn_variety']}' class='form-control col-6 text-primary mb-3'>{$cbd['second_corn_variety']}</a>";
                } else {
                  echo " <p class='form-control col-6'>{$cbd['second_corn_variety']}</p>";
                }

                ?>

              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ជំនាន់</label>
                <p class="form-control col-6"><?= $cbd['version'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">កម្ពស់ផ្លែ</label>
                <p class="form-control col-6"><?= $cbd['fruit_height'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">កម្ពស់ដើម</label>
                <p class="form-control col-6"><?= $cbd['stem_height'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ថ្ងៃចេញផ្កាញី​ ៥០%</label>
                <p class="form-control col-6"><?= $cbd['flower_day'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ថ្ងៃចេញផ្កាឈ្មោល​ ៥០%</label>
                <p class="form-control col-6"><?= $cbd['male_flowering_day'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">គម្លាតអាយុចេញផ្កា</label>
                <p class="form-control col-6"><?= $cbd['flowering_age_gap'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ចំនួនទងផ្កាញី</label>
                <p class="form-control col-6"><?= $cbd['number_of_stalks'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ចំនួនផ្កាឈ្មោល</label>
                <p class="form-control col-6"><?= $cbd['number_of_male_flower_stalks'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">អាយុចេញផ្កាឈ្មោល</label>
                <p class="form-control col-6"><?= $cbd['male_flowering_age'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">អាយុចេញផ្កាញី</label>
                <p class="form-control col-6"><?= $cbd['flowering_age'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">មុំស្លឹក</label>
                <p class="form-control col-6"><?= $cbd['leaf_angle'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ភាពមានកន្ទុយលើចុងផ្លែ</label>
                <p class="form-control col-6"><?= $cbd['the_tail_on_the_end_of_the_fruit'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ប្រវែងផ្លែ <span class="text-danger">*</span></label>
                <p class="form-control col-6"><?= $cbd['fruit_length'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ភាពជាប់ផ្លែ</label>
                <p class="form-control col-6"><?= $cbd['fertility'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ទំហំដើម</label>
                <p class="form-control col-6"><?= $cbd['original_size'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ប្រវែងគល់ផ្លែ</label>
                <p class="form-control col-6"><?= $cbd['stem_length'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ប្រព័ន្ធឫស</label>
                <p class="form-control col-6"><?= $cbd['root_system'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">អត្រាដំណុះ</label>
                <p class="form-control col-6"><?= $cbd['germination_rate'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">កម្រិតកើត Albino</label>
                <p class="form-control col-6"><?= $cbd['albino_birth_level'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">កម្រិតបំផ្លាញរបស់ដង្កូវ</label>
                <p class="form-control col-6"><?= $cbd['worm_damage_level'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ភាពរឹងមាំ</label>
                <p class="form-control col-6"><?= $cbd['strength'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">គម្លាតអាយុផ្កាញីនិងឈ្មោល</label>
                <p class="form-control col-6"><?= $cbd['age_gap_between_male_and_female_flowers'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">កើតជំងឺ(Seuthern Rast)</label>
                <p class="form-control col-6"><?= $cbd['seuthern_rast'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">អង្កត់ផ្ចិតផ្លែបកសំបក</label>
                <p class="form-control col-6"><?= $cbd['peeled_fruit_diameter'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">កម្រិតការកើតជំងឺ</label>
                <p class="form-control col-6"><?= $cbd['disease_level'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ប្រវែងផ្លែបកសំបក</label>
                <p class="form-control col-6"><?= $cbd['peel_length'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ចំនួនជួរគ្រាប់ក្នុងមួយផ្លែ</label>
                <p class="form-control col-6"><?= $cbd['number_of_rows_of_seeds_per_fruit'] ?></p>
              </div>

              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">សំបកផ្លែ</label>
                <p class="form-control col-6"><?= $cbd['fruit_peel'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ទម្ងន់</label>
                <p class="form-control col-6"><?= $cbd['weight'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ដង្កូវ</label>
                <p class="form-control col-6"><?= $cbd['worm'] ?></p>
              </div>

              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ភាពរឹងមាំរបស់កូន</label>
                <p class="form-control col-6"><?= $cbd['seedling_vigor'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ការរៀងជួររបស់គ្រាប់</label>
                <p class="form-control col-6"><?= $cbd['row_of_corn_kernels'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ចំនួនឫស</label>
                <p class="form-control col-6"><?= $cbd['number_of_roots'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">ប្រវែងចុងស្នៀត(cm)</label>
                <p class="form-control col-6"><?= $cbd['tip_length'] ?></p>
              </div>
              <div class="col-12 col-md-6 row">
                <label for="" class="col-6">សរុប</label>
                <p class="form-control col-6"><?= $cbd['total'] ?></p>
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
                   
                      echo '</div>';
                    }
                  }
                }
                ?>

                <div class="col-12 row mt-3" id="imagePreview">
                </div>
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