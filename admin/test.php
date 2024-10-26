<?php
include "config.php";


// Prepare the update statement
$sql = "UPDATE tbl_corn_varieties 
        SET corn_varieties_name = REPLACE(corn_varieties_name, 'Pumpoy1', 'Pumpoy') 
        WHERE corn_varieties_name LIKE '%Pumpoy1%'";

// Execute the update query
if (mysqli_query($conn, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
