<?php
include "../inc/script_header.php";
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the columns for the users table
    $columns = getUserColumns($conn);

    $data = [];
    $placeholders = [];
    $bindTypes = "";

    // Assuming $columns is an array containing column names
    foreach ($columns as $column) {
        if (isset($_POST[$column]) && $column != 'cbd_id') {
            $value = $_POST[$column];

            // Check for 'first_variety_name'
            if ($column == 'first_corn_variety') {
                // Store the value for first variety
                $data[$column] = $value;
                $placeholders[] = "?";
                $bindTypes .= "s"; // Assuming it's a string

                // Prepare query to retrieve the first corn variety name
                $query_first_variety = "SELECT corn_varieties_name FROM tbl_corn_varieties WHERE id = ?";
                $stmt1 = $conn->prepare($query_first_variety);
                $stmt1->bind_param('i', $value); // Bind the 'first_corn_variety' ID
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                $first_variety_name = $result1->fetch_assoc()['corn_varieties_name'];

                // Optional: Log or echo the value for debugging
                //  echo "First corn variety name: " . $first_variety_name;
            }

            // Check for 'second_variety_name'
            if ($column == 'second_corn_variety') {
                // Store the value for second variety
                $data[$column] = $value;
                $placeholders[] = "?";
                $bindTypes .= "s"; // Assuming it's a string

                // Prepare query to retrieve the second corn variety name
                $query_second_variety = "SELECT corn_varieties_name FROM tbl_corn_varieties WHERE id = ?";
                $stmt2 = $conn->prepare($query_second_variety);
                $stmt2->bind_param('i', $value); // Bind the 'second_corn_variety' ID
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $second_variety_name = $result2->fetch_assoc()['corn_varieties_name'];

                // Optional: Log or echo the value for debugging
                //    echo "Second corn variety name: " . $second_variety_name;
            }

            // Check for 'version'
            if ($column == 'version') {
                $data[$column] = $value;
                $placeholders[] = "?";
                $bindTypes .= "s";
                $version = $value;
            }

            // Handle other columns normally
            if ($column != 'first_corn_variety' && $column != 'second_corn_variety' && $column != 'version') {
                $data[$column] = $value;
                $placeholders[] = "?";

                if (is_numeric($value)) {
                    $bindTypes .= "i";
                } else {
                    $bindTypes .= "s";
                }
            }
        }
    }
    //   Now you can use $first_variety_name, $second_variety_name, and $version for inserting into another table
    if (isset($first_variety_name) && isset($second_variety_name) && isset($version)) {

        // Assuming $first_variety_name, $second_variety_name, and $version are set

        $name_of_cut_corn_variety = $first_variety_name . " x " . $second_variety_name . " " . $version;

        // Check if the combination already exists in tbl_corn_varieties
        $query_check = "SELECT COUNT(*) FROM tbl_corn_varieties WHERE corn_varieties_name = ?";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bind_param('s', $name_of_cut_corn_variety);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($count > 0) {
            $_SESSION['error_message_cbd'] = "ការបង្កាត់ពូជពោតនេះមានរួចហើយ។";
           
            header("Location: add_corn_breeding_data.php");
            exit();
        } else {
            // Entry does not exist, proceed with insertion
            $query_insert = "INSERT INTO tbl_corn_varieties (corn_varieties_name, status) VALUES (?, '1')";
            $stmt_insert = $conn->prepare($query_insert);
            $stmt_insert->bind_param('s', $name_of_cut_corn_variety);

            if ($stmt_insert->execute()) {
                echo "Corn variety inserted successfully!";
            } else {
                echo "Error inserting corn variety: " . $stmt_insert->error;
            }
            $stmt_insert->close();
        }
    }
    //  $name_of_cut_corn_variety = $first_variety_name . " x " . $second_variety_name . " " . $version;

    // Add name_of_cut_corn_variety to the $data array
    $data['name_of_cut_corn_variety'] = $name_of_cut_corn_variety;
    $placeholders[] = "?"; // Add a placeholder for the new column
    $bindTypes .= "s"; // Assuming it's a string, so add 's' to the bind types


    $columnList = implode(", ", array_keys($data));
    $placeholderList = implode(", ", $placeholders);
    $sql = "INSERT INTO tbl_corn_breeding_data ($columnList) VALUES ($placeholderList)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param($bindTypes, ...array_values($data));

    if ($stmt->execute()) {
        $cbd_id = $conn->insert_id;  // Get the cbd_id of the newly inserted record



        // Handle file uploads
        $uploaded_images = [];
        if (!empty($_FILES['images']['name'][0])) {
            $target_dir = "../uploads/$cbd_id/";
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

        $image_insert_success = true;
        foreach ($uploaded_images as $target_file) {
            // Insert image along with cbd_id
            $query_media = "INSERT INTO tbl_corn_breeding_data_images (cbd_id, image_path) VALUES (?, ?)";
            $stmt_media = $conn->prepare($query_media);
            $stmt_media->bind_param("is", $cbd_id, $target_file);

            if ($stmt_media->execute()) {
                // Image uploaded successfully for this cbd_id
            } else {
                // Handle the error if image insertion fails
            }
            $stmt_media->close();
        }

        $_SESSION['success_message_cbd'] = "បន្ងែមទិន្នន័យបង្កាត់ពូជពោតបានជោគជ័យ.";

        header("Location: list_corn_breeding_data.php"); // Redirect after successful insert
        exit();
    } else {
        echo "Error adding record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

$columns = getUserColumns($conn);
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
                        <!-- <form action="" class="row mt-3 px-3" method="POST" enctype="multipart/form-data">
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
                                <label for="fruit_height" class="col-6">កម្ពស់ផ្លែ <span class="text-danger"></span></label>
                                <input type="text" name="fruit_height" id="fruit_height" class="form-control col-6" >
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="stem_height" class="col-6">កម្ពស់ដើម <span class="text-danger"></span></label>
                                <input type="text" name="stem_height" id="stem_height" class="form-control col-6" >
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="flower_day" class="col-6">ថ្ងៃចេញផ្កាញី​ ៥០% <span class="text-danger"></span></label>
                                <input type="text" name="flower_day" id="flower_day" class="form-control col-6" >
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="male_flowering_day" class="col-6">ថ្ងៃចេញផ្កាឈ្មោល​ ៥០% <span class="text-danger"></span></label>
                                <input type="text" name="male_flowering_day" id="male_flowering_day" class="form-control col-6" >
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
                        
                            <div class="col-12 row mt-3" id="imagePreview">
                            </div>
                            <div class="col-12 my-2" style="text-align:end;">

                                <button type="submit" class="btn btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i> រក្សាទុក</button>

                            </div>

                        </form> -->
                        <!-- Form for adding a new user -->
                        <form action="" method="post" class="row mt-3 px-3" enctype="multipart/form-data">
                            <?php foreach ($columns as $column): ?>
                                <?php if ($column === 'users_id'): ?>
                                    <input type="hidden" name="users_id" value="<?= $fetch_info['users_id'] ?>">
                                <?php endif; ?>

                                <?php if ($column != 'cbd_id' && $column != 'name_of_cut_corn_variety' && $column != 'users_id'): ?>
                                    <div class="col-12 col-md-6 mt-2 row">
                                        <?php
                                        if ($column === 'first_corn_variety') {
                                            echo "  <label class='col-6'>ពូជទី១ <span class='text-danger'>*</span></label>";
                                        } elseif ($column === 'second_corn_variety') {
                                            echo "  <label class='col-6'>ពូជទី2 <span class='text-danger'>*</span></label>";
                                        } elseif ($column == "version") {
                                            echo "<label class='col-6'>ជំនាន់<span class='text-danger'>*</span></label>";
                                        } else {
                                            echo "<label class='col-6'>$column</label>";
                                        }

                                        ?>
                                        <!-- <label class="col-6"><?php echo ucfirst($column); ?>:</label> -->

                                        <?php if ($column === 'first_corn_variety' || $column === 'second_corn_variety'): ?>
                                            <!-- Dropdown for 'corn_varieties' column, populated from tbl_corn_varieties -->
                                            <?php
                                            $cornQuery = "SELECT id, corn_varieties_name FROM tbl_corn_varieties";
                                            $cornResult = $conn->query($cornQuery);
                                            ?>
                                            <select class="col-6 form-control" name="<?php echo $column; ?>" required>
                                                <option value="">ជ្រើសរើសពូជ</option>
                                                <?php while ($cornRow = $cornResult->fetch_assoc()): ?>
                                                    <option value="<?php echo $cornRow['id']; ?>">
                                                        <?php echo $cornRow['corn_varieties_name']; ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select><br>
                                        <?php else: ?>
                                            <input class="form-control col-6" type="text" name="<?php echo $column; ?>"><br>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">រូបភាព</label>
                                <input type="file" class="form-control col-6" id="images" name="images[]" multiple accept="">
                            </div>

                            <div class="col-12 row mt-3" id="imagePreview">
                            </div>
                            <div class="col-12 row my-2" style="">
                                <div class="col-6">

                                </div>
                                <div class="col-6" style='text-align:end; '>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i> រក្សាទុក</button>
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

    <!-- preview images -->
    <script src="../assets/js/PreViewImage.js"></script>



</body>

</html>