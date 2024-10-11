<?php
// retrieveData.php
session_start();
include "config.php";



// Initialize filter variables
$filterBreedA = isset($_POST['filterBreedA']) ? $_POST['filterBreedA'] : '';
$filterBreedB = isset($_POST['filterBreedB']) ? $_POST['filterBreedB'] : '';
$version = isset($_POST['version']) ? $_POST['version'] : '';

// Construct the SQL query based on filters
$query = "SELECT * FROM tbl_corn_breeding_data WHERE 1=1"; // Change 'your_table_name' to your actual table name

// Add filters to the query if they are set
if (!empty($filterBreedA)) {
    $query .= " AND first_corn_variety = '" . $conn->real_escape_string($filterBreedA) . "'"; // Change 'breed_column_a' to your actual column name
}

if (!empty($filterBreedB)) {
    $query .= " AND second_corn_variety = '" . $conn->real_escape_string($filterBreedB) . "'"; // Change 'breed_column_b' to your actual column name
}

if (!empty($version)) {
    $query .= " AND version = '" . $conn->real_escape_string($version) . "'"; // Change 'version_column' to your actual column name
}

// Execute the query
$result = $conn->query($query);
$i = 1;
$totalAverage = 0; // Initialize total average variable

// Variables to store sum of each column
$sumFruitHeight = 0;
$sumStemHeight = 0;
$sumMaleFloweringDay = 0;
$sumFlowerDay = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // ... (your existing code to display table rows)
        // Output or log relevant data here
        // Increment sum of each column
        $sumFruitHeight += intval($row['fruit_height']);
        $sumStemHeight += intval($row['stem_height']);
        $sumMaleFloweringDay += intval($row['male_flowering_day']);
        $sumFlowerDay += intval($row['flower_day']);

        echo '<tr class="text-center">';
        echo '<td>' . $i++ . '</td>';
        echo '<td>' . $row['first_corn_variety'] . '</td>';
        echo '<td>' . $row['second_corn_variety'] . '</td>';
        echo '<td>' . $row['version'] . '</td>';
        echo '<td>' . $row['fruit_height'] . '</td>';
        echo '<td>' . $row['stem_height'] . '</td>';
        echo '<td>' . $row['male_flowering_day'] . '</td>';
        echo '<td>' . $row['flower_day'] . '</td>';
        echo "  </td>";
        echo '</tr>';
    }
    // Calculate the average of each column
    $numRows = $result->num_rows;
    $averageFruitHeight = $sumFruitHeight / $numRows;
    $averageStemHeight = $sumStemHeight / $numRows;
    $averageMaleFloweringDay = $sumMaleFloweringDay / $numRows;
    $averageFlowerDay = $sumFlowerDay / $numRows;

    // Calculate the average of averages
    $totalAverage = ($averageFruitHeight + $averageStemHeight + $averageMaleFloweringDay + $averageFlowerDay) / 4;

    // Display the total average
    // Display the total average
    echo '<tr>';
    echo '<td colspan="4" class="text-center">Average of Data</td>';
    echo '<td colspan="1" id="averageFruitHeight">' . number_format($averageFruitHeight, 2) . '</td>';
    echo '<td colspan="1" id="averageStemHeight">' . number_format($averageStemHeight, 2) . '</td>';
    echo '<td colspan="1" id="averageMaleFloweringDay">' . number_format($averageMaleFloweringDay, 2) . '</td>';
    echo '<td colspan="1" id="averageFlowerDay">' . number_format($averageFlowerDay, 2) . '</td>';
    echo '</tr>';



    // After your existing code to calculate averages:
    $averageFruitHeight = $sumFruitHeight > 0 ? $sumFruitHeight / $numRows : 0;
    $averageStemHeight = $sumStemHeight > 0 ? $sumStemHeight / $numRows : 0;
    $averageMaleFloweringDay = $sumMaleFloweringDay > 0 ? $sumMaleFloweringDay / $numRows : 0;
    $averageFlowerDay = $sumFlowerDay > 0 ? $sumFlowerDay / $numRows : 0;



    // Create an associative array to return both the HTML and the averages
    $response = [
        'tableHtml' => ob_get_clean(), // Assuming you output the table rows using output buffering
        'averageFruitHeight' => number_format($averageFruitHeight, 2),
        'averageStemHeight' => number_format($averageStemHeight, 2),
        'averageMaleFloweringDay' => number_format($averageMaleFloweringDay, 2),
        'averageFlowerDay' => number_format($averageFlowerDay, 2)
    ];

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo '<tr><td colspan="9" class="text-center">មិនមានទិន្នន័យទេ</td></tr>';
}

// Close the database connection
$conn->close();
