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


                                <script>
                                    // Graph 1 (with two values)
                                    var ctx1 = document.getElementById('combinedChart').getContext('2d');
                                    //  combinedChart = new Chart(ctx, {
                                    var chart1 = new Chart(ctx1, {
                                        type: 'bar',
                                        data: {
                                            labels: ['កម្ពស់ផ្លែ (ជាមធ្យម)', 'កម្ពស់ដើម​ (ជាមធ្យម)', 'ថ្ងៃចេញផ្កាញី​ ៥០% (ជាមធ្យម)', 'ថ្ងៃចេញផ្កាឈ្មោល​ ៥០% (ជាមធ្យម)'],
                                            datasets: [{
                                                label: '',
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                data: [0, 0, 0, 0]

                                            }, {
                                                label: '',
                                                backgroundColor: 'rgba(15, 12, 92, 0.32)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                data: [0, 0, 0, 0]
                                            }]

                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        },
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                                labels: {
                                                    font: {
                                                        size: 16, // Font size for legend
                                                        family: "'Khmer OS Battambang','Arial', sans-serif", // Font family for legend
                                                        weight: 'bold' // Font weight for legend
                                                    }
                                                }
                                            },
                                            title: {
                                                display: true,
                                                text: 'Comparison of Breeds and Versions for Different Metrics',
                                                font: {
                                                    size: 18, // Font size for title
                                                    family: "'Khmer OS Battambang','Arial', sans-serif", // Font family for title
                                                    weight: 'bold', // Font weight for title
                                                    style: 'italic' // Font style for title
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
            let averageFruitHeight1 = null;
            let averageFruitHeight2 = null;
            let averageStemHeight1 = null;
            let averageStemHeight2 = null;
            let averageMaleFloweringDay1 = null;
            let averageMaleFloweringDay2 = null;
            let averageFlowerDay1 = null;
            let averageFlowerDay2 = null;

            let combinedChart;

            $("#applyFiltersBtn").click(function() {
                var filterBreed1A = $("#filterBreedA1").val();
                var filterBreed1B = $("#filterBreedB1").val();
                var version1 = $("#version1").val();

                var filterBreed2A = $("#filterBreedA2").val();
                var filterBreedB2 = $("#filterBreedB2").val();
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
                            updateCombinedChart(
                                filterBreed1A + " & " + filterBreed1B + " (v" + version1 + ")",
                                filterBreed2A + " & " + filterBreedB2 + " (v" + version2 + ")"
                            );
                        },
                        error: function(xhr, status, error) {
                            console.error("Error occurred while fetching data for Table 1:", error);
                        }
                    });
                }

                // Ajax request for table 2
                if (filterBreed2A || filterBreedB2 || version2) {
                    $.ajax({
                        type: "POST",
                        url: "retrieveData.php",
                        data: {
                            filterBreedA: filterBreed2A,
                            filterBreedB: filterBreedB2,
                            version: version2
                        },
                        success: function(response) {
                            $("#tableBody2").html(response.tableHtml);
                            averageFruitHeight2 = parseFloat(response.averageFruitHeight);
                            averageStemHeight2 = parseFloat(response.averageStemHeight);
                            averageMaleFloweringDay2 = parseFloat(response.averageMaleFloweringDay);
                            averageFlowerDay2 = parseFloat(response.averageFlowerDay);
                            updateCombinedChart(
                                filterBreed1A + " & " + filterBreed1B + " (v" + version1 + ")",
                                filterBreed2A + " & " + filterBreedB2 + " (v" + version2 + ")"
                            );
                        },
                        error: function(xhr, status, error) {
                            console.error("Error occurred while fetching data for Table 2:", error);
                        }
                    });
                }
            });

            function updateCombinedChart(label1, label2) {

                var labels = ['កម្ពស់ផ្លែ (ជាមធ្យម)', 'កម្ពស់ដើម​ (ជាមធ្យម)', 'ថ្ងៃចេញផ្កាញី​ ៥០% (ជាមធ្យម)', 'ថ្ងៃចេញផ្កាឈ្មោល​ ៥០% (ជាមធ្យម)'];

                var data = {
                    labels: labels,
                    datasets: [{
                            label: label1 || 'Breed 1', // Dynamically set based on selected Breed 1 and version
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            data: [
                                averageFruitHeight1 || 0,
                                averageStemHeight1 || 0,
                                averageMaleFloweringDay1 || 0,
                                averageFlowerDay1 || 0
                            ]
                        },
                        {
                            label: label2 || 'Breed 2', // Dynamically set based on selected Breed 2 and version
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            data: [
                                averageFruitHeight2 || 0,
                                averageStemHeight2 || 0,
                                averageMaleFloweringDay2 || 0,
                                averageFlowerDay2 || 0
                            ]
                        }
                    ]
                };

                // Check if the chart already exists
                if (combinedChart) {
                    combinedChart.data.datasets = data.datasets; // Update the data for all datasets
                    combinedChart.update(); // Update the chart
                } else {
                    var ctx = document.getElementById('combinedChart').getContext('2d');
                    combinedChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    font: {
                                        size: 14 // Font size for y-axis labels
                                    }
                                }
                            },
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        font: {
                                            size: 16, // Font size for legend
                                            family: "'Noto Serif Khmer', sans-serif", // Khmer font for legend
                                            weight: 'bold'
                                        }
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Comparison of Breeds and Versions for Different Metrics',
                                    font: {
                                        size: 18, // Font size for title
                                        family: "'Noto Serif Khmer', sans-serif", // Khmer font for title
                                        weight: 'bold'
                                    }
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