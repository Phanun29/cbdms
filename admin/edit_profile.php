<?php
include "../inc/script_header.php";

$User_id = $_GET['id'];
// Check if the form was submitted for updating user information
if (isset($_POST['change_password'])) {
    // Get the new password and confirm password from the form
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Verify if the new password matches the confirm password
    if ($newPassword === $confirmPassword) {
        // Hash the new password
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Prepare and execute the SQL query to update the user's password
        $updateSql = "UPDATE tbl_users SET password = '$hashedNewPassword' WHERE users_id = $User_id";
        if ($conn->query($updateSql) === TRUE) {
            // Password updated successfully
            $_SESSION['success_message_user'] = 'បានផ្លាស់ប្តូរពាក្យសម្ងាត់ដោយជោគជ័យ.';
        } else {
            // Error updating password
            $_SESSION['error_message_user'] = 'កំហុសបានកើតឡើងខណៈពេលផ្លាស់ប្តូរពាក្យសម្ងាត់.';
        }
    } else {
        // New password and confirm password do not match
        $_SESSION['error_message_user'] = 'ពាក្យសម្ងាត់ថ្មី និងបញ្ជាក់ពាក្យសម្ងាត់មិនត្រូវគ្នាទេ.';
    }

    // Redirect back to the same page to display the alert message
    // header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $User_id);
    header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $User_id);
    exit();
}

// Check if form is submitted for update
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = $_POST['first_name'] ?? null;
    $last_name = $_POST['last_name'] ?? null;
    $username = $_POST['username'];
    $email = $_POST['email'] ?? null;
    $phone_number = $_POST['phone_number'] ?? null;

    // Fetch current data from the database
    $query = "SELECT first_name, last_name, username, email, phone_number, image FROM tbl_users WHERE users_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $User_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_info = $result->fetch_assoc();
    $current_image_path = $user_info['image'] ?? null;

    $stmt->close();

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $image_name = time() . '_' . basename($image['name']); // Create a unique name for the image
        $unique_name = uniqid() . '.' . $image_name;
        $upload_dir = '../profile_image/';
        $upload_file = $upload_dir . $unique_name;

        // Check if the upload directory exists, if not, create it
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($image['tmp_name'], $upload_file)) {
            $image_path = $upload_file; // Store the image path for database insertion
        } else {
            $_SESSION['error_message_user'] = "Error uploading image.";
            header('Location: users.php');
            exit();
        }
    } else {
        $image_path = $current_image_path; // Retain the old image if no new image is uploaded
    }

    // Check if the username already exists
    $check_query = "SELECT users_id FROM tbl_users WHERE username = ? AND users_id != ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("si", $username, $User_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error_message_user'] = "Username already exists. Please choose a different username.";
        $stmt->close();
        header("Location: edit_profile.php?id=$User_id");
        exit();
    }
    $stmt->close();

    // Check if any changes were made
    $changes_made = false;

    if ($first_name !== $user_info['first_name']) $changes_made = true;
    if ($last_name !== $user_info['last_name']) $changes_made = true;
    if ($username !== $user_info['username']) $changes_made = true;
    if ($email !== $user_info['email']) $changes_made = true;
    if ($phone_number !== $user_info['phone_number']) $changes_made = true;
    if ($image_path !== $user_info['image']) $changes_made = true;

    // If no changes are made, skip the update process
    if (!$changes_made) {
        header("Location: profile.php?id=$User_id");
        exit();
    }

    // Update user query if changes are made
    $update_user_query = "UPDATE tbl_users SET first_name = ?, last_name = ?, username = ?, email = ?, phone_number = ?, image = ? WHERE users_id = ?";
    $stmt = $conn->prepare($update_user_query);
    $stmt->bind_param("ssssssi", $first_name, $last_name, $username, $email, $phone_number, $image_path, $User_id);

    if ($stmt->execute()) {
        $_SESSION['success_message_user'] = "កែ​ Profile បានជោគជ័យ.";
    } else {
        $_SESSION['error_message_user'] = "Error updating user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back to profile.php
    header("Location: profile.php?id=$User_id");
    exit();
}






