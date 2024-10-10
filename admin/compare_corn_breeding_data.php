<?php include "../inc/script_header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 100%;
            /* margin: 20px auto; */
        }
    </style>
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
                                            <!-- Three inputs for Name, Gender, and Age filtering -->
                                            <select id="filterPooch1" class="form-control" onchange="filterTable()">
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


                                            <select id="filterPooch2" class="form-control" onchange="filterTable()">

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


                                    </form>
                                </div>
                                <div class="col-12 col-md-6">
                                    <form action="" class="row">
                                        <div class="col-3">
                                            <!-- Three inputs for Name, Gender, and Age filtering -->
                                            <select id="filterPooch1" class="form-control" onchange="filterTable()">

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


                                            <select id="filterPooch2" class="form-control" onchange="filterTable()">

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
                            <div class="row ">
                                <!-- Graph 1 with two values -->
                                <div class="chart-container col-12 col-md-6">
                                    <canvas id="chart1"></canvas>
                                </div>

                                <!-- Graph 2 -->
                                <div class="chart-container col-12 col-md-6">
                                    <canvas id="chart2"></canvas>
                                </div>

                                <!-- Graph 3 -->
                                <div class="chart-container col-12 col-md-6">
                                    <canvas id="chart3"></canvas>
                                </div>

                                <!-- Graph 4 -->
                                <div class="chart-container col-12 col-md-6">
                                    <canvas id="chart4"></canvas>
                                </div>

                                <script>
                                    // Graph 1 (with two values)
                                    var ctx1 = document.getElementById('chart1').getContext('2d');
                                    var chart1 = new Chart(ctx1, {
                                        type: 'bar',
                                        data: {
                                            labels: ['Label 1', 'Label 2'],
                                            datasets: [{
                                                label: 'កម្ពស់ផ្លែ',
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                data: [12, 19, 3]
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });

                                    // Graph 2
                                    var ctx2 = document.getElementById('chart2').getContext('2d');
                                    var chart2 = new Chart(ctx2, {
                                        type: 'bar',
                                        data: {
                                            labels: ['January', 'February'],
                                            datasets: [{
                                                label: 'កម្ពស់ដើម',
                                                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                                borderColor: 'rgba(255, 159, 64, 1)',
                                                data: [10, 20, 30]
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });

                                    // Graph 3
                                    var ctx3 = document.getElementById('chart3').getContext('2d');
                                    var chart3 = new Chart(ctx3, {
                                        type: 'bar',
                                        data: {
                                            labels: ['Red', 'Blue', ],
                                            datasets: [{
                                                label: 'ថ្ងៃចេញផ្កាញី​ ៥០%',
                                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                                borderColor: 'rgba(255, 99, 132, 1)',
                                                data: [12, 19, 7]
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });

                                    // Graph 4
                                    var ctx4 = document.getElementById('chart4').getContext('2d');
                                    var chart4 = new Chart(ctx4, {
                                        type: 'bar',
                                        data: {
                                            labels: ['Green', 'Purple'],
                                            datasets: [{
                                                label: 'ថ្ងៃចេញផ្កាឈ្មោល​ ៥០%',
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                data: [8, 15, 10]
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                </script>

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




</body>

</html>