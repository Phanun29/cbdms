<?php
include "../inc/script_header.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $first_name = $_POST['first_name'] ?? null;
    $last_name = $_POST['last_name'] ?? null;
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $email = $_POST['email'] ?? null;
    $phone_number = $_POST['phone_number'] ?? null;
    $user_type = $_POST['user_type'];
    $status = $_POST['status'];


    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $image_name = time() . '_' . basename($image['name']); // Create a unique name for the image
        $unique_name = uniqid() . '.' . $image_name;
        $upload_dir = '../uploads/'; // Set the upload directory
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
        $image_path = null; // Handle if no image is uploaded
    }

    // SQL query to insert the user data including the image path
    $sql = "INSERT INTO tbl_users (first_name, last_name, username, password, email, phone_number, image, status, user_type) 
            VALUES ('$first_name', '$last_name', '$username', '$password', '$email', '$phone_number', '$image_path', '$status', '$user_type')";

    if ($conn->query($sql) === true) {
        $_SESSION['success_message_user'] = "បន្ថែមអ្នកប្រើប្រាស់បានជោគជ័យ.";
        header('Location: list_users.php');
        exit();
    } else {
        $_SESSION['error_message_user'] = "Error updating user: " . $conn->error;
    }

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

                    <!-- 404 Error Text -->
                    <div class="text-center">
                        <div class="error mx-auto" data-text="404">404</div>
                        <p class="lead text-gray-800 mb-5">Page Not Found</p>
                        <p class="text-gray-500 mb-0">It looks like you found a glitch</p>
                        <a href="index.php">&larr; Back to Dashboard</a>
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

    <!-- show password -->
    <script src="../assets/js/showPassword.js">
    </script>


</body>

</html>