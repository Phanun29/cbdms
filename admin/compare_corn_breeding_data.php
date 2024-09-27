
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
                        <h1 class="h3 mb-0 text-gray-800">ប្រៀបធៀបពូជពោត</h1>

                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4 overflow-hidden">
                       
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
                                            <!-- Three inputs for Name, Gender, and Age filtering -->
                                            <select id="filterPooch1" class="form-control" onchange="filterTable()">

                                                <option value="">--Select--</option>

                                                <option value="Pumpoy">Pumpoy</option>
                                                <option value="Violet">Violet</option>
                                                <option value="Namvang">Namvang</option>
                                                <option value="Samly">Samly</option>
                                                <option value="Bigwhith">Bigwhith</option>
                                                <option value="8 Pew">8 Pew</option>
                                            </select>


                                        </div>
                                        <div class="col-3">


                                            <select id="filterPooch2" class="form-control" onchange="filterTable()">

                                                <option value="">--Select--</option>
                                                <option value="Pumpoy">Pumpoy</option>
                                                <option value="Violet">Violet</option>
                                                <option value="Namvang">Namvang</option>
                                                <option value="Samly">Samly</option>
                                                <option value="Bigwhith">Bigwhith</option>
                                                <option value="8 Pew">8 Pew</option>
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
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Pumpoy</td>
                                            <td>Violet</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>2</td>
                                            <td align="center">
                                                <button type="button"
                                                    class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                    Action
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item" href="view_data_breeding.html"
                                                        data-id=""><span class="fa fa-eye text-dark"></span> View</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="edit_date_breeding.html"
                                                        data-id=""><span class="fa fa-edit text-primary"></span>
                                                        Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item delete_data" href="" data-id=""><span
                                                            class="fa fa-trash text-danger"></span> Delete</a>
                                                </div>
                                            </td>
                                        </tr>


                                        <!-- Add more rows here -->
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


</body>

</html>