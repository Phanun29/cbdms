<?php
include "../inc/script_header.php";
$user_type = $fetch_info['user_type'];
if ($user_type == "user") {
    header("Location: 404.php");
    exit();
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $columnName = $_POST['column_name'];
    $dataType = $_POST['data_type'];
    $nullable = $_POST['nullable'] == 'YES' ? 'NULL' : 'NOT NULL';
    $default = !empty($_POST['default_value']) ? "DEFAULT '{$_POST['default_value']}'" : '';

    $sql = "ALTER TABLE tbl_corn_breeding_data ADD COLUMN $columnName $dataType $nullable $default";

    if ($conn->query($sql) === TRUE) {
        echo "Column added successfully!";
        header("location: column_tbl_cbd.php");
        exit();
    } else {
        echo "Error adding column: " . $conn->error;
    }

    // $conn->close();
}

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
                            <a class="btn btn-secondary" href="javascript:history.back()"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ថយក្រោយ</a>


                        </div>
                        <form method="POST" class="row" enctype="multipart/form-data">
                            <div class="card-body">
                                <label for="last_name" class="col-12">Column Name:</label>
                                <input class="form-control" type="text" name="column_name" value="" required>

                                <label class="label-form col-12" for="data_type">Data Type</label>
                                <input class="form-control" type="text" name="data_type" value="" required>

                                <label class="col-12" for="first_name">Nullable</label>
                                <select class="form-control" name="nullable">
                                    <option value="YES">Yes</option>
                                    <option value="NO">No</option>
                                </select>


                                <label class="col-12" for="username"> Default Value:</label>
                                <input class="form-control" type="text" name="default_value" value="">



                                <button type="submit" class="btn btn-success mt-2"><i class="fa fa-check-circle" aria-hidden="true"></i> រក្សាទុក</button>

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





</body>

</html>