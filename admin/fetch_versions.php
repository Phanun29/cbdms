<?php
include 'config.php';

$pooch1 = $_GET['pooch1'] ?? '';
$pooch2 = $_GET['pooch2'] ?? '';

if ($pooch1 && $pooch2) {
    $stmt = $conn->prepare("SELECT DISTINCT version FROM tbl_corn_breeding_data WHERE first_corn_variety = ? AND second_corn_variety = ?");
    $stmt->bind_param("ii", $pooch1, $pooch2);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $versions = [];
    while ($row = $result->fetch_assoc()) {
        $versions[] = $row['version'];
    }

    echo json_encode($versions);
}
?>
