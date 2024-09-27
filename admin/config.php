<?php

$conn = new mysqli("localhost", "root", "", "corn_breeding_db");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
