<?php include "../inc/script_header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php include "../inc/head.php"; ?>
    <style>
        #dataTable_filter {
            display: none;
        }
    </style>
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
                        <h1 class="h3 mb-0 text-gray-800">បញ្ជីទិន្នន័យបង្កាត់ពូជពោត</h1>
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

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4 overflow-hidden">
                        <div class="card-header py-3">

                            <a class="btn btn-primary" href="add_corn_breeding_data.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> បន្ថែមទិន្នន័យបង្កាត់ពូជពោត</a>
                        </div>
                        <div class="card-header py-3">


                            <div class="row">
                                <div class="col-12 col-md-6 row">
                                    <div class="col-4 pb-3">
                                        <button class="btn btn-secondary">Export</button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <form action="" class="row">
                                        <div class="col-3">
                                        
                                            <select name="" id="filterPooch1" class="form-control" onchange="filterTable()">
                                                <option value="" disabled selected>--ជ្រើសរើស--</option>
                                                <?php
                                                $query_corn_varieties = "SELECT *FROM tbl_corn_varieties";
                                                $result = $conn->query($query_corn_varieties);

                                                if ($result->num_rows > 0) {
                                                    while ($corn_varieties = $result->fetch_assoc()) {
                                                        echo " <option value='{$corn_varieties['corn_varieties_name']}'>{$corn_varieties['corn_varieties_name']} </option>";
                                                    }
                                                }
                                                ?>
                                            </select>


                                        </div>
                                        <div class="col-3">

                                      
                                            <select name="" id="filterPooch2" class="form-control" onchange="filterTable()">
                                                <option value="" disabled selected>--ជ្រើសរើស--</option>
                                                <?php
                                                $query_corn_varieties = "SELECT *FROM tbl_corn_varieties";
                                                $result = $conn->query($query_corn_varieties);

                                                if ($result->num_rows > 0) {
                                                    while ($corn_varieties = $result->fetch_assoc()) {
                                                        echo " <option value='{$corn_varieties['corn_varieties_name']}'>{$corn_varieties['corn_varieties_name']} </option>";
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="col-3">


                                            <input type="text" id="filterJumnan" class="form-control"
                                                onkeyup="filterTable()" placeholder="ជំនាន់">
                                        </div>

                                        <div class="col-3">
                                            <button class="btn btn-primary ">Filter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ពូជទី១</th>
                                            <th>ពូជទី២</th>
                                            <th>ជំនាន់</th>
                                            <th>កម្ពស់ផ្លែ</th>
                                            <th>កម្ពស់ដើម</th>
                                            <th>ថ្ងៃចេញផ្កាញី​ ៥០%</th>
                                            <th>ថ្ងៃចេញផ្កាឈ្មោល​ ៥០%</th>
                                            <th>សកម្មភាព</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $corn_breeding_data_query = "SELECT  *FROM tbl_corn_breeding_data
                                            ORDER BY cbd_id DESC
                                            ";
                                        $cbd_result = $conn->query($corn_breeding_data_query);
                                        $i = 1;
                                        if ($cbd_result->num_rows > 0) {
                                            while ($cbd = $cbd_result->fetch_assoc()) {
                                                echo "<tr class=''  id='user-" . $cbd['cbd_id'] . "'>";
                                                echo "<td class='py-2'>" . $i++ . "</td>";
                                                echo "<td class='py-2'>" . $cbd['first_corn_variety'] . "</td>";
                                                echo "<td class='py-2'>" . $cbd['second_corn_variety'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['version'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['fruit_height'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['stem_height'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['flower_day'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['male_flowering_day'] . "</td>";

                                                echo " <td align='centerz'>
                                                <button type='button'
                                                    class='btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon'
                                                    data-toggle='dropdown'>
                                                    Action
                                                    <span class='sr-only'>Toggle Dropdown</span>
                                                </button>
                                                <div class='dropdown-menu' role='menu'>
                                                    <a class='dropdown-item' href='view_corn_breeding_data.php?id={$cbd['cbd_id']}&name_of_cut_corn_variety={$cbd['name_of_cut_corn_variety']}'
                                                        ><span class='fa fa-eye text-dark'></span> View</a>
                                                    <div class='dropdown-divider'></div>
                                                    <a class='dropdown-item' href='edit_corn_breeding_data.php?id={$cbd['cbd_id']}''
                                                        ><span class='fa fa-edit text-primary'></span>
                                                        Edit</a>
                                                    <div class='dropdown-divider'></div>
                                                    <button data-id='" . $cbd['cbd_id'] . "' class='dropdown-item btn text-danger  delete-btn'><i class='fa-solid fa-trash'></i> លុប</button>
                                                </div>
                                            </td>";

                                                echo "</tr>";
                                            }
                                        } else {
                                            // echo "<tr><td class='text-center' colspan='9'>No corn breeding data found!</td></tr>";
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

    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- delete corn varieties -->
    <script src="../assets/js/deletecCBD.js"></script>

    <!-- auto close session -->
    <script src="../assets/js/auto_close_alert.js"></script>

    <!-- filter -->
    <script>
        function filterTable() {
            let pooch1Select = document.getElementById('filterPooch1').value.toUpperCase();
            let pooch2Select = document.getElementById('filterPooch2').value.toUpperCase();
            let jumnanSelect = document.getElementById('filterJumnan').value.toUpperCase();

            let table = document.getElementById('dataTable');
            let tr = table.getElementsByTagName('tr');
            let noResults = document.getElementById('noResults');
            let noMatchCount = 0;

            for (let i = 1; i < tr.length; i++) {
                let tdPooch1 = tr[i].getElementsByTagName('td')[1]; // ពូជទី១ column
                let tdPooch2 = tr[i].getElementsByTagName('td')[2]; // ពូជទី២ column
                let tdJumnan = tr[i].getElementsByTagName('td')[3]; // ជំនាន់ column

                let pooch1Match = tdPooch1 ? tdPooch1.innerText.toUpperCase().indexOf(pooch1Select) > -1 || pooch1Select === "" : false;
                let pooch2Match = tdPooch2 ? tdPooch2.innerText.toUpperCase().indexOf(pooch2Select) > -1 || pooch2Select === "" : false;
                let jumnanMatch = tdJumnan ? tdJumnan.innerText.toUpperCase().indexOf(jumnanSelect) > -1 || jumnanSelect === "" : false;

                // Show row if all filters match
                if (pooch1Match && pooch2Match && jumnanMatch) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                    noMatchCount++;
                }
            }

            // Show "No results found" if all rows are hidden
            if (noMatchCount === tr.length - 1) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        }
    </script>




</body>

</html>