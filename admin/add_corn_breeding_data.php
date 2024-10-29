<?php include "../inc/script_header.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $add_by = $fetch_info['users_id'];

    // Sanitize and retrieve form data
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
    // Retrieve corn variety names based on the selected IDs
    $query_first_variety = "SELECT corn_varieties_name FROM tbl_corn_varieties WHERE id = ?";
    $query_second_variety = "SELECT corn_varieties_name FROM tbl_corn_varieties WHERE id = ?";

    // Prepare statements
    $stmt1 = $conn->prepare($query_first_variety);
    $stmt2 = $conn->prepare($query_second_variety);

    // Bind parameters and execute for the first variety
    $stmt1->bind_param('s', $first_corn_variety);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $first_variety_name = $result1->fetch_assoc()['corn_varieties_name'];

    // Bind parameters and execute for the second variety
    $stmt2->bind_param('s', $second_corn_variety);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $second_variety_name = $result2->fetch_assoc()['corn_varieties_name'];

    // Check for the latest count based on the variety combination and increment it
    $count_query = "
    SELECT COUNT(*) AS countup 
    FROM tbl_corn_breeding_data 
    WHERE first_corn_variety = ? 
    AND second_corn_variety = ?
";
    $stmt_count = $conn->prepare($count_query);
    $stmt_count->bind_param('ss', $first_corn_variety, $second_corn_variety);
    $stmt_count->execute();
    $result_count = $stmt_count->get_result();
    $countup = $result_count->fetch_assoc()['countup'] + 1;

    // Generate name of cut corn variety with incremented count
    $name_of_cut_corn_variety = $first_variety_name . " x " . $second_variety_name . " " . $version;



    // Handle file uploads
    $uploaded_images = [];
    if (!empty($_FILES['images']['name'][0])) {
        $target_dir = "../uploads/$name_of_cut_corn_variety/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        foreach ($_FILES['images']['name'] as $key => $image) {
            $image_extension = pathinfo($image, PATHINFO_EXTENSION);
            $unique_name = uniqid() . '.' . $image_extension;
            $target_file = $target_dir . $unique_name;
            if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $target_file)) {
                $uploaded_images[] = $target_file; // Save the file path
            } else {
                $_SESSION['error_message_cbd'] = "Error uploading image: " . $image;
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit();
            }
        }
    }
    // Check if the corn variety name already exists
    $check_query = "SELECT * FROM tbl_corn_varieties WHERE corn_varieties_name = ?";
    $stmt_check = $conn->prepare($check_query);
    $stmt_check->bind_param('s', $name_of_cut_corn_variety);
    $stmt_check->execute();
    $check_result = $stmt_check->get_result();

    // If the name already exists, send an error response and redirect
    if ($check_result->num_rows > 0) {
        $_SESSION['error_message_cbd'] = "ការបង្កាត់ពូជពោតនេះមានរួចហើយ។";
        $stmt_check->close();
        header("Location: add_corn_breeding_data.php");
        exit();
    }

    // Name does not exist, so insert the new variety
    $query_corn_varieties = "INSERT INTO tbl_corn_varieties (corn_varieties_name, status) VALUES (?, '1')";
    $stmt_insert_variety = $conn->prepare($query_corn_varieties);
    $stmt_insert_variety->bind_param('s', $name_of_cut_corn_variety);

    if ($stmt_insert_variety->execute()) {
     //   $_SESSION['success_message_cbd'] = "Corn variety inserted successfully.";
    } else {
      //  $_SESSION['error_message_cbd'] = "Error inserting corn variety.";
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO tbl_corn_breeding_data (name_of_cut_corn_variety, users_id, first_corn_variety, second_corn_variety, version, fruit_height, stem_height, flower_day, male_flowering_day, flowering_age_gap, number_of_stalks, number_of_male_flower_stalks, male_flowering_age, flowering_age, leaf_angle, the_tail_on_the_end_of_the_fruit, fruit_length, fertility, original_size, stem_length, root_system, germination_rate, albino_birth_level, worm_damage_level, strength, age_gap_between_male_and_female_flowers, seuthern_rast, peeled_fruit_diameter, disease_level, peel_length, number_of_rows_of_seeds_per_fruit, fruit_peel, weight, worm, seedling_vigor, row_of_corn_kernels, number_of_roots, tip_length, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssssssssssssssssssssssssssssssssss", $name_of_cut_corn_variety, $add_by, $first_corn_variety, $second_corn_variety, $version, $fruit_height, $stem_height, $flower_day, $male_flowering_day, $flowering_age_gap, $number_of_stalks, $number_of_male_flower_stalks, $male_flowering_age, $flowering_age, $leaf_angle, $the_tail_on_the_end_of_the_fruit, $fruit_length, $fertility, $original_size, $stem_length, $root_system, $germination_rate, $albino_birth_level, $worm_damage_level, $strength, $age_gap_between_male_and_female_flowers, $seuthern_rast, $peeled_fruit_diameter, $disease_level, $peel_length, $number_of_rows_of_seeds_per_fruit, $fruit_peel, $weight, $worm, $seedling_vigor, $row_of_corn_kernels, $number_of_roots, $tip_length, $total);

    if ($stmt->execute()) {

        $image_insert_success = true;
        foreach ($uploaded_images as $target_file) {
            $query_media = "INSERT INTO tbl_corn_breeding_data_images (name_of_cut_corn_variety, image_path) VALUES ('$name_of_cut_corn_variety', '$target_file')";
            if ($conn->query($query_media) == true) {
                //   echo "success";
            } else {
                //   echo "error" . $query_media . $conn->error;
            }
        }


        $_SESSION['success_message_cbd'] = "បន្ងែមទិន្នន័យបង្កាត់ពូជពោតបានជោគជ័យ.";
    } else {
        $_SESSION['error_message_cbd'] = "បន្ងែមទិន្នន័យបង្កាត់ពូជពោតបរាជ័យ.";
    }
    $stmt->close();
    // Redirect to the page ticket to display messages
    header("Location: list_corn_breeding_data.php");
    exit();
    $conn->close();
}


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
                        <h1 class="h3 mb-0 text-gray-800"> បន្ថែមទិន្នន័យបង្កាត់ពូជពោត</h1>
                        <?php
                        if (isset($_SESSION['success_message_cbd'])) {
                            echo "<div class='alert alert-success alert-dismissible fade show mb-0' role='alert'>
                                        <strong>{$_SESSION['success_message_cbd']}</strong>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='this.parentElement.style.display=\"none\";'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>";
                            unset($_SESSION['success_message_cbd']); // Clear the message after displaying
                        }

                        if (isset($_SESSION['error_message_cbd'])) {
                            echo "<div class='alert alert-danger alert-dismissible fade show mb-0' role='alert'>
                                        <strong>{$_SESSION['error_message_cbd']}</strong>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='this.parentElement.style.display=\"none\";'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>";
                            unset($_SESSION['error_message_cbd']); // Clear the message after displaying
                        }
                        ?>
                    </div>

                    <!-- DataTales Corn Breeding Data -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">

                            <a class="btn btn-secondary" href="javascript:history.back()"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ថយក្រោយ</a>
                        </div>
                        <form action="" class="row mt-3 px-3" method="POST" enctype="multipart/form-data">
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="first_corn_variety" class="col-6">ពូជទី១ <span class="text-danger">*</span></label>

                                <select name="first_corn_variety" id="first_corn_variety" class="form-control col-6" required>
                                    <option value="" disabled selected>--ជ្រើសរើស--</option>
                                    <?php
                                    $query_corn_varieties = "SELECT *FROM tbl_corn_varieties";
                                    $result = $conn->query($query_corn_varieties);

                                    if ($result->num_rows > 0) {
                                        while ($corn_varieties = $result->fetch_assoc()) {
                                            echo " <option value='{$corn_varieties['id']}'>{$corn_varieties['corn_varieties_name']} </option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="second_corn_variety" class="col-6">ពូជទី២ <span class="text-danger">*</span></label>
                                <select name="second_corn_variety" id="second_corn_variety" class="form-control col-6" required>
                                    <option value="" disabled selected>--ជ្រើសរើស--</option>
                                    <?php
                                    $query_corn_varieties = "SELECT *FROM tbl_corn_varieties";
                                    $result = $conn->query($query_corn_varieties);

                                    if ($result->num_rows > 0) {
                                        while ($corn_varieties = $result->fetch_assoc()) {
                                            echo " <option value='{$corn_varieties['id']}'>{$corn_varieties['corn_varieties_name']} </option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="version" class="col-6">ជំនាន់ <span class="text-danger">*</span></label>
                                <input type="text" name="version" id="version" class="form-control col-6" required>
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="fruit_height" class="col-6">កម្ពស់ផ្លែ <span class="text-danger">*</span></label>
                                <input type="text" name="fruit_height" id="fruit_height" class="form-control col-6" required>
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="stem_height" class="col-6">កម្ពស់ដើម <span class="text-danger">*</span></label>
                                <input type="text" name="stem_height" id="stem_height" class="form-control col-6" required>
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="flower_day" class="col-6">ថ្ងៃចេញផ្កាញី​ ៥០% <span class="text-danger">*</span></label>
                                <input type="text" name="flower_day" id="flower_day" class="form-control col-6" required>
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="male_flowering_day" class="col-6">ថ្ងៃចេញផ្កាឈ្មោល​ ៥០% <span class="text-danger">*</span></label>
                                <input type="text" name="male_flowering_day" id="male_flowering_day" class="form-control col-6" required>
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="flowering_age_gap" class="col-6">គម្លាតអាយុចេញផ្កា</label>
                                <input type="text" name="flowering_age_gap" id="flowering_age_gap" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="number_of_stalks" class="col-6">ចំនួនទងផ្កាញី</label>
                                <input type="text" name="number_of_stalks" id="number_of_stalks" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="number_of_male_flower_stalks" class="col-6">ចំនួនផ្កាឈ្មោល</label>
                                <input type="text" name="number_of_male_flower_stalks" id="number_of_male_flower_stalks" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="male_flowering_age" class="col-6">អាយុចេញផ្កាឈ្មោល</label>
                                <input type="text" name="male_flowering_age" id="male_flowering_age" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="flowering_age" class="col-6">អាយុចេញផ្កាញី</label>
                                <input type="text" name="flowering_age" id="flowering_age" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="leaf_angle" class="col-6">មុំស្លឹក</label>
                                <input type="text" name="leaf_angle" id="leaf_angle" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="the_tail_on_the_end_of_the_fruit" class="col-6">ភាពមានកន្ទុយលើចុងផ្លែ</label>
                                <input type="text" name="the_tail_on_the_end_of_the_fruit" id="the_tail_on_the_end_of_the_fruit" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="fruit_length" class="col-6">ប្រវែងផ្លែ <span class="text-danger">*</span></label>
                                <input type="text" name="fruit_length" id="fruit_length" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="fertility" class="col-6">ភាពជាប់ផ្លែ</label>
                                <input type="text" name="fertility" id="fertility" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="original_size" class="col-6">ទំហំដើម</label>
                                <input type="text" name="original_size" id="original_size" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="stem_length" class="col-6">ប្រវែងគល់ផ្លែ</label>
                                <input type="text" name="stem_length" id="stem_length" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="root_system" class="col-6">ប្រព័ន្ធឫស</label>
                                <input type="text" name="root_system" id="root_system" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="germination_rate" class="col-6">អត្រាដំណុះ</label>
                                <input type="text" name="germination_rate" id="germination_rate" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="albino_birth_level" class="col-6">កម្រិតកើត Albino</label>
                                <input type="text" name="albino_birth_level" id="albino_birth_level" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="worm_damage_level" class="col-6">កម្រិតបំផ្លាញរបស់ដង្កូវ</label>
                                <input type="text" name="worm_damage_level" id="worm_damage_level" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="strength" class="col-6">ភាពរឹងមាំ</label>
                                <input type="text" name="strength" id="strength" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="age_gap_between_male_and_female_flowers" class="col-6">គម្លាតអាយុផ្កាញីនិងឈ្មោល</label>
                                <input type="text" name="age_gap_between_male_and_female_flowers" id="age_gap_between_male_and_female_flowers" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="seuthern_rast" class="col-6">កើតជំងឺ(Seuthern Rast)</label>
                                <input type="text" name="seuthern_rast" id="seuthern_rast" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="peeled_fruit_diameter" class="col-6">អង្កត់ផ្ចិតផ្លែបកសំបក</label>
                                <input type="text" name="peeled_fruit_diameter" id="peeled_fruit_diameter" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="disease_level" class="col-6">កម្រិតការកើតជំងឺ</label>
                                <input type="text" name="disease_level" id="disease_level" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="peel_length" class="col-6">ប្រវែងផ្លែបកសំបក</label>
                                <input type="text" name="peel_length" id="peel_length" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="number_of_rows_of_seeds_per_fruit" class="col-6">ចំនួនជួរគ្រាប់ក្នុងមួយផ្លែ</label>
                                <input type="text" name="number_of_rows_of_seeds_per_fruit" id="number_of_rows_of_seeds_per_fruit" class="form-control col-6">
                            </div>

                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="fruit_peel" class="col-6">សំបកផ្លែ</label>
                                <input type="text" name="fruit_peel" id="fruit_peel" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="weight" class="col-6">ទម្ងន់</label>
                                <input type="text" name="weight" id="weight" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="worm" class="col-6">ដង្កូវ</label>
                                <input type="text" name="worm" id="worm" class="form-control col-6">
                            </div>

                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="seedling_vigor" class="col-6">ភាពរឹងមាំរបស់កូន</label>
                                <input type="text" name="seedling_vigor" id="seedling_vigor" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="row_of_corn_kernels" class="col-6">ការរៀងជួររបស់គ្រាប់</label>
                                <input type="text" name="row_of_corn_kernels" id="row_of_corn_kernels" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="number_of_roots" class="col-6">ចំនួនឫស</label>
                                <input type="text" name="number_of_roots" id="number_of_roots" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="tip_length" class="col-6">ប្រវែងចុងស្នៀត(cm)</label>
                                <input type="text" name="tip_length" id="tip_length" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="total" class="col-6">សរុប</label>
                                <input type="text" name="total" id="total" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">រូបភាព</label>
                                <input type="file" class="form-control col-6" id="images" name="images[]" multiple accept="">
                            </div>
                            <!-- Display selected new images -->
                            <div class="col-12 row mt-3" id="imagePreview">
                            </div>
                            <div class="col-12 my-2" style="text-align:end;">

                                <button type="submit" class="btn btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i> រក្សាទុក</button>

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



</body>

</html>