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
                                <div class="col-12 col-md-6">
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
                                            <button id="applyFiltersBtn" class="btn btn-primary" type="button">   <i class="fa-solid fa-code-compare"></i> ប្រៀបធៀប</button>
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
                                            labels: ['ពូជទី១', 'ពូជទី២'],
                                            datasets: [{
                                                label: 'កម្ពស់ផ្លែ',
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                data: [0, 0]
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
                                            labels: ['ពូជទី១', 'ពូជទី២'],
                                            datasets: [{
                                                label: 'កម្ពស់ដើម',
                                                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                                borderColor: 'rgba(255, 159, 64, 1)',
                                                data: [0, 0]
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
                                            labels: ['ពូជទី១', 'ពូជទី២', ],
                                            datasets: [{
                                                label: 'ថ្ងៃចេញផ្កាញី​ ៥០%',
                                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                                borderColor: 'rgba(255, 99, 132, 1)',
                                                data: [0, 0]
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
                                            labels: ['ពូជទី១', 'ពូជទី២'],
                                            datasets: [{
                                                label: 'ថ្ងៃចេញផ្កាឈ្មោល​ ៥០%',
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                data: [0, 0]
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





    <!-- data chart -->
    <script>
        $(document).ready(function() {
            // State for averages from the tables
            let averageFruitHeight1 = null;
            let averageFruitHeight2 = null;
            let averageStemHeight1 = null;
            let averageStemHeight2 = null;
            let averageMaleFloweringDay1 = null;
            let averageMaleFloweringDay2 = null;
            let averageFlowerDay1 = null;
            let averageFlowerDay2 = null;

            let chartFruitHeight, chartStemHeight, chartMaleFlowering, chartFlowerDay; // Chart variables

            $("#applyFiltersBtn").click(function() {
                var filterBreed1A = $("#filterBreedA1").val();
                var filterBreed1B = $("#filterBreedB1").val();
                var version1 = $("#version1").val();

                var filterBreed2A = $("#filterBreedA2").val();
                var filterBreed2B = $("#filterBreedB2").val();
                var version2 = $("#version2").val();

                // Ajax request for table 1
                if (filterBreed1A || filterBreed1B || version1) {
                    $.ajax({
                        type: "POST",
                        url: "retrieveData.php",
                        data: {
                            filterBreedA: filterBreed1A,
                            filterBreedB: filterBreed1B,
                            version: version1
                        },
                        success: function(response) {
                            $("#tableBody1").html(response.tableHtml);
                            averageFruitHeight1 = parseFloat(response.averageFruitHeight);
                            averageStemHeight1 = parseFloat(response.averageStemHeight);
                            averageMaleFloweringDay1 = parseFloat(response.averageMaleFloweringDay);
                            averageFlowerDay1 = parseFloat(response.averageFlowerDay);
                            updateCharts(); // Update all charts with new averages from Table 1
                        },
                        error: function(xhr, status, error) {
                            console.error("Error occurred while fetching data for Table 1:", error);
                        }
                    });
                }

                // Ajax request for table 2
                if (filterBreed2A || filterBreed2B || version2) {
                    $.ajax({
                        type: "POST",
                        url: "retrieveData.php",
                        data: {
                            filterBreedA: filterBreed2A,
                            filterBreedB: filterBreed2B,
                            version: version2
                        },
                        success: function(response) {
                            $("#tableBody2").html(response.tableHtml);
                            averageFruitHeight2 = parseFloat(response.averageFruitHeight);
                            averageStemHeight2 = parseFloat(response.averageStemHeight);
                            averageMaleFloweringDay2 = parseFloat(response.averageMaleFloweringDay);
                            averageFlowerDay2 = parseFloat(response.averageFlowerDay);
                            updateCharts(); // Update all charts with new averages from Table 2
                        },
                        error: function(xhr, status, error) {
                            console.error("Error occurred while fetching data for Table 2:", error);
                        }
                    });
                }
            });

            function updateCharts() {
                // Update Fruit Height Chart
                updateChart('chart1', 'Average Fruit Height', [averageFruitHeight1 || 0, averageFruitHeight2 || 0]);

                // Update Stem Height Chart
                updateChart('chart2', 'Average Stem Height', [averageStemHeight1 || 0, averageStemHeight2 || 0]);

                // Update Male Flowering Chart
                updateChart('chart3', 'Average Male Flowering Day', [averageMaleFloweringDay1 || 0, averageMaleFloweringDay2 || 0]);

                // Update Flower Day Chart
                updateChart('chart4', 'Average Flower Day', [averageFlowerDay1 || 0, averageFlowerDay2 || 0]);
            }

            function updateChart(chartId, label, dataValues) {
                const labels = ['ពូជទី១', 'ពូជទី២'];
                const data = {
                    labels: labels,
                    datasets: [{
                        label: label,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        data: dataValues
                    }]
                };

                // Check if the chart already exists
                if (window[chartId]) {
                    window[chartId].data.datasets[0].data = data.datasets[0].data; // Update the data
                    window[chartId].update(); // Update the chart
                } else {
                    var ctx = document.getElementById(chartId).getContext('2d');
                    window[chartId] = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            }
        });
    </script>




</body>

</html>