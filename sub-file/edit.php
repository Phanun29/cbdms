<?php
ob_start(); // Start output buffering
session_start();
include 'config.php'; // Include your database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the CBD ID from the URL
$cbd_id = isset($_GET['id']) ? (int)$_GET['id'] : null; // Sanitize the CBD ID as an integer

// Fetch the existing data from the database
if ($cbd_id) {
    $stmt = $conn->prepare("SELECT * FROM tbl_corn_breeding_data WHERE cbd_id = ?");
    $stmt->bind_param("i", $cbd_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $corn_data = $result->fetch_assoc();
    $stmt->close();
}

// Update the record if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch input values and sanitize them
    $first_corn_variety = trim($_POST['first_corn_variety']);
    $second_corn_variety = trim($_POST['second_corn_variety']);
    $version = (float)$_POST['version'];
    $fruit_height = (float)$_POST['fruit_height'];
    $stem_height = (float)$_POST['stem_height'];
    $male_flowering_day = (int)$_POST['male_flowering_day'];
    $flower_day = (int)$_POST['flower_day'];

    // Prepare update statement
    $stmt_update = $conn->prepare("UPDATE tbl_corn_breeding_data SET first_corn_variety=?, second_corn_variety=?, version=?, fruit_height=?, stem_height=?, male_flowering_day=?, flower_day=? WHERE cbd_id=?");
    $stmt_update->bind_param("ssddiiii", $first_corn_variety, $second_corn_variety, $version, $fruit_height, $stem_height, $male_flowering_day, $flower_day, $cbd_id);

    if ($stmt_update->execute()) {
        $_SESSION['success_message_cbd'] = "Data updated successfully.";

        // Redirect back to the previous page using HTTP_REFERER
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('Location: default_page.php'); // Fallback page
        }
        exit;
    } else {
        error_log("Database error: " . $stmt_update->error);
        $_SESSION['error_message_cbd'] = "There was a problem updating the data. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Corn Breeding Data</title>
</head>

<body>
    <h1>Edit Corn Breeding Data</h1>
    <?php if (isset($_SESSION['error_message_cbd'])): ?>
        <p style="color:red;"><?php echo $_SESSION['error_message_cbd'];
                                unset($_SESSION['error_message_cbd']);
                                ?>
        </p>
    <?php endif; ?>

    <a href="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER']); ?>">Back</a>
    <?php echo htmlspecialchars($_SERVER['HTTP_REFERER']); ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="cbd_id" value="<?php echo htmlspecialchars($corn_data['cbd_id']); ?>"> <!-- Include cbd_id as a hidden field -->

        <label for="first_corn_variety">First Corn Variety:</label>
        <input type="text" name="first_corn_variety" id="first_corn_variety" value="<?php echo htmlspecialchars($corn_data['first_corn_variety']); ?>" required>

        <label for="second_corn_variety">Second Corn Variety:</label>
        <input type="text" name="second_corn_variety" id="second_corn_variety" value="<?php echo htmlspecialchars($corn_data['second_corn_variety']); ?>" required>

        <label for="version">Version:</label>
        <input type="text" name="version" id="version" value="<?php echo htmlspecialchars($corn_data['version']); ?>" required>

        <label for="fruit_height">Fruit Height:</label>
        <input type="number" name="fruit_height" id="fruit_height" value="<?php echo htmlspecialchars($corn_data['fruit_height']); ?>" required>

        <label for="stem_height">Stem Height:</label>
        <input type="number" name="stem_height" id="stem_height" value="<?php echo htmlspecialchars($corn_data['stem_height']); ?>" required>

        <label for="male_flowering_day">Male Flowering Day:</label>
        <input type="number" name="male_flowering_day" id="male_flowering_day" value="<?php echo htmlspecialchars($corn_data['male_flowering_day']); ?>" required>

        <label for="flower_day">Flower Day:</label>
        <input type="number" name="flower_day" id="flower_day" value="<?php echo htmlspecialchars($corn_data['flower_day']); ?>" required>

        <button type="submit">Update Data</button>
    </form>
</body>

</html>