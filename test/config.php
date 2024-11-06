<?php

$conn = new mysqli("localhost", "root", "", "db_cbdms");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
