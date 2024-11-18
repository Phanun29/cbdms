<?php
include "config.php"; // Include your DB connection

if (isset($_GET['column'])) {
    $column = $_GET['column'];

    // Make sure to wrap the column name in backticks if it contains spaces
    $column = "`" . $column . "`";

    // SQL query to drop the column
    $sql = "ALTER TABLE tbl_corn_breeding_data DROP COLUMN $column";

    if ($conn->query($sql) === TRUE) {
        echo "success"; // Send success response
    } else {
        echo "error"; // Send error response
    }

    $conn->close();
}
