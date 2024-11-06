<?php
include "config.php";

if (isset($_POST['delete'])) {
    $column_name = $_POST['column_name'];

    // SQL query to drop the column
    $sql = "ALTER TABLE tbl_corn_breeding_data DROP COLUMN `$column_name`";

    if ($conn->query($sql) === TRUE) {
        echo "Column deleted successfully!";
        header("location: show.php");
        exit();
    } else {
        echo "Error deleting column: " . $conn->error;
    }
}
