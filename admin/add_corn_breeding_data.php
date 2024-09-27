<?php include "../inc/script_header.php"; ?>
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
                        <h1 class="h3 mb-0 text-gray-800"> បន្ថែមទិន្នន័យបង្កាត់ពូជពោត</h1>

                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">

                            <a class="btn btn-secondary" href="list_corn_breeding_data.php"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ថយក្រោយ</a>
                        </div>
                        <form action="" class="row mt-3 px-3" method="POST">
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="corn_varieties_name" class="col-6">ពូជទី១ <span class="text-danger">*</span></label>

                                <select name="first_varieties_name" id="corn_varieties_name" class="form-control col-6">
                                    <option value="" disabled selected>--ជ្រើសរើស--</option>
                                    <?php
                                    $query_corn_varieties = "SELECT *FROM tbl_corn_varieties";
                                    $result = $conn->query($query_corn_varieties);

                                    if ($result->num_rows > 0) {
                                        while ($corn_varieties = $result->fetch_assoc()) {
                                            echo " <option value=''>{$corn_varieties['corn_varieties_name']} </option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ពូជទី២ <span class="text-danger">*</span></label>
                                <select name="second_corn_varieties" id="corn_varieties_name" class="form-control col-6">
                                    <option value="" disabled selected>--ជ្រើសរើស--</option>
                                    <?php
                                    $query_corn_varieties = "SELECT *FROM tbl_corn_varieties";
                                    $result = $conn->query($query_corn_varieties);

                                    if ($result->num_rows > 0) {
                                        while ($corn_varieties = $result->fetch_assoc()) {
                                            echo " <option value=''>{$corn_varieties['corn_varieties_name']} </option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ជំនាន់ <span class="text-danger">*</span></label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">កម្ពស់ផ្លែ <span class="text-danger">*</span></label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">កម្ពស់ដើម <span class="text-danger">*</span></label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ថ្ងៃចេញផ្កាញី​ ៥០% <span class="text-danger">*</span></label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ថ្ងៃចេញផ្កាឈ្មោល​ ៥០% <span class="text-danger">*</span></label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">គម្លាតអាយុចេញផ្កា</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ចំនួនទងផ្កា</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ចំនួនផ្កាឈ្មោល</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">អាយុចេញផ្កាឈ្មោល</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">អាយុចេញផ្កាញី</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">មុំស្លឹក</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ភាពមានកន្ទុយលើចុងផ្លែ</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ប្រវែងផ្លែ <span class="text-danger">*</span></label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ភាពជាប់ផ្លែ</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ទំហំដើម</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ប្រវែងគល់ផ្លែ</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ប្រព័ន្ធឫស</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">អត្រាដំណុះ</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">កម្រិតកើត Albino</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">កម្រិតបំផ្លាញរបស់ដង្កូវ</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ភាពរឹងមាំ</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">គម្លាតអាយុផ្កាញីនិងឈ្មោល</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">កើតជំងឺ(Seuthern Rast)</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">អង្កត់ផ្ចិតផ្លែបកសំបក</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">កម្រិតការកើតជំងឺ</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ប្រវែងផ្លែបបកសំបក</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ចំនួនជួរគ្រាប់ក្នុងមួយផ្លែ</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ចំនួនគ្រាប់ក្នុងមួយជួរ</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">សំបកផ្លែ</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ទម្ងន់</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ដង្កូវ</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">Seeding Vigor</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ភាពរឹងមាំរបស់កូន</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ការរៀងជួររបស់គ្រាប់</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ចំនួនឫស</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">ប្រវែងចុងស្នៀត(cm)</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">សរុប</label>
                                <input type="text" name="" class="form-control col-6">
                            </div>
                            <div class="col-12 col-md-6 mt-2 row">
                                <label for="" class="col-6">រូបភាព</label>
                                <input type="file" class="form-control col-6" id="issue_image" name="issue_image[]" multiple accept="">
                            </div>
                            <!-- Display selected new images -->
                            <div class="col-12 row mt-3" id="imagePreview">
                            </div>
                            <div class="col-12 my-2" style="text-align:end;">

                                <button type="submit" class="btn btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i> រក្សាទុក</button>

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