<?php
include "config.php";


session_start();
include "config.php";

// Validate and retrieve the name_of_cut_corn_variety
$cbd_id = isset($_POST['id']) && is_numeric($_POST['id']) ? $_POST['id'] : exit('invalid');
$name_of_cut_corn_variety = $conn->query("SELECT name_of_cut_corn_variety FROM tbl_corn_breeding_data WHERE cbd_id = $cbd_id")->fetch_assoc()['name_of_cut_corn_variety'] ?? exit('invalid');

// Define the target directory
$name_of_cut_corn_variety_dir = "../uploads/$name_of_cut_corn_variety";

// Delete files and directory
if (is_dir($ticket_dir)) {
    array_map('unlink', glob("$name_of_cut_corn_variety_dir/*"));
    rmdir($name_of_cut_corn_variety_dir);
}

// Delete related records from tbl_corn_varieties tbl_corn_breeding_data_images and tbl_corn_breeding_data
$queries = [
    "DELETE FROM tbl_corn_varieties WHERE corn_varieties_name = '$name_of_cut_corn_variety'",
    "DELETE FROM tbl_corn_breeding_data_images WHERE name_of_cut_corn_variety = '$name_of_cut_corn_variety'",
    "DELETE FROM tbl_corn_breeding_data WHERE cbd_id = '$cbd_id'"
];

foreach ($queries as $query) {
    if (!$conn->query($query)) {
        error_log('Error: ' . $conn->error);
        echo 'error';
        exit();
    }
}

echo "success";
$conn->close();
