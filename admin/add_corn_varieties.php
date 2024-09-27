<?php
session_start();
include_once "config.php"; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $corn_varieties_name = $_POST['corn_varieties_name'];

    // Check if the corn variety name already exists
    $check_query = "SELECT * FROM tbl_corn_varieties WHERE corn_varieties_name = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param('s', $corn_varieties_name);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        // If the name already exists, send an error response
        echo json_encode([
            'status' => 'error',
            'message' => 'ឈ្មោះពូជពោតនេះមានរួចហើយ!' // "This variety name already exists!"
        ]);
    } else {
        // Insert the new corn variety name into the database
        $sql = "INSERT INTO tbl_corn_varieties (corn_varieties_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $corn_varieties_name);

        if ($stmt->execute()) {
            // Set a session message on successful insertion
            $_SESSION['success_message'] = 'ពូជពោតបានបញ្ចូលជោគជ័យ!'; // "Variety added successfully!"
            echo json_encode([
                'status' => 'success',
                'message' => $_SESSION['success_message']
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error: Unable to insert data.'
            ]);
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
