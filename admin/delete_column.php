<?php

include "config.php";
// Retrieve the column name from the URL or request
$column = $_GET['column'] ?? null;
$table = 'tbl_corn_breeding_data'; // Replace with your actual table name

// Check if the column parameter is provided
if (!$column) {
    die("Column name is required.");
}

// Prepare the SQL statement to delete the column
$sql = "ALTER TABLE `$table` DROP COLUMN `$column`";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Column '$column' deleted successfully.";
    header("location: column_tbl_cbd.php");
    exit();
} else {
    echo "Error deleting column: " . $conn->error;
}

// Close the connection
$conn->close();
