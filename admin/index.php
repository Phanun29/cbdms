<?php

include "../inc/script_header.php";


// Query to get the count of users
$sql = "SELECT COUNT(*) AS total_users FROM tbl_users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalUsers = $row['total_users'];
} else {
    echo "No users found.";
}

// Query to get the count of corn varieties
$sql = "SELECT COUNT(*) AS total_corn_varieties FROM tbl_corn_varieties WHERE status = 0 ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalCornVarieties = $row['total_corn_varieties'];
} else {
    echo "No corn varieties found.";
}


// Query to get the count of corn varieties
$sql = "SELECT COUNT(*) AS total_corn_varieties_cut FROM tbl_corn_varieties WHERE status = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalCornVarietiesCut = $row['total_corn_varieties_cut'];
} else {
    echo "No corn varieties found.";
}

// Query to get the count of corn varieties
$sql = "SELECT COUNT(*) AS total_corn_breeding_data FROM tbl_corn_breeding_data";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalCornBreedingData = $row['total_corn_breeding_data'];
} else {
    echo "No corn varieties found.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    include_once "../inc/head.php";
    ?>
    <style>
        .small-box {
            border-radius: .25rem;
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        /*    display: block;*/
            /* margin-bottom: 20px; */
            position: relative;
            overflow: hidden;
        }

        .small-box-footer {
            background-color: rgba(0 0 0 /42%);
            color: rgba(255, 255, 255, .8);
            display: block;
            padding: 3px 0;
            position: relative;
            text-align: center;
            text-decoration: none;
            z-index: 10;

        }

        .small-box-footer:hover {
            text-decoration: none;
            color: rgba(255, 255, 255, .8);
            background-color: rgba(0 0 0 /62%);
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php
        include "../inc/sidebar.php";
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php

                include_once "../inc/topbar.php";
                ?>
                <!--End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dasshboard</h1>

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!--  Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 small-box">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                <h6>ទិន្នន័យបង្កាត់ពូជពោតសរុប</h6>

                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalCornBreedingData ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-database fa-2x  text-gray-300" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <a href="list_corn_breeding_data.php" class="small-box-footer">ព័ត៌មានបន្ថែម <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!--  Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 small-box">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                <h6> ពូជពោតដើមសរុប</h6>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalCornVarieties ?></div>
                                        </div>
                                        <div class="col-auto">

                                            <i class="fa fa-database fa-2x  text-gray-300" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <a href="list_of_original_corn_varieties.php" class="small-box-footer">ព័ត៌មានបន្ថែម <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!--  Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 small-box">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                <h6>ពូជពោតបង្កាត់សរុប</h6>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalCornVarietiesCut ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-database fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <a href="list_of_hybrid_corn_varieties.php" class="small-box-footer">ព័ត៌មានបន្ថែម <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!--  Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 small-box">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                <h6> អ្នកប្រើប្រាស់សរុប</h6>
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $totalUsers ?></div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-auto">

                                            <i class="fa fa-users fa-2x text-gray-300" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <a href="list_users.php" class="small-box-footer">ព័ត៌មានបន្ថែម <i class="fas fa-arrow-circle-right"></i></a>
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



</body>

</html>