<?php
include('config.php'); // Add your database connection
$ids = $_POST['ids'];
$ids_string = implode(",", array_map('intval', $ids));

$query = "SELECT id, corn_varieties_name FROM tbl_corn_varieties WHERE id IN ($ids_string)";
$result = $conn->query($query);

$names = [];
while($row = $result->fetch_assoc()) {
    $names[$row['id']] = $row['corn_varieties_name'];
}
echo json_encode($names);
?>
