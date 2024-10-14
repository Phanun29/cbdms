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
                                        <button class="btn btn-secondary" onclick="exportToExcel()"><i class="fas fa-file-export    "></i> Export</button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <form action="" id="filterForm" class="row">
                                        <div class="col-3">
                                            <select name="filterPooch1" id="filterPooch1" class="form-control">
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
                                            <select name="filterPooch2" id="filterPooch2" class="form-control">
                                                <option value="" disabled selected>--ជ្រើសរើស--</option>
                                                <?php
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
                                            <input type="text" id="filterJumnan" class="form-control" placeholder="ជំនាន់">
                                        </div>
                                        <div class="col-3">
                                            <button class="btn btn-primary" id="filterBtn"><i class="fas fa-filter    "></i> Filter</button>
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
                                    <tbody id="cornBreedingData">
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
                                <table
                                    class="table table-bordered text-nowrap"
                                    style="display: none;"
                                    id="tableForExport"
                                    width="100%"
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

                                            <th>គម្លាតអាយុចេញផ្កា</th>
                                            <th>ចំនួនទងផ្កាញី</th>
                                            <th>ចំនួនផ្កាឈ្មោល</th>
                                            <th>អាយុចេញផ្កាឈ្មោល</th>
                                            <th>អាយុចេញផ្កាញី</th>
                                            <th>មុំស្លឹក</th>
                                            <th>ភាពមានកន្ទុយលើចុងផ្លែ</th>
                                            <th>ប្រវែងផ្លែ</th>
                                            <th>ភាពជាប់ផ្លែ</th>
                                            <th>ទំហំដើម</th>
                                            <th>ប្រវែងគល់ផ្លែ</th>
                                            <th>ប្រព័ន្ធឫស</th>
                                            <th>អត្រាដំណុះ</th>
                                            <th>កម្រិតកើត Albino</th>

                                            <th>កម្រិតបំផ្លាញរបស់ដង្កូវ</th>
                                            <th>ភាពរឹងមាំ</th>
                                            <th>គម្លាតអាយុផ្កាញីនិងឈ្មោល</th>
                                            <th>កើតជំងឺ(Seuthern Rast)</th>
                                            <th>អង្កត់ផ្ចិតផ្លែបកសំបក</th>
                                            <th>កម្រិតការកើតជំងឺ</th>
                                            <th>ប្រវែងផ្លែបកសំបក</th>
                                            <th>ចំនួនជួរគ្រាប់ក្នុងមួយផ្លែ</th>
                                            <th>សំបកផ្លែ</th>
                                            <th>ទម្ងន់</th>
                                            <th>ដង្កូវ</th>
                                            <th>ភាពរឹងមាំរបស់កូន</th>
                                            <th>ការរៀងជួររបស់គ្រាប់</th>
                                            <th>ចំនួនឫស</th>
                                            <th>ប្រវែងចុងស្នៀត</th>
                                            <th>សរុប</th>

                                        </tr>
                                    </thead>
                                    <tbody id="cornBreedingData2">
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
                                                echo "<td class='py-2'>" . $cbd['flowering_age_gap'] . "</td>";
                                                echo "<td class='py-2'>" . $cbd['number_of_stalks'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['number_of_male_flower_stalks'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['male_flowering_age'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['flowering_age'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['leaf_angle'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['the_tail_on_the_end_of_the_fruit'] . "</td>";
                                                echo "<td class='py-2'>" . $cbd['fruit_length'] . "</td>";
                                                echo "<td class='py-2'>" . $cbd['fertility'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['original_size'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['stem_length'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['root_system'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['germination_rate'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['albino_birth_level'] . "</td>";
                                                echo "<td class='py-2'>" . $cbd['worm_damage_level'] . "</td>";
                                                echo "<td class='py-2'>" . $cbd['strength'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['age_gap_between_male_and_female_flowers'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['seuthern_rast'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['peeled_fruit_diameter'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['disease_level'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['peel_length'] . "</td>";
                                                echo "<td class='py-2'>" . $cbd['number_of_rows_of_seeds_per_fruit'] . "</td>";
                                                echo "<td class='py-2'>" . $cbd['fruit_peel'] . "</td>";
                                                echo "<td class='py-2'>" . $cbd['weight'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['worm'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['seedling_vigor'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['row_of_corn_kernels'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['number_of_roots'] . "</td>";
                                                echo "<td class='py-1'>" . $cbd['tip_length'] . "</td>";
                                                echo "<td class='py-2'>" . $cbd['total'] . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td class='text-center' colspan='9'>No corn breeding data found!</td></tr>";
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
        document.getElementById('filterBtn').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent form submission

            // Get filter values
            var pooch1 = document.getElementById('filterPooch1').value;
            var pooch2 = document.getElementById('filterPooch2').value;
            var jumnan = document.getElementById('filterJumnan').value;


            if (!pooch1 && !pooch2 && !jumnan) {
                return; // Exit the function if all filters are empty
            }

            // Send AJAX request to fetch filtered data
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'filter_corn_breeding_data.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    document.getElementById('cornBreedingData').innerHTML = this.responseText;
                }
            };

            // Send filter values
            xhr.send('pooch1=' + pooch1 + '&pooch2=' + pooch2 + '&jumnan=' + jumnan);
        });
        document.getElementById('filterBtn').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent form submission

            // Get filter values (allow empty values)
            var pooch1 = document.getElementById('filterPooch1').value || '';
            var pooch2 = document.getElementById('filterPooch2').value || '';
            var jumnan = document.getElementById('filterJumnan').value || '';


            if (!pooch1 && !pooch2 && !jumnan) {
                return; // Exit the function if all filters are empty
            }

            // Send AJAX request to fetch data for export (or all data if filters are empty)
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'filter_for_export.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    document.getElementById('cornBreedingData2').innerHTML = this.responseText;
                }
            };

            // Send filter values (empty if not selected)
            xhr.send('pooch1=' + pooch1 + '&pooch2=' + pooch2 + '&jumnan=' + jumnan);
        });
    </script>
    <!-- export to excel -->
    <script>
        function exportToExcel() {
            // Create a new HTML table with only the relevant columns
            var exportTable = document.createElement('table');
            var exportTableBody = document.createElement('tbody');

            // Get the header row from the HTML table
            var headerRow = document.querySelector('#tableForExport thead tr');

            // Create a new row for the export table and add the header cells
            var exportHeaderRow = document.createElement('tr');
            headerRow.querySelectorAll('th').forEach(function(cell) {
                var exportCell = document.createElement('td');
                exportCell.textContent = cell.textContent;
                exportCell.style.border = '1px solid black'; // Add border
                exportHeaderRow.appendChild(exportCell);
            });
            exportTableBody.appendChild(exportHeaderRow);

            // Iterate over each row of the HTML table and add the data rows
            var tableRows = document.querySelectorAll('#tableForExport tbody tr');
            tableRows.forEach(function(row) {
                // Create a new row for the export table
                var exportRow = document.createElement('tr');

                // Iterate over each cell of the row and create corresponding cells in the export table
                row.querySelectorAll('td').forEach(function(cell) {
                    var exportCell = document.createElement('td');
                    exportCell.textContent = cell.textContent;
                    exportCell.style.border = '1px solid black'; // Add border
                    exportRow.appendChild(exportCell);
                });

                // Append the row to the export table body
                exportTableBody.appendChild(exportRow);
            });

            // Append the table body to the export table
            exportTable.appendChild(exportTableBody);

            // Create a Blob object containing the HTML table
            var blob = new Blob(['\ufeff', exportTable.outerHTML], {
                type: 'application/vnd.ms-excel'
            });

            // Create a link element to download the Blob
            var url = URL.createObjectURL(blob);
            var a = document.createElement("a");
            a.href = url;
            a.download = "data_corn.xls";
            document.body.appendChild(a);
            a.click();

            // Cleanup
            setTimeout(function() {
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            }, 0);
        }
    </script>






</body>

</html>