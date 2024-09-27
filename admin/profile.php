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
    header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $User_id);
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
                        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
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

                    <!-- DataTales  -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a class="btn btn-secondary mb-2" href="index.php"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ថយក្រោយ</a>
                            <a class="btn btn-success mb-2" href="edit_profile.php?id=<?= $user['user_id'] ?>"><i class="fas fa-user-edit    "></i> កែ Profile</a>
                            <button type="button" id="changePasswordBtn" class="btn btn-primary mb-2" data-toggle="modal"
                                data-target="#myModal">
                                <i class="fas fa-lock"></i> ​ប្តូរពាក្យសម្ងាត់
                            </button>
                        </div>
                        <form method="POST" class="row" enctype="multipart/form-data">
                            <div class="col-12 col-md-4">
                                <center>
                                    <div class="" style="width: 80%;">

                                        <!-- Image element that will be clicked to select a new image -->
                                        <?php if ($user['image'] != null) { ?>
                                            <img id="profileImage" style="object-fit: cover; width:60%;border:1px solid gray; cursor: pointer;" class="img-profile rounded mt-3" src="<?= $user['image'] ?>" alt="profile">
                                        <?php } else { ?>
                                            <img id="profileImage" style="object-fit: cover; width:60%;border:1px solid gray; cursor: pointer;" class="img-profile rounded mt-3" src="../assets/img/blank_profile21.jpg" alt="profile">
                                        <?php } ?>


                                    </div>
                                </center>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="col-12 mt-3 row">
                                    <label for="last_name" class="col-4">នាមត្រកូល</label>
                                    <p class="form-control col-8"><?= $user['last_name'] ?></p>
                                </div>
                                <div class="col-12 row ">
                                    <label class="col-4" for="first_name">នាមខ្លួន</label>
                                    <p class="form-control col-8"><?= $user['first_name'] ?></p>
                                </div>
                                <div class="col-12 row ">
                                    <label class="col-4" for="username">Username</label>
                                    <p class="form-control col-8"><?= $user['username'] ?></p>
                                </div>

                                <div class="col-12 row ">
                                    <label class="col-4" for="email">Email</label>
                                    <p class="form-control col-8"><?= $user['email'] ?></p>
                                </div>
                                <div class="col-12 row ">
                                    <label class="col-4" for="phone_number">លេខទូរស័ព្ទ</label>
                                    <p class="form-control col-8"><?= $user['phone_number'] ?></p>
                                </div>
                                <div class="col-12 row ">
                                    <label class="col-4" for="user_type">User Type </label>
                                    <p class="form-control col-8"><?= $user['user_type'] ?></p>

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



</body>

</html>