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
        $updateSql = "UPDATE tbl_users SET password = '$hashedNewPassword' WHERE user_id = $User_id";
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
    $user_type = $_POST['user_type'];
    $status = $_POST['status'];

    // Fetch current image from the database
    $query = "SELECT first_name, last_name, username, email, phone_number, user_type, status, image FROM tbl_users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $User_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_info = $result->fetch_assoc();
    $current_image_path = $user_info['image'] ?? null; // Store the current image path

    $stmt->close();

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $image_name = time() . '_' . basename($image['name']); // Create a unique name for the image
        $unique_name = uniqid() . '.' . $image_name;
        $upload_dir = '../profile_image/'; // Set the upload directory
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
    $check_query = "SELECT user_id FROM tbl_users WHERE username = ? AND user_id != ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("si", $username, $User_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error_message_user'] = "Username already exists. Please choose a different username.";
        $stmt->close();
        header("Location: edit_users.php?id=$User_id");
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
    if ($user_type !== $user_info['user_type']) $changes_made = true;
    if ($status !== $user_info['status']) $changes_made = true;
    if ($image_path !== $user_info['image']) $changes_made = true;

    // If no changes are made, skip the update process
    if (!$changes_made) {
        header("Location: list_users.php?id=$User_id");
        exit();
    }


    // Update user query if changes are made
    $update_user_query = "UPDATE tbl_users SET first_name = ?, last_name = ?, username = ?, email = ?, phone_number = ?, image = ?, status = ?, user_type = ? WHERE user_id = ?";
    $stmt = $conn->prepare($update_user_query);
    $stmt->bind_param("ssssssssi", $first_name, $last_name, $username, $email, $phone_number, $image_path, $status, $user_type, $User_id);

    if ($stmt->execute()) {
        $_SESSION['success_message_user'] = "ព័ត៌អ្នកប្រើប្រាស់ត្រូវបានធ្វើបច្ចុប្បន្នភាពជោគជ័យ.";
    } else {
        $_SESSION['error_message_user'] = "Error updating user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back to users.php
    header("Location: list_users.php");
    exit();
}






$user_query = "SELECT * FROM tbl_users WHERE user_id = '$User_id' ";
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
                        <h1 class="h3 mb-0 text-gray-800">កែព័ត៌មានអ្នកប្រើប្រាស់</h1>
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
                            <a class="btn btn-secondary" href="list_users.php"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ថយក្រោយ</a>

                            <button type="button" id="changePasswordBtn" class="btn btn-primary" data-toggle="modal"
                                data-target="#myModal">
                                <i class="fas fa-lock"></i> ​ប្តូរពាក្យសម្ងាត់
                            </button>
                        </div>
                        <form method="POST" class="row" enctype="multipart/form-data">
                            <div class="col-12 col-md-4">
                                <center>
                                    <div class="mt-3" style="width: 80%;">

                                        <!-- Image element that will be clicked to select a new image -->
                                        <?php if ($user['image'] != null) { ?>
                                            <img id="profileImage" style="object-fit: cover; width:60%;border:1px solid gray; cursor: pointer;" class="img-profile rounded" src="<?= $user['image'] ?>" alt="profile">
                                        <?php } else { ?>
                                            <img id="profileImage" style="object-fit: cover; width:60%;border:1px solid gray; cursor: pointer;" class="img-profile rounded" src="../assets/img/blank_profile21.jpg" alt="profile">
                                        <?php } ?>

                                    </div>
                                </center>
                                <!-- Hidden file input for selecting the image -->
                                <input type="file" id="imageUpload" name="image" accept="image/*" style="display: none;" />


                            </div>
                            <div class="col-12 col-md-8" >
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
                                <div class="col-12 row mt-3">
                                    <label class="col-4" for="user_type">User Type <span class="text-danger">*</span></label>
                                    <select name="user_type" id="user_type" class="form-control col-8" name="user_type" required>
                                        <option value="admin" <?php echo ($user['user_type'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                        <option value="user" <?php echo ($user['user_type'] == 'user') ? 'selected' : ''; ?>>User</option>
                                    </select>
                                </div>
                                <div class="col-12 row mt-3">
                                    <label class="col-4" for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control col-8" name="status" id="status" required>
                                        <option value="active" <?= ($user['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?= ($user['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
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



    <!-- Modal Change Password -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">ប្តូរពាក្យសម្ងាត់</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="" method="POST" onsubmit="return checkPasswordMatch();">

                        <!-- New Password -->
                        <div class="form-group">
                            <label for="new_password">ពាក្យសម្ងាត់ថ្មី <span class="text-danger">*</span></label>
                            <div class="d-flex justify-content-between">
                                <input class="form-control" type="password" id="new_password" name="new_password" required>
                                <button type="button" class="show-password btn btn-sm" onclick="togglePasswordVisibility('new_password', 'togglePasswordIcon')">
                                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="confirm_password">បញ្ជាក់ពាក្យសម្ងាត់ <span class="text-danger">*</span></label>
                            <div class="d-flex justify-content-between">
                                <input class="form-control" type="password" id="confirm_password" name="confirm_password" required>
                                <button type="button" class="show-password-confirm btn btn-sm" onclick="togglePasswordVisibility('confirm_password', 'togglePasswordIconConfirm')">
                                    <i class="fas fa-eye" id="togglePasswordIconConfirm"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Error message displayed here -->
                        <small id="passwordError" class="form-text text-danger" style="display: none;">ពាក្យសម្ងាត់មិនត្រូវគ្នាទេ, សូមពិនិត្យម្តងទៀត!</small>
                        <!-- Submit Button -->
                        <div class="col-12" style="text-align: right;">
                            <button class="btn btn-success  mt-3" type="submit" name="change_password">
                                <i class="fa fa-check-circle" aria-hidden="true"></i> យល់ព្រម
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>


    <!-- auto close messgae -->
    <script src="../assets/js/auto_close_alert.js"></script>

    <!-- show password -->
    <style>
        .show-password {
            position: absolute;
            top: 70px;
            right: 25px;
            /* Adjust to fit within your input field */
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #495057;
            font-size: 20px;
            cursor: pointer;
        }

        .show-password-confirm {
            position: absolute;
            top: 155px;
            right: 25px;
            /* Adjust to fit within your input field */
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #495057;
            font-size: 20px;
            cursor: pointer;
        }

        .show-password .hidden {
            display: none;
        }
    </style>


    <script>
        // Toggle password visibility for any password input field
        function togglePasswordVisibility(inputId, iconId) {
            var passwordInput = document.getElementById(inputId);
            var toggleIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Check if the new password and confirm password fields match
        function checkPasswordMatch() {
            var newPassword = document.getElementById('new_password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            var errorMessage = document.getElementById('passwordError');

            // Check if passwords match
            if (newPassword !== confirmPassword) {
                errorMessage.style.display = 'block'; // Show error message
                return false;
            } else {
                errorMessage.style.display = 'none'; // Hide error message
                return true;
            }
        }
    </script>

    <!-- click to change image profile -->
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