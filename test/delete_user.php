<?php
include 'config.php';

$userId = $_GET['id'];
$sql = "DELETE FROM users WHERE users_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    echo "User deleted successfully!";
    header("location: read_users.php");
    exit();
} else {
    echo "Error deleting user: " . $stmt->error;
}

$stmt->close();
$conn->close();