$user_query = "SELECT * FROM tbl_users WHERE users_id = '$User_id' ";
$user_result = $conn->query($user_query);
$user = $user_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include "../inc/head.php";
    ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        include "../inc/sidebar.php";
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include "../inc/topbar.php";
                ?>
                <!-- End of Topbar -->


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">កែ Profile</h1>
                        <?php
                        if (isset($_SESSION['success_message_user'])) {
                            echo "<div class='alert alert-success alert-dismissible fade show mb-0' role='alert'>
                                        <strong>{$_SESSION['success_message_user']}</strong>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='this.parentElement.style.display=\"none\";'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>";
                            unset($_SESSION['success_message_user']); // Clear the message after displaying
                        }

                        if (isset($_SESSION['error_message_user'])) {
                            echo "<div class='alert alert-danger alert-dismissible fade show mb-0' role='alert'>
                                        <strong>{$_SESSION['error_message_user']}</strong>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='this.parentElement.style.display=\"none\";'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>";
                            unset($_SESSION['error_message_user']); // Clear the message after displaying
                        }
                        ?>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a class="btn btn-secondary" href="javascript:history.back()"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ថយក្រោយ</a>


                        </div>
                        <form method="POST" class="row" enctype="multipart/form-data">
                            <div class="col-12 col-md-4">
                                <center>
                                    <div class="mt-3" style="width: 80%;">

                                        <!-- Image element that will be clicked to select a new image -->
                                        <?php if ($user['image'] != null) { ?>
                                            <img id="profileImage" style="object-fit: cover; width:50%;border:1px solid gray; cursor: pointer;" class="img-profile rounded mt-2" src="<?= $user['image'] ?>" alt="profile">
                                        <?php } else { ?>
                                            <img id="profileImage" style="object-fit: cover; width:50%;border:1px solid gray; cursor: pointer;" class="img-profile rounded" src="../assets/img/blank_profile21.jpg" alt="profile">
                                        <?php } ?>

                                    </div>
                                </center>
                                <!-- Hidden file input for selecting the image -->
                                <input type="file" id="imageUpload" name="image" accept="image/*" style="display: none;" />




                            </div>
                            <div class="col-12 col-md-8">
                                <div class="col-12 mt-3 row">
                                    <label for="last_name" class="col-4">នាមត្រកូល</label>
                                    <input type="text" name="last_name" id="" class="form-control col-8" value="<?= $user['last_name'] ?>">
                                </div>
                                <div class="col-12 row mt-3">
                                    <label class="col-4" for="first_name">នាមខ្លួន</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control col-8" value="<?= $user['first_name'] ?>">
                                </div>
                                <div class="col-12 row mt-3">
                                    <label class="col-4" for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="username" class="form-control col-8" value="<?= $user['username'] ?>" required>
                                </div>

                                <div class="col-12 row mt-3">
                                    <label class="col-4" for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control col-8" value="<?= $user['email'] ?>">
                                </div>
                                <div class="col-12 row mt-3">
                                    <label class="col-4" for="phone_number">លេខទូរស័ព្ទ</label>
                                    <input type="text" name="phone_number" id="phone_number" class="form-control col-8" value="<?= $user['phone_number'] ?>">
                                </div>


                                <div class="col-12 my-3" style="text-align: end;">
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


    <!-- auto close messgae -->
    <script src="../assets/js/auto_close_alert.js"></script>



    <!-- change image profile -->
    <script>
        // JavaScript to handle image selection and preview
        document.getElementById('profileImage').addEventListener('click', function() {
            // Trigger the hidden file input when the image is clicked
            document.getElementById('imageUpload').click();
        });

        // Event listener for file input change
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            // Check if the user selected a file
            if (event.target.files && event.target.files[0]) {
                var reader = new FileReader();

                // Once the file is read, display the image preview
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                };

                // Read the selected image file
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    </script>







</body>

</html>