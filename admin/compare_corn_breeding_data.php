<?php include "../inc/script_header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="../assets/vendor/chart.js/Chart.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Khmer&display=swap" rel="stylesheet">

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
                                    <form action="" class="row">
                                        <div class="col-3">
                                            <select id="filterBreedA1" class="form-control">
                                                <option value="" disabled selected>--ជ្រើសរើស--</option>
                                                <?php
                                                $query_corn_varieties = "SELECT * FROM tbl_corn_varieties";
                                                $result = $conn->query($query_corn_varieties);

                                                if ($result->num_rows > 0) {
                                                    while ($corn_varieties = $result->fetch_assoc()) {
                                                        echo "<option value='{$corn_varieties['corn_varieties_name']}'>{$corn_varieties['corn_varieties_name']}</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <select id="filterBreedB1" class="form-control">
                                                <option value="" disabled selected>--ជ្រើសរើស--</option>
                                                <?php
                                                $query_corn_varieties = "SELECT * FROM tbl_corn_varieties";
                                                $result = $conn->query($query_corn_varieties);

                                                if ($result->num_rows > 0) {
                                                    while ($corn_varieties = $result->fetch_assoc()) {
                                                        echo "<option value='{$corn_varieties['corn_varieties_name']}'>{$corn_varieties['corn_varieties_name']}</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" id="version1" class="form-control" placeholder="ជំនាន់">
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 col-md-6 row">
                                    <form action="" class="row">
                                        <div class="col-3">
                                            <select id="filterBreedA2" class="form-control">
                                                <option value="" disabled selected>--ជ្រើសរើស--</option>
                                                <?php
                                                $query_corn_varieties = "SELECT * FROM tbl_corn_varieties";
                                                $result = $conn->query($query_corn_varieties);

                                                if ($result->num_rows > 0) {
                                                    while ($corn_varieties = $result->fetch_assoc()) {
                                                        echo "<option value='{$corn_varieties['corn_varieties_name']}'>{$corn_varieties['corn_varieties_name']}</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <select id="filterBreedB2" class="form-control">
                                                <option value="" disabled selected>--ជ្រើសរើស--</option>
                                                <?php
                                                $query_corn_varieties = "SELECT * FROM tbl_corn_varieties";
                                                $result = $conn->query($query_corn_varieties);

                                                if ($result->num_rows > 0) {
                                                    while ($corn_varieties = $result->fetch_assoc()) {
                                                        echo "<option value='{$corn_varieties['corn_varieties_name']}'>{$corn_varieties['corn_varieties_name']}</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" id="version2" class="form-control" placeholder="ជំនាន់">
                                        </div>
                                        <div class="col-3">
                                            <button id="applyFiltersBtn" class="btn btn-primary" type="button">ប្រៀបធៀប</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row ">
                                <canvas id="combinedChart"></canvas>

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

    <!-- Chart  -->
    <script src="../assets/js/Chart_Filter.js"></script>

    <!-- Updtae Chart Filter -->
    <script src="../assets/js/UpdateChartFilter.js"></script>


</body>

</html>