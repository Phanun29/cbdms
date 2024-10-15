<?php
include "../inc/script_header.php";
$user_type = $fetch_info['user_type'];
if ($user_type == "user") {
    header("Location: 404.php");
    exit();
}
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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">បន្ថែមអ្នកប្រើប្រាស់</h1>

                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">

                            <a class="btn btn-secondary" href="javascript:history.back()"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ថយក្រោយ</a>
                        </div>
                        <form method="POST" enctype="multipart/form-data" class="mt-3 row">
                            <div class="col-12 col-md-4">
                                <div class="" style="width: 100%;">
                                    <center>
                                        <!-- Image element that will be clicked to select a new image -->

                                        <img id="profileImage" style="object-fit: cover; width:60%;border:1px solid gray; cursor: pointer;" class="img-profile rounded" src="../assets/img/blank_profile21.jpg" alt="profile">



                                    </center>
                                </div>

                                <!-- Hidden file input for selecting the image -->
                                <input type="file" id="imageUpload" name="image" accept="image/*" style="display: none;" />

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
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="col-12 row mt-3">
                                    <label class="col-4" for="last_name">នាមត្រកូល</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control col-8" placeholder="">
                                </div>
                                <div class="col-12 row mt-3">
                                    <label class="col-4" for="first_name">នាមខ្លួន</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control col-8" placeholder="">
                                </div>

                                <div class="col-12 row mt-3">
                                    <label class="col-4" for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="username" class="form-control col-8" placeholder="" required>
                                </div>
                                <div class="col-12 row mt-3">
                                    <label class="col-4" for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control col-8" id="password"
                                        placeholder="" required>
                                    <button type="button" class="show-password btn-sm " onclick="togglePasswordVisibility()"
                                        id="showPasswordButton">
                                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                <div class="col-12 row mt-3">
                                    <label class="col-4" for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control col-8" placeholder="">
                                </div>
                                <div class="col-12 row mt-3">
                                    <label class="col-4" for="phone_number">Phone Number</label>
                                    <input type="text" name="phone_number" id="phone_number" class="form-control col-8" placeholder="">
                                </div>
                                <div class="col-12 row mt-3">
                                    <label class="col-4" for="user_type">User Type <span class="text-danger">*</span></label>
                                    <select class="form-control col-8" name="user_type" id="user_type" required>
                                        <option value="">--Select--</option>
                                        <option value="admin">admin</option>
                                        <option value="user">user</option>
                                    </select required>
                                </div>
                                <div class="col-12 row mt-3">
                                    <label class="col-4" for="status">Status<span class="text-danger">*</span></label>
                                    <select class="form-control col-8" name="status" id="status" required>
                                        <option value="">--Select--</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select required>
                                </div>

                                <div class="col-12 my-3" style="text-align: end;">
                                    <button class="btn btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i> រក្សាទុក</button>
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

    <!-- show password -->
    <script src="../assets/js/showPassword.js">
    </script>


</body>

</html>