<?php
function getUserColumns($conn) {
    $columns = [];
    $result = $conn->query("SHOW COLUMNS FROM tbl_corn_breeding_data");

    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }

    return $columns;
}
?>
