<?php include "../inc/script_header.php"; ?>
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
                        <h1 class="h3 mb-0 text-gray-800">បញ្ជីពូជពោត</h1>
                        <!-- Display session messages if they exist -->
                        <?php
                     

                        // Check if there's a success message in the session
                        if (isset($_SESSION['success_message'])) {
                            echo '<div id="session-message" class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                            // Clear the session message after displaying it
                            unset($_SESSION['success_message']);
                        }
                        ?>
                        <?php
                        // if (isset($_SESSION['success_message_user'])) {
                        //     echo "<div class='alert alert-success alert-dismissible fade show mb-0' role='alert'>
                        //         <strong>{$_SESSION['success_message_user']}</strong>
                        //         <button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='this.parentElement.style.display=\"none\";'>
                        //             <span aria-hidden='true'>&times;</span>
                        //         </button>
                        //     </div>";
                        //     unset($_SESSION['success_message_user']); // Clear the message after displaying
                        // }

                        // if (isset($_SESSION['error_message_user'])) {
                        //     echo "<div class='alert alert-danger alert-dismissible fade show mb-0' role='alert'>
                        //         <strong>{$_SESSION['error_message_user']}</strong>
                        //         <button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='this.parentElement.style.display=\"none\";'>
                        //             <span aria-hidden='true'>&times;</span>
                        //         </button>
                        //     </div>";
                        //     unset($_SESSION['error_message_user']); // Clear the message after displaying
                        // }
                        ?>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">

                            <button type="button" class="btn btn-primary float-end" data-toggle="modal"
                                data-target="#myModal">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                បន្ថែមពូជពោត
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ឈ្មោះពូជពោត</th>
                                            <th>សកម្មភាព</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM tbl_corn_varieties ORDER BY id DESC";
                                        $result = $conn->query($sql);
                                        $i = 1;
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr  id='user-" . $row['id'] . "'>";
                                                echo '<td>' . $i++ . '</td>';
                                                echo '<td>' . $row['corn_varieties_name'] . '</td>';
                                                echo "<th class='p-1'>         
                                                    <button type='button' class='btn text-primary float-start px-4' onclick='openUpdateModal({$row['id']}, \"{$row['corn_varieties_name']}\")' data-id='{$row['id']}'><i class='fa-solid fa-pen-to-square me-1'></i> កែ</button>
                                                     <button data-id='" . $row['id'] . "' class='btn text-danger  delete-btn'><i class='fa-solid fa-trash'></i> លុប</button>
                                                    </td>
                                                ";
                                            }
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

    <!-- add corn varieties -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">បន្ថែមពូជពោត</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal Body -->

                <div class="modal-body">
                    <form id="insertForm">
                        <div class="form-group">
                            <label for="name">ឈ្មោះពូជពោត</label>
                            <input type="text" id="name" name="corn_varieties_name" class="form-control" required>
                        </div>

                        <!--   for success/error message -->
                        <p class="form-text text-danger" id="message"></p>
                        <div style="text-align: end;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">បិទ</button>
                            <button type="button" class="btn btn-success" onclick="insertData()"><i class="fa-solid fa-check-circle"></i> យល់ព្រម</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Updated Modal for Update -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="updateModalLabel">កែពូជពោត</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateForm" onsubmit="updateData(event)">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="updatedName">ឈ្មោះពូជពោត</label>
                            <input type="text" class="form-control" id="updatedName" name="corn_varieties_name" required>
                        </div>
                        <div id="modal-message"></div> <!-- Placeholder for message -->
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="update_id" name="update_id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">បិទ</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i> យល់ព្រម</button>
                    </div>
                </form>
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

    <!-- add corn varieties -->
    <script src="../assets/js/add_corn_varieties.js"></script>
    <!-- edit corn varieties -->
    <script src="../assets/js/edit_corn_varieties.js"></script>

    <!-- auto close messgae -->
    <script src="../assets/js/auto_close_alert.js"></script>

    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- delete corn varieties -->
    <script>
        $(document).ready(function() {
            // Handle delete button click
            $(document).on('click', '.delete-btn', function() {
                var userId = $(this).data('id');
                Swal.fire({
                    title: 'តើអ្នកប្រាកដទេ?',
                    text: 'អ្នក​នឹង​មិន​អាច​ស្តា​ពូជ​ពោត​នេះឡើង​វិញទេ​!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'បាទ លុបវាចោល!',
                    cancelButtonText: 'បោះបង់'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'delete_corn_varieties.php', // Adjust URL to your delete script
                            type: 'POST',
                            data: {
                                id: userId
                            },
                            success: function(response) {
                                console.log('Response:', response); // Debugging: Log the response
                                if (response === 'success') {
                                    console.log('Removing row with ID: #user-' + userId); // Log the row being removed
                                    $('#user-' + userId).remove(); // Remove the row from the table
                                    Swal.fire('បានលុប!', 'ឈ្មោះពូជត្រូវបានលុប.', 'success');
                                } else {
                                    Swal.fire('Error!', 'មានបញ្ហាពេលលុប.', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX Error:', status, error); // Debugging: Log AJAX errors
                                Swal.fire('Error!', 'An error occurred while deleting the user.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>