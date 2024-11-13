<?php include "../inc/script_header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <?php include "../inc/head.php"; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>

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

                            <form action="" id="filterForm" method="GET" class="row">

                                <div class="col-12 col-md-2 mt-2">
                                    <div class="col-12 pb-3">
                                        <button class="btn btn-success" onclick="exportToExcel()">
                                            <i class="fas fa-file-export"></i>&nbsp;Export
                                        </button>

                                    </div>

                                </div>


                                <div class="row col-12 col-md-8 mt-2">
                                    <div class="col-5">
                                        <select name="filterPooch1" id="filterPooch1" class="form-control">
                                            <option value="" disabled selected>--ពូជទី១--</option>
                                            <?php
                                            // Fetch corn varieties only once
                                            $query_corn_varieties = "SELECT * FROM tbl_corn_varieties";
                                            $result = $conn->query($query_corn_varieties);
                                            if ($result->num_rows > 0) {
                                                // Store corn varieties in an array for reuse
                                                $corn_varieties_array = [];
                                                while ($row = $result->fetch_assoc()) {
                                                    $corn_varieties_array[] = $row;
                                                }
                                                // Populate the first dropdown
                                                foreach ($corn_varieties_array as $corn_varieties) {
                                                    $selected = (isset($_GET['filterPooch1']) && $_GET['filterPooch1'] == $corn_varieties['id']) ? "selected" : "";
                                                    echo "<option value='{$corn_varieties['id']}' $selected>{$corn_varieties['corn_varieties_name']}</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-5">
                                        <select name="filterPooch2" id="filterPooch2" class="form-control">
                                            <option value="" disabled selected>--ពូជទី២--</option>
                                            <?php
                                            // Populate the second dropdown from the same array
                                            if (!empty($corn_varieties_array)) {
                                                foreach ($corn_varieties_array as $corn_varieties) {
                                                    $selected = (isset($_GET['filterPooch2']) && $_GET['filterPooch2'] == $corn_varieties['id']) ? "selected" : "";
                                                    echo "<option value='{$corn_varieties['id']}' $selected>{$corn_varieties['corn_varieties_name']}</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-2">

                                        <select name="filterJumnan" id="filterJumnan" class="form-control">
                                            <option value="" disabled selected>--ជំនាន់--</option>
                                            <script>
                                                const selectedVersion = "<?php echo $_GET['filterJumnan'] ?? ''; ?>";
                                            </script>
                                        </select>

                                        <script>
                                            document.getElementById('filterPooch1').addEventListener('change', fetchVersions);
                                            document.getElementById('filterPooch2').addEventListener('change', fetchVersions);

                                            function fetchVersions() {
                                                const pooch1 = document.getElementById('filterPooch1').value;
                                                const pooch2 = document.getElementById('filterPooch2').value;

                                                if (pooch1 && pooch2) {
                                                    fetch(`fetch_versions.php?pooch1=${pooch1}&pooch2=${pooch2}`)
                                                        .then(response => {
                                                            if (!response.ok) throw new Error('Network response was not ok');
                                                            return response.json();
                                                        })
                                                        .then(data => {
                                                            const filterJumnan = document.getElementById('filterJumnan');
                                                            filterJumnan.innerHTML = '<option value="" selected>--ជំនាន់--</option>';

                                                            data.forEach(version => {
                                                                const option = document.createElement('option');
                                                                option.value = version;
                                                                option.textContent = version;

                                                                // Select the previously chosen version if it matches
                                                                if (version === selectedVersion) {
                                                                    option.selected = true;
                                                                }

                                                                filterJumnan.appendChild(option);
                                                            });
                                                        })
                                                        .catch(error => console.error('Error fetching versions:', error));
                                                }
                                            }

                                            document.addEventListener("DOMContentLoaded", function() {
                                                const pooch1 = document.getElementById('filterPooch1').value;
                                                const pooch2 = document.getElementById('filterPooch2').value;
                                                if (pooch1 && pooch2) {
                                                    fetchVersions();
                                                }
                                            });
                                        </script>



                                        <!-- <input type="text" name="filterJumnan" id="filterJumnan" class="form-control" placeholder="ជំនាន់" value="<?php echo isset($_GET['filterJumnan']) ? $_GET['filterJumnan'] : ''; ?>"> -->
                                    </div>
                                </div>

                                <div class="col-12 col-md-2 mt-2">

                                    <button type="submit" class="btn btn-primary" id="filterBtn"><i class="fas fa-search"></i> ស្វែងរក</button>
                                    <a href="list_corn_breeding_data.php" class="btn btn-danger"><i class="fa-solid fa-rotate-right"></i> សម្អាត</a>
                                </div>

                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <?php
                                include 'functions.php';

                                // Get columns from the users table
                                $columns = getUserColumns($conn);
                                // Get filter values from the form
                                $first_corn_variety = $_GET['filterPooch1'] ?? '';
                                $second_corn_variety = $_GET['filterPooch2'] ?? '';
                                $version = $_GET['filterJumnan'] ?? '';
                                // Define a query with a JOIN to include corn variety name
                                $sql = "SELECT t.*,   
                                cv1.corn_varieties_name AS first_corn_variety_name, 
                                cv2.corn_varieties_name AS second_corn_variety_name
                                FROM tbl_corn_breeding_data t
                                LEFT JOIN tbl_corn_varieties cv1 ON t.first_variety_name = cv1.id
                                LEFT JOIN tbl_corn_varieties cv2 ON t.second_variety_name = cv2.id
                                WHERE 1=1";

                                // Add filters to the query if they are set
                                if (!empty($first_corn_variety)) {
                                    $sql .= " AND t.first_variety_name = '" . $conn->real_escape_string($first_corn_variety) . "'";
                                }
                                if (!empty($second_corn_variety)) {
                                    $sql .= " AND t.second_variety_name = '" . $conn->real_escape_string($second_corn_variety) . "'";
                                }

                                if (!empty($version)) {
                                    $sql .= " AND version = '" . $conn->real_escape_string($version) . "'";
                                }

                                $sql .= " ORDER  BY cbd_id DESC";
                                $result = $conn->query($sql);

                                ?>

                                <table class='table table-bordered text-nowrap' id='dataTable' width='100%' cellspacing='0'>
                                    <thead>
                                        <tr>
                                            <?php
                                            // Display table headers with numbering

                                            echo "<th>#</th>";
                                            foreach ($columns as $column) {
                                                if ($column != 'cbd_id' && $column != 'name_of_cut_corn_variety' && $column != 'users_id') {  // Skip cbd_id column
                                                    // Check and display First Corn Variety
                                                    if ($column == 'first_variety_name') {
                                                        $firstVariety = $user['first_variety_name'] ?? 'N/A'; // Fallback to 'N/A' if NULL
                                                        echo "<th class='col-6'>ពូជទី១</th>";

                                                        // Check and display Second Corn Variety
                                                    } elseif ($column == 'second_variety_name') {
                                                        $secondVariety = $user['second_variety_name'] ?? 'N/A'; // Fallback to 'N/A' if NULL
                                                        echo "<th class='col-6'>ពូជទី២</th>";
                                                        // Display other columns with fallback if NULL
                                                    } else {
                                                        echo "<th>" . ucfirst($column) . "</th>";
                                                    }
                                                    if ($column == 'male_flowering_day') {
                                                        break;
                                                    }
                                                }
                                            }
                                            echo "<th>Actions</th>";

                                            ?>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        // Display table data
                                        $rowNumber = 1;
                                        while ($row = $result->fetch_assoc()) {


                                            echo "<tr id='user-" . $row['cbd_id'] . "'>";
                                            echo "<td>" . $rowNumber++ . "</td>";  // Display and increment row number

                                            foreach ($columns as $column) {
                                                // Skip cbd_id, name_of_cut_corn_variety, and users_id columns
                                                if ($column == 'cbd_id' || $column == 'name_of_cut_corn_variety' || $column == 'users_id') {
                                                    continue;
                                                }

                                                if ($column == 'first_variety_name') {
                                                    // Display corn_varieties_name instead of the ID for first_corn_variety
                                                    echo "<td>" . htmlspecialchars($row['first_corn_variety_name']) . "</td>";
                                                } elseif ($column == 'second_variety_name') {
                                                    // Display corn_varieties_name instead of the ID for second_corn_variety
                                                    echo "<td>" . htmlspecialchars($row['second_corn_variety_name']) . "</td>";
                                                } else {
                                                    if ($column == 'flowering_age_gap') {
                                                        break;
                                                    }
                                                    echo "<td>" . htmlspecialchars($row[$column]) . "</td>";
                                                }
                                            }

                                            echo "<td align='center'>
                                                <button type='button' class='btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon' data-toggle='dropdown'>
                                                    Action
                                                    <span class='sr-only'>Toggle Dropdown</span>
                                                </button>
                                                <div class='dropdown-menu' role='menu'>
                                                    <a class='dropdown-item' href='view_corn_breeding_data.php?id={$row['cbd_id']}'>
                                                        <span class='fa fa-eye text-dark'></span> លម្អិត
                                                    </a>
                                                    <div class='dropdown-divider'></div>
                                                    <a class='dropdown-item' href='edit_corn_breeding_data.php?id={$row['cbd_id']}'>
                                                        <span class='fa fa-edit text-primary'></span> កែ
                                                    </a>
                                                    <div class='dropdown-divider'></div>
                                                    <button data-id='" . $row['cbd_id'] . "' class='dropdown-item  delete-btn'><span class='fa-solid fa-trash  text-danger'></span> លុប</button>
                                                </div>
                                                </td>";
                                            echo "</tr>";
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

    <!-- Include jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <!-- Include Select2 JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

    <!-- <script>
        // Initialize Select2 on the dropdown
        $(document).ready(function() {
            $('#filterPooch2').select2({
                placeholder: "--ពូជទី២--",
                allowClear: true
            });
        });
        $(document).ready(function() {
            $('#filterPooch1').select2({
                placeholder: "--ពូជទី២--",
                allowClear: true
            });
        });
    </script> -->

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

    <!-- sweet alert -->

    <script src="../assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>

    <!-- delete corn breeding data -->
    <script src="../assets/js/deletecCBD.js"></script>

    <!-- auto close session -->
    <script src="../assets/js/auto_close_alert.js"></script>

    <!-- export excel -->
    <script src="../assets/js/ExportExcel.js"></script>


    <!-- if not select or input when filter -->
    <script>
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            // Get filter values
            var filterPooch1 = document.getElementById('filterPooch1').value;
            var filterPooch2 = document.getElementById('filterPooch2').value;
            var filterJumnan = document.getElementById('filterJumnan').value;

            // Check if all filters are empty
            if (filterPooch1 === "" && filterPooch2 === "" && filterJumnan === "") {
                // Prevent form submission if no filters are applied
                e.preventDefault();
                //  alert("Please select or enter at least one filter before submitting.");
            }
        });
    </script>




</body>

</html>