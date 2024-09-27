<?php include "../inc/script_header.php";
$cbd_id = $_GET['id'];

$cbd_query = "SELECT * FROM tbl_corn_breeding_data WHERE id = $cbd_id";
$cbd_result= $conn->query($cbd_query);
$cbd = $cbd_result->fetch_assoc();
 ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php include "../inc/head.php"; ?>

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
                        <h1 class="h3 mb-0 text-gray-800">មើលទិន្នន័យបង្កាត់ពូជពោត</h1>

                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">

                            <a class="btn btn-secondary" href="list_corn_breeding_data.php"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ថយក្រោយ</a>
                        </div>
                        <form action="" class="row mt-3 px-3">
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ពូជទី១ </label>
                                <p class="form-control col-6" ><?= $cbd['first_corn_variety']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ពូជទី២ </label>
                                <p class="form-control col-6"><?= $cbd['second_corn_variety']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ជំនាន់</label>
                                <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">កម្ពស់ផ្លែ</label>
                              <p class="form-control col-6"><?= $cbd['fruit_height']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">កម្ពស់ដើម</label>
                              <p class="form-control col-6"><?= $cbd['stem_height']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ថ្ងៃចេញផ្កាញី​ ៥០%</label>
                              <p class="form-control col-6"><?= $cbd['flower_day']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ថ្ងៃចេញផ្កាឈ្មោល​ ៥០%</label>
                              <p class="form-control col-6"><?= $cbd['male_flowering_day']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">គម្លាតអាយុចេញផ្កា</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ចំនួនទងផ្កា</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ចំនួនផ្កាឈ្មោល</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">អាយុចេញផ្កាឈ្មោល</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">អាយុចេញផ្កាញី</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">មុំស្លឹក</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ភាពមានកន្ទុយលើចុងផ្លែ</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ប្រវែងផ្លែ <span class="text-danger">*</span></label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ភាពជាប់ផ្លែ</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ទំហំដើម</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ប្រវែងគល់ផ្លែ</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ប្រព័ន្ធឫស</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">អត្រាដំណុះ</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">កម្រិតកើត Albino</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">កម្រិតបំផ្លាញរបស់ដង្កូវ</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ភាពរឹងមាំ</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">គម្លាតអាយុផ្កាញីនិងឈ្មោល</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">កើតជំងឺ(Seuthern Rast)</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">អង្កត់ផ្ចិតផ្លែបកសំបក</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">កម្រិតការកើតជំងឺ</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ប្រវែងផ្លែបបកសំបក</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ចំនួនជួរគ្រាប់ក្នុងមួយផ្លែ</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ចំនួនគ្រាប់ក្នុងមួយជួរ</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">សំបកផ្លែ</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ទម្ងន់</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ដង្កូវ</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">Seeding Vigor</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ភាពរឹងមាំរបស់កូន</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ការរៀងជួររបស់គ្រាប់</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ចំនួនឫស</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">ប្រវែងចុងស្នៀត(cm)</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                            <div class="col-12 col-md-6 row">
                                <label for="" class="col-6">សរុប</label>
                              <p class="form-control col-6"><?= $cbd['version']?></p>
                            </div>
                         
                            <!-- Display selected new images -->
                            <div class="col-12 row mt-3" id="imagePreview">
                            </div>
                            <div class="col-12 py-3">
                                <button class="btn btn-primary">submit</button>
                            </div>
                        </form>

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

    <script src="../scripts/PreViewImage.js"></script>



</body>

</html>