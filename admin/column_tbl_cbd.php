<?php
include "../inc/script_header.php";
$user_type = $fetch_info['user_type'];
if ($user_type == "user") {
    header("Location: 404.php");
    exit();
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
                        <h1 class="h3 mb-0 text-gray-800">column</h1>
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

                            <a class="btn btn-primary" href="add_column.php"> <i class="fa fa-plus-circle" aria-hidden="true"></i> add column</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Column Name</th>
                                            <th>Data Type</th>
                                            <th>Nullable</th>
                                            <th>Key</th>
                                            <th>Default</th>
                                            <th>Extra</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Display the current columns in the table
                                        $sql = "SHOW COLUMNS FROM tbl_corn_breeding_data";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            $counter = 1;

                                            while ($row = $result->fetch_assoc()) {
                                                if ($row['Field'] != 'cbd_id' && $row['Field'] != 'name_of_cut_corn_variety' && $row['Field'] != 'users_id'&& $row['Field'] != 'first_variety_name'&& $row['Field'] != 'second_variety_name'&& $row['Field'] != 'version') {  // Skip cbd_id column

                                                    echo "<tr>
                                                        <td>" . $counter++ . "</td>
                                                        <td>{$row['Field']}</td>
                                                        <td>{$row['Type']}</td>
                                                        <td>{$row['Null']}</td>
                                                        <td>{$row['Key']}</td>
                                                        <td>{$row['Default']}</td>
                                                        <td>{$row['Extra']}</td>
                                                        <td><a class='btn btn-danger' href='delete_column.php?column={$row['Field']}'>delete</a>
                                                            <a class='btn btn-primary' href='edit_column.php?column={$row['Field']}'>Edit</a>
                                                        </td>
                                                    </tr>";
                                                }
                                            }
                                            echo "</table>";
                                        } else {
                                        }

                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>


                            </div>
                        </div>
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

    <!-- Page level custom scripts -->
    <script src="../assets/js/demo/datatables-demo.js"></script>

    <!-- Page level plugins -->
    <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- auto close messgae -->
    <script src="../assets/js/auto_close_alert.js"></script>

</body>

</html>