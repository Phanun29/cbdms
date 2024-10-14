<?php
// retrieveData.php
session_start();
include "config.php";

// Retrieve filter values
$filterBreed1 = trim($_POST['pooch1']);
$filterBreed2 = trim($_POST['pooch2']);
$filterVersion = trim($_POST['jumnan']); // Assuming the input field for version is named 'version'

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

        echo "<td class='py-2'>" . $row['flowering_age_gap'] . "</td>";
        echo "<td class='py-2'>" . $row['number_of_stalks'] . "</td>";
        echo "<td class='py-1'>" . $row['number_of_male_flower_stalks'] . "</td>";
        echo "<td class='py-1'>" . $row['male_flowering_age'] . "</td>";
        echo "<td class='py-1'>" . $row['flowering_age'] . "</td>";
        echo "<td class='py-1'>" . $row['leaf_angle'] . "</td>";
        echo "<td class='py-1'>" . $row['the_tail_on_the_end_of_the_fruit'] . "</td>";
        echo "<td class='py-2'>" . $row['fruit_length'] . "</td>";
        echo "<td class='py-2'>" . $row['fertility'] . "</td>";
        echo "<td class='py-1'>" . $row['original_size'] . "</td>";
        echo "<td class='py-1'>" . $row['stem_length'] . "</td>";
        echo "<td class='py-1'>" . $row['root_system'] . "</td>";
        echo "<td class='py-1'>" . $row['germination_rate'] . "</td>";
        echo "<td class='py-1'>" . $row['albino_birth_level'] . "</td>";
        echo "<td class='py-2'>" . $row['worm_damage_level'] . "</td>";
        echo "<td class='py-2'>" . $row['strength'] . "</td>";
        echo "<td class='py-1'>" . $row['age_gap_between_male_and_female_flowers'] . "</td>";
        echo "<td class='py-1'>" . $row['seuthern_rast'] . "</td>";
        echo "<td class='py-1'>" . $row['peeled_fruit_diameter'] . "</td>";
        echo "<td class='py-1'>" . $row['disease_level'] . "</td>";
        echo "<td class='py-1'>" . $row['peel_length'] . "</td>";
        echo "<td class='py-2'>" . $row['number_of_rows_of_seeds_per_fruit'] . "</td>";
        echo "<td class='py-2'>" . $row['fruit_peel'] . "</td>";
        echo "<td class='py-2'>" . $row['weight'] . "</td>";
        echo "<td class='py-1'>" . $row['worm'] . "</td>";
        echo "<td class='py-1'>" . $row['seedling_vigor'] . "</td>";
        echo "<td class='py-1'>" . $row['row_of_corn_kernels'] . "</td>";
        echo "<td class='py-1'>" . $row['number_of_roots'] . "</td>";
        echo "<td class='py-1'>" . $row['tip_length'] . "</td>";
        echo "<td class='py-2'>" . $row['total'] . "</td>";
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
    echo "<td></td>";
    echo "<td></td>";
    echo "<td>Average of Data</td>";
    echo '<td colspan="1" id="averageFruitHeight">' . number_format($averageFruitHeight, 2) . '</td>';
    echo '<td colspan="1" id="averageStemHeight">' . number_format($averageStemHeight, 2) . '</td>';
    echo '<td colspan="1" id="averageMaleFloweringDay">' . number_format($averageMaleFloweringDay, 2) . '</td>';
    echo '<td colspan="1" id="averageFlowerDay">' . number_format($averageFlowerDay, 2) . '</td>';
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
