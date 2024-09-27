<?php
// Start session at the beginning of the script
session_start();

// Include your database connection file
include_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $corn_varieties_name = $_POST['corn_varieties_name'];
    $update_id = $_POST['update_id'];

    // Check if the name already exists (excluding the current ID being updated)
    $check_sql = "SELECT id FROM tbl_corn_varieties WHERE corn_varieties_name = ? AND id != ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param('si', $corn_varieties_name, $update_id);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // If a duplicate is found
        echo json_encode(['status' => 'error', 'message' => 'ឈ្មោះពូជពោតនេះមានរួចហើយ។']); // "This variety name already exists."
    } else {
        // Proceed with the update
        $sql = "UPDATE tbl_corn_varieties SET corn_varieties_name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $corn_varieties_name, $update_id);

        if ($stmt->execute()) {
            // Set a session message on successful update
            $_SESSION['success_message'] = 'ពូជពោតកែបានជោគជ័យ។'; // "Variety updated successfully."
            echo json_encode(['status' => 'success', 'message' => $_SESSION['success_message']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'កំហុសកើតឡើងពេលកែប្រែ។']); // "Error updating variety."
        }

        $stmt->close();
    }

    $stmt_check->close();
    $conn->close();
}
