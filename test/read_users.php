<?php
include 'config.php';
include 'functions.php';

// Get columns from the users table
$columns = getUserColumns($conn);

// Define a query with a JOIN to include corn variety name
$sql = "SELECT t.*,
                                cv1.corn_varieties_name AS first_variety_name, 
                                cv2.corn_varieties_name AS second_variety_name
                                FROM tbl_corn_breeding_data t
                                LEFT JOIN tbl_corn_varieties cv1 ON t.first_variety_name = cv1.id
                                LEFT JOIN tbl_corn_varieties cv2 ON t.second_variety_name = cv2.id
                                ";
$result = $conn->query($sql);

echo "
<a href='column_user.php'>Add Column</a><br>
<a href='create_user.php'>Add User</a>
<table border='1'>";

// Display table headers with numbering
echo "<tr>";
echo "<th>#</th>";
foreach ($columns as $column) {
    if ($column != 'cbd_id' && $column != 'name_of_cut_corn_variety' && $column != 'users_id') {  // Skip cbd_id column
        echo "<th>" . ucfirst($column) . "</th>";
     
        if ($column == 'male_flowering_day') {
            break;
        }
    }
}
echo "<th>Actions</th>";
echo "</tr>";

// Display table data
$rowNumber = 1;
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $rowNumber++ . "</td>";  // Display and increment row number

    foreach ($columns as $column) {
        // Skip cbd_id, name_of_cut_corn_variety, and users_id columns
        if ($column == 'cbd_id' || $column == 'name_of_cut_corn_variety' || $column == 'users_id') {
            continue;
        }

        if ($column == 'ពូជទី១') {
            // Display corn_varieties_name instead of the ID for first_corn_variety
            echo "<td>" . htmlspecialchars($row['first_corn_variety_name']) . "</td>";
        } elseif ($column == 'second_corn_variety') {
            // Display corn_varieties_name instead of the ID for second_corn_variety
            echo "<td>" . htmlspecialchars($row['second_corn_variety_name']) . "</td>";
        } else {
            if ($column == 'flowering_age_gap') {
                break;
            }
            echo "<td>" . htmlspecialchars($row[$column]) . "</td>";
      
          
        }
    }

    echo "<td>
            <a href='edit_user_form.php?id={$row['cbd_id']}'>Edit</a> |
            <a href='delete_user.php?id={$row['cbd_id']}'>Delete</a>
          </td>";
    echo "</tr>";
}
echo "</table>";
