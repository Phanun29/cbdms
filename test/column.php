<?php
include "config.php";

// SQL query to fetch data including the new column
$sql = "SELECT * FROM tbl_corn_breeding_data";
$result = $conn->query($sql);

// Check if data exists
if ($result->num_rows > 0) {
    // Output the data as an HTML table
    echo "<table border='1'>
            <thead>
                <tr>
                    <th>Column 1</th>
                    <th>Column 2</th>
                    <th>New Column</th> <!-- New Column Header -->
                </tr>
            </thead>
            <tbody>";

    // Loop through the result set and create table rows
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['fruit_height'] . "</td>
                <td>" . $row['root_system'] . "</td>
                <td>" . $row['stem_height'] . "</td> <!-- New Data Cell -->
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "No results found";
}

// Close the connection
$conn->close();
