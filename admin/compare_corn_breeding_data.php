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

                    <!-- DataTales  -->
                    <div class="card shadow mb-4 overflow-hidden">

                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-12 col-md-5 row">

                                    <div class="col-4">
                                        <select id="filterBreedA1" class="form-control">
                                            <option value="" disabled selected>--ជ្រើសរើស--</option>
                                            <?php
                                            $query_corn_varieties = "SELECT * FROM tbl_corn_varieties";
                                            $result = $conn->query($query_corn_varieties);

                                            if ($result->num_rows > 0) {
                                                while ($corn_varieties = $result->fetch_assoc()) {
                                                    echo "<option value='{$corn_varieties['id']}'>{$corn_varieties['corn_varieties_name']}</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <select id="filterBreedB1" class="form-control">
                                            <option value="" disabled selected>--ជ្រើសរើស--</option>
                                            <?php
                                            $query_corn_varieties = "SELECT * FROM tbl_corn_varieties";
                                            $result = $conn->query($query_corn_varieties);

                                            if ($result->num_rows > 0) {
                                                while ($corn_varieties = $result->fetch_assoc()) {
                                                    echo "<option value='{$corn_varieties['id']}'>{$corn_varieties['corn_varieties_name']}</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-4 ">
                                        <select name="version1" id="version1" class="form-control">
                                            <option value="" disabled selected>--ជំនាន់--</option>
                                            <!-- Version options will be dynamically added here -->
                                        </select>
                                        <script>
                                            document.getElementById('filterBreedA1').addEventListener('change', fetchVersions);
                                            document.getElementById('filterBreedB1').addEventListener('change', fetchVersions);

                                            function fetchVersions() {
                                                const pooch1 = document.getElementById('filterBreedA1').value;
                                                const pooch2 = document.getElementById('filterBreedB1').value;

                                                if (pooch1 && pooch2) {
                                                    // Make an AJAX request to fetch versions
                                                    fetch(`fetch_versions.php?pooch1=${pooch1}&pooch2=${pooch2}`)
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            const filterJumnan = document.getElementById('version1');
                                                            filterJumnan.innerHTML = '<option value="" disabled selected>--ជំនាន់--</option>';

                                                            data.forEach(version => {
                                                                const option = document.createElement('option');
                                                                option.value = version;
                                                                option.textContent = version;
                                                                filterJumnan.appendChild(option);
                                                            });
                                                        })
                                                        .catch(error => console.error('Error fetching versions:', error));
                                                }
                                            }
                                        </script>
                                        <!-- <input type="text" id="version1" class="form-control" placeholder="ជំនាន់"> -->
                                    </div>

                                </div>
                                <div class="col-12 col-md-5 row">

                                    <div class="col-4">
                                        <select id="filterBreedA2" class="form-control">
                                            <option value="" disabled selected>--ជ្រើសរើស--</option>
                                            <?php
                                            $query_corn_varieties = "SELECT * FROM tbl_corn_varieties";
                                            $result = $conn->query($query_corn_varieties);

                                            if ($result->num_rows > 0) {
                                                while ($corn_varieties = $result->fetch_assoc()) {
                                                    echo "<option value='{$corn_varieties['id']}'>{$corn_varieties['corn_varieties_name']}</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <select id="filterBreedB2" class="form-control">
                                            <option value="" disabled selected>--ជ្រើសរើស--</option>
                                            <?php
                                            $query_corn_varieties = "SELECT * FROM tbl_corn_varieties";
                                            $result = $conn->query($query_corn_varieties);

                                            if ($result->num_rows > 0) {
                                                while ($corn_varieties = $result->fetch_assoc()) {
                                                    echo "<option value='{$corn_varieties['id']}'>{$corn_varieties['corn_varieties_name']}</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-4">

                                        <select name="version2" id="version2" class="form-control">
                                            <option value="" disabled selected>--ជំនាន់--</option>
                                            <!-- Version options will be dynamically added here -->
                                        </select>
                                        <script>
                                            document.getElementById('filterBreedA2').addEventListener('change', fetchVersions);
                                            document.getElementById('filterBreedB2').addEventListener('change', fetchVersions);

                                            function fetchVersions() {
                                                const pooch1 = document.getElementById('filterBreedA2').value;
                                                const pooch2 = document.getElementById('filterBreedB2').value;

                                                if (pooch1 && pooch2) {
                                                    // Make an AJAX request to fetch versions
                                                    fetch(`fetch_versions.php?pooch1=${pooch1}&pooch2=${pooch2}`)
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            const filterJumnan = document.getElementById('version2');
                                                            filterJumnan.innerHTML = '<option value="" disabled selected>--ជំនាន់--</option>';

                                                            data.forEach(version => {
                                                                const option = document.createElement('option');
                                                                option.value = version;
                                                                option.textContent = version;
                                                                filterJumnan.appendChild(option);
                                                            });
                                                        })
                                                        .catch(error => console.error('Error fetching versions:', error));
                                                }
                                            }
                                        </script>
                                        <!-- <input type="text" id="version2" class="form-control" placeholder="ជំនាន់"> -->
                                    </div>

                                </div>
                                <div class="col-12 col-md-2 ">
                                    <button id="applyFiltersBtn" class="btn btn-primary" type="button">ប្រៀបធៀប</button>
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