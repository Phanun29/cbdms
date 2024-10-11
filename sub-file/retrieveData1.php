<?php
// retrieveData.php
session_start();
include "config.php";

// Retrieve filter values
$filterBreed1 = trim($_POST['filterBreed1']);
$filterBreed2 = trim($_POST['filterBreed2']);
$filterVersion = trim($_POST['version']); // Assuming the input field for version is named 'version'

// Build filter conditions
$filterConditions = [];

if (!empty($filterBreed1)) {
    $filterConditions[] = "first_corn_variety = '$filterBreed1'";
}

if (!empty($filterBreed2)) {
    $filterConditions[] = "second_corn_variety = '$filterBreed2'";
}

if (!empty($filterVersion)) {
    $filterConditions[] = "version = '$filterVersion'";
}

// Combine filter conditions using AND
$filterCondition = !empty($filterConditions) ? ' AND ' . implode(' AND ', $filterConditions) : '';

// Construct SQL query
$sql = "SELECT * FROM tbl_corn_breeding_data WHERE 1 $filterCondition";

//echo "SQL Query: " . $sql . "<br>";

$result = $conn->query($sql);

if (!$result) {
    die("Error in query: " . $conn->error);
}
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
        // echo '<td>' . $row['additional_column1'] . '</td>'; // Output additional column from myTable2
        //  echo '<td>' . $row['additional_column2'] . '</td>'; // Output additional column from myTable2
        echo "<td><a class='btn btn-primary float-start px-3' href='details.php?id={$row['cbd_id']}'><i class='fa-solid fa-eye me-1'></i>លម្អិត</a>";
?>
  
        
<?php

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
    echo '<td colspan="1">' . '</td>';
    echo '</tr>';

    // echo '<tr>';
    // echo '<td colspan="9" class="text-center">Total Average</td>';
    // echo '<td colspan="4">' . $totalAverage . '</td>';
    // echo '</tr>';
} else {
    echo '<tr><td colspan="9" class="text-center">មិនមានទិន្នន័យទេ</td></tr>';
}


error_log("SQL Query: " . $sql);

$conn->close();
