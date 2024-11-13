<?php
include "../inc/script_header.php";
include 'functions.php';

// Get user ID from the URL
$userId = $_GET['id'] ?? null;

if (!$userId) {
    die("User ID is required.");
}

// Get columns for the users table
$columns = getUserColumns($conn);

// Fetch the user data to populate the form
$sql = "SELECT t.*, 
           GROUP_CONCAT(ti.image_path SEPARATOR ',') AS image_paths,
           cv1.corn_varieties_name AS first_variety_name, 
           cv2.corn_varieties_name AS second_variety_name
    FROM tbl_corn_breeding_data t 
    LEFT JOIN tbl_corn_breeding_data_images ti ON t.cbd_id = ti.cbd_id
    LEFT JOIN tbl_corn_varieties cv1 ON t.first_corn_variety = cv1.id
    LEFT JOIN tbl_corn_varieties cv2 ON t.second_corn_variety = cv2.id
    WHERE t.cbd_id = ? OR t.name_of_cut_corn_variety = ?
    GROUP BY t.cbd_id";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $userId, $userId);  // Binding both parameters for the query
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Explode the image paths into an array
$imagePaths = !empty($user['image_paths']) ? explode(',', $user['image_paths']) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../inc/head.php"; ?>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include "../inc/sidebar.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "../inc/topbar.php"; ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">មើលទិន្នន័យបង្កាត់ពូជពោត</h1>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-primary">
                            <a class="btn btn-secondary" href="javascript:history.back()">
                                <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ថយក្រោយ
                            </a>
                        </div>

                        <!-- Form displaying user data -->
                        <form action="" method="POST" class="row mt-3 px-3">
                            <?php
                            // Display form data with conditional checks for NULL values
                            foreach ($columns as $column) {
                                // Skip specific columns that you don't want to display
                                if ($column == 'cbd_id' || $column == 'name_of_cut_corn_variety' || $column == 'users_id') {
                                    continue;
                                }

                                // Check and display First Corn Variety
                                if ($column == 'first_corn_variety') {
                                    $firstVariety = $user['first_variety_name'] ?? 'N/A'; // Fallback to 'N/A' if NULL
                                    echo "<div class='col-12 col-md-6 row'>
                                        <label class='col-6'>First Corn Variety</label>
                                        <p class='form-control col-6'>" . htmlspecialchars($firstVariety) . "</p>
                                    </div>";

                                    // Check and display Second Corn Variety
                                } elseif ($column == 'second_corn_variety') {
                                    $secondVariety = $user['second_variety_name'] ?? 'N/A'; // Fallback to 'N/A' if NULL
                                    echo "<div class='col-12 col-md-6 row'>
                                        <label class='col-6'>Second Corn Variety</label>
                                        <p class='form-control col-6'>" . htmlspecialchars($secondVariety) . "</p>
                                    </div>";

                                    // Display other columns with fallback if NULL
                                } else {
                                    $value = $user[$column] ?? 'N/A'; // Fallback to 'N/A' if NULL
                                    echo "<div class='col-12 col-md-6 row'>
                                        <label class='col-6'>" . ucfirst(str_replace('_', ' ', $column)) . "</label>
                                        <p class='form-control col-6'>" . htmlspecialchars($value) . "</p>
                                    </div>";
                                }
                            }

                            ?>
                            <div class="form-group col-sm-12 row mt-2">
                                <?php
                                // Display images if available
                                if (!empty($imagePaths)) {
                                    foreach ($imagePaths as $image_path) {
                                        // Check the file extension to determine if it's an image or video
                                        $file_extension = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));

                                        // Determine if the file is an image
                                        if (in_array($file_extension, ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'webp'])) {
                                            // Image
                                            echo '<div class="image-container col-4 col-md-3">';
                                            echo '<img onclick="openModal(this)" style="width:100%; cursor: pointer;" src="' . htmlspecialchars($image_path) . '" alt="Image" class="image">';
                                            echo '</div>';
                                        }
                                    }
                                }
                                ?>
                                <!-- Modal for full-screen image -->
                                <div id="imageModal" class="modal" onclick="closeModal(event)">
                                    <span class="close" onclick="closeModal()">&times;</span>
                                    <img class="modal-content" id="fullImage">
                                </div>

                                <!-- CSS for the modal with auto width and height -->
                                <style>
                                    .modal {
                                        display: none;
                                        position: fixed;
                                        z-index: 1000;
                                        left: 0;
                                        top: 0;
                                        width: 100%;
                                        height: 100%;
                                        background-color: rgba(0, 0, 0, 0.9);
                                        overflow: auto;
                                    }

                                    .modal-content {
                                        margin: auto;
                                        display: block;
                                        max-width: 90%;
                                        max-height: 90%;
                                        width: auto;
                                        height: auto;
                                        object-fit: contain;
                                    }

                                    .close {
                                        position: absolute;
                                        top: 20px;
                                        right: 35px;
                                        color: white;
                                        font-size: 40px;
                                        font-weight: bold;
                                        cursor: pointer;
                                    }

                                    .close:hover,
                                    .close:focus {
                                        color: #bbb;
                                        text-decoration: none;
                                        cursor: pointer;
                                    }
                                </style>

                                <!-- JavaScript for modal functionality -->
                                <script>
                                    function openModal(img) {
                                        document.getElementById("imageModal").style.display = "block";
                                        document.getElementById("fullImage").src = img.src;
                                    }

                                    function closeModal(event) {
                                        // Close modal if the click target is the modal background or the close button
                                        if (event.target.id === "imageModal" || event.target.className === "close") {
                                            document.getElementById("imageModal").style.display = "none";
                                        }
                                    }
                                </script>
                                <div class="col-12 row mt-3" id="imagePreview">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php include "../inc/footer.php"; ?>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../assets/js/sb-admin-2.min.js"></script>
    <script src="../scripts/PreViewImage.js"></script>
</body>

</html>
