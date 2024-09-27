<?php
include "../inc/script_header.php";
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
                        <h1 class="h3 mb-0 text-gray-800">បញ្ជីអ្នកប្រើប្រាស់</h1>
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

                            <a class="btn btn-primary" href="add_users.php"> <i class="fa fa-plus-circle" aria-hidden="true"></i> បន្ថែមអ្នកប្រើប្រាស់</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>នាមត្រកូល</th>
                                            <th>នាមខ្លួន</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>លេខទូរស័ព្ទ</th>
                                            <th>User Type</th>
                                            <th>ស្ថានភាព</th>
                                            <th>សកម្មភាព</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $user_query = "SELECT  *FROM tbl_users
                                                        ORDER BY user_id DESC
                                                        ";
                                        $user_result = $conn->query($user_query);
                                        $i = 1;
                                        if ($user_result->num_rows > 0) {
                                            while ($user = $user_result->fetch_assoc()) {
                                                echo "<tr class=''  id='user-" . $user['user_id'] . "'>";
                                                echo "<td class='py-2'>" . $i++ . "</td>";
                                                echo "<td class='py-2'>" . $user['last_name'] . "</td>";
                                                echo "<td class='py-2'>" . $user['first_name'] . "</td>";
                                                echo "<td class='py-1'>" . $user['username'] . "</td>";
                                                echo "<td class='py-1'>" . $user['email'] . "</td>";
                                                echo "<td class='py-1'>" . $user['phone_number'] . "</td>";
                                                echo "<td class='py-1'>" . $user['user_type'] . "</td>";
                                                echo "<td class='py-1'>" . $user['status'] . "</td>";

                                                echo "<td class='py-1' align='center'>                                   
                                                    <a class='btn text-primary' href='edit_users.php?id={$user['user_id']}' data-id=''>
                                                        <i class='fas fa-user-edit'></i> កែ
                                                    </a>                                                
                                                    </td>";

                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td class='text-center' colspan='7'>No users found!</td></tr>";
                                        }

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

    <!-- Page level plugins -->
    <script src="../assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../assets/js/demo/chart-area-demo.js"></script>
    <script src="../assets/js/demo/chart-pie-demo.js"></script>

    <!-- Page level custom scripts -->
    <script src="../assets/js/demo/datatables-demo.js"></script>

    <!-- Page level plugins -->
    <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- auto close messgae -->
    <script src="../assets/js/auto_close_alert.js"></script>

</body>

</html>