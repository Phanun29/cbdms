<?php
// retrieveData.php
session_start();
include "config.php";

// Initialize filter variables
$first_corn_variety = isset($_POST['first_corn_variety']) ? $_POST['first_corn_variety'] : '';
$second_corn_variety = isset($_POST['second_corn_variety']) ? $_POST['second_corn_variety'] : '';
$version = isset($_POST['version']) ? $_POST['version'] : '';

// Construct the SQL query based on filters
$query = "SELECT * FROM tbl_corn_breeding_data WHERE 1=1";

// Add filters to the query if they are set
if (!empty($first_corn_variety)) {
    $query .= " AND first_corn_variety = '" . $conn->real_escape_string($first_corn_variety) . "'";
}

if (!empty($second_corn_variety)) {
    $query .= " AND second_corn_variety = '" . $conn->real_escape_string($second_corn_variety) . "'";
}

if (!empty($version)) {
    $query .= " AND version = '" . $conn->real_escape_string($version) . "'";
}

// Get column names from the table dynamically
$columnQuery = "SHOW COLUMNS FROM tbl_corn_breeding_data";
$columnsResult = $conn->query($columnQuery);

$columnsToAverage = [];
if ($columnsResult->num_rows > 0) {
    while ($column = $columnsResult->fetch_assoc()) {
        $columnsToAverage[] = $column['Field']; // Store all column names
    }
}

// Start output buffering to capture HTML output
ob_start();

// Execute the main query
$result = $conn->query($query);
$i = 1;

// Initialize arrays to store sums
$columnSums = array_fill_keys($columnsToAverage, 0);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {


        // Output each cell value and calculate sums only for numeric columns
        foreach ($columnsToAverage as $column) {
            $value = $row[$column];

            // Display the value in the table
            // echo '<td>' . htmlspecialchars($value) . '</td>';

            // Sum only numeric values
            if (is_numeric($value)) {
                $columnSums[$column] += floatval($value);
            }
        }
    }

    // Calculate averages for each column based on row count
    $numRows = $result->num_rows;
    $averages = [];
    $validColumnIndex = 0; // To track the position of valid columns
    $columnAverages = []; // To store averages for the first four valid columns

    // Loop through columnsToAverage and process only the first four valid columns
    foreach ($columnsToAverage as $column) {
        // Skip unwanted columns
        if (in_array($column, ['cbd_id', 'name_of_cut_corn_variety', 'users_id', 'first_corn_variety', 'second_corn_variety', 'version'])) {
            continue;
        }

        $validColumnIndex++; // Increment for each valid column

        // Process only the first four valid columns
        if ($validColumnIndex >= 1 && $validColumnIndex <= 4) {
            $columnAverages[$column] = $numRows ? $columnSums[$column] / $numRows : 0;
        }

        // Break after processing the fourth valid column
        if ($validColumnIndex == 4) {
            break;
        }
    }

    // Format column averages for response
    $formattedAverages = [];
    foreach ($columnAverages as $column => $average) {
        $formattedAverages["average" . $column] = number_format($average, 2);
    }

    // Generate JSON response
    $response = array_merge(

        $formattedAverages
    );

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // No data case
    ob_end_clean(); // Clear the output buffer
    echo json_encode([
        'tableHtml' => '<tr><td colspan="' . (count($columnsToAverage) + 1) . '" class="text-center">មិនមានទិន្នន័យទេ</td></tr>'
    ]);
}







// // Initialize filter variables
// $first_corn_variety = isset($_POST['first_corn_variety']) ? $_POST['first_corn_variety'] : '';
// $second_corn_variety = isset($_POST['second_corn_variety']) ? $_POST['second_corn_variety'] : '';
// $version = isset($_POST['version']) ? $_POST['version'] : '';

// // Construct the SQL query based on filters
// $query = "SELECT * FROM tbl_corn_breeding_data WHERE 1=1"; // Change 'your_table_name' to your actual table name

// // Add filters to the query if they are set
// if (!empty($first_corn_variety)) {
//     $query .= " AND first_corn_variety = '" . $conn->real_escape_string($first_corn_variety) . "'"; // Change 'breed_column_a' to your actual column name
// }

// if (!empty($second_corn_variety)) {
//     $query .= " AND second_corn_variety = '" . $conn->real_escape_string($second_corn_variety) . "'"; // Change 'breed_column_b' to your actual column name
// }

// if (!empty($version)) {
//     $query .= " AND version = '" . $conn->real_escape_string($version) . "'"; // Change 'version_column' to your actual column name
// }

// // Execute the query
// $result = $conn->query($query);
// $i = 1;
// $totalAverage = 0; // Initialize total average variable

// // Variables to store sum of each column
// $sumFruitHeight = 0;
// $sumStemHeight = 0;
// $sumMaleFloweringDay = 0;
// $sumFlowerDay = 0;
// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         // ... (your existing code to display table rows)
//         // Output or log relevant data here
//         // Increment sum of each column
//         $sumFruitHeight += intval($row['fruit_height']);
//         $sumStemHeight += intval($row['stem_height']);
//         $sumMaleFloweringDay += intval($row['male_flowering_day']);
//         $sumFlowerDay += intval($row['flower_day']);
//     }
//     // Calculate the average of each column
//     $numRows = $result->num_rows;
//     $averageFruitHeight = $sumFruitHeight / $numRows;
//     $averageStemHeight = $sumStemHeight / $numRows;
//     $averageMaleFloweringDay = $sumMaleFloweringDay / $numRows;
//     $averageFlowerDay = $sumFlowerDay / $numRows;

//     // Calculate the average of averages
//     $totalAverage = ($averageFruitHeight + $averageStemHeight + $averageMaleFloweringDay + $averageFlowerDay) / 4;

//     // After your existing code to calculate averages:
//     $averageFruitHeight = $sumFruitHeight > 0 ? $sumFruitHeight / $numRows : 0;
//     $averageStemHeight = $sumStemHeight > 0 ? $sumStemHeight / $numRows : 0;
//     $averageMaleFloweringDay = $sumMaleFloweringDay > 0 ? $sumMaleFloweringDay / $numRows : 0;
//     $averageFlowerDay = $sumFlowerDay > 0 ? $sumFlowerDay / $numRows : 0;


//     // Create an associative array to return both the HTML and the averages
//     $response = [
//         'tableHtml' => ob_get_clean(), // Assuming you output the table rows using output buffering
//         'averageFruitHeight' => number_format($averageFruitHeight, 2),
//         'averageStemHeight' => number_format($averageStemHeight, 2),
//         'averageMaleFloweringDay' => number_format($averageMaleFloweringDay, 2),
//         'averageFlowerDay' => number_format($averageFlowerDay, 2)
//     ];

//     // Return the JSON response
//     header('Content-Type: application/json');
//     echo json_encode($response);
// }

// // Close the database connection
// $conn->close();
