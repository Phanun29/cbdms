<?php
include 'config.php';
include 'functions.php';

// Get user ID from the URL
$userId = $_GET['id'] ?? null;

if (!$userId) {
    die("User ID is required.");
}

// Get columns for the users table
$columns = getUserColumns($conn);

// Fetch the user data to populate the form
$sql = "SELECT * FROM tbl_corn_breeding_data WHERE cbd_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();
$stmt->close();

// Fetch options for the corn_varieties dropdown
$roles = [];
$sql = "SELECT id, corn_varieties_name FROM tbl_corn_varieties";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }
}

// Handle the form submission for updating user data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['users_id'];

    // Prepare the fields to update
    $data = [];
    $setFields = [];

    foreach ($columns as $column) {
        // Only include non-empty fields that are not the users_id
        if (isset($_POST[$column]) && $_POST[$column] !== '' && $column !== 'users_id') {
            $data[] = $_POST[$column];
            $setFields[] = "$column = ?";
        }
    }

    // If no data to update, show an error
    if (empty($data)) {
        echo "No data to update.";
        exit;
    }

    // Build the SQL query with placeholders
    $setFieldsStr = implode(", ", $setFields);
    $sql = "UPDATE tbl_corn_breeding_data SET $setFieldsStr WHERE cbd_id = ?";

    // Prepare the statement for execution
    $stmt = $conn->prepare($sql);

    // Create bind_param string (e.g., "sssi" for 3 string fields and 1 integer)
    $bindTypes = str_repeat("s", count($data)) . "i";  // 's' for string, 'i' for integer (userId)

    // Manually bind the parameters
    $data[] = $userId; // Add $userId to the end of $data
    $stmt->bind_param($bindTypes, ...$data);

    // Execute the query and check the result
    if ($stmt->execute()) {
        echo "User updated successfully!";
        header("Location: read_users.php");
        exit();
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- Form for updating user details -->
<form action="" method="post">
    <input type="hidden" name="users_id" value="<?php echo htmlspecialchars($userId); ?>">

    <?php foreach ($columns as $column): ?>
        <?php if ($column != 'users_id'): ?>
            <label><?php echo ucfirst($column); ?>:</label>

            <?php if ($column === 'first_corn_variety' || $column === 'second_corn_variety'): ?>
                <!-- Dropdown for 'corn_varieties' column, populated from the roles table -->
                <select name="<?php echo $column; ?>">
                    <?php foreach ($roles as $role): ?>
                        <option value="<?php echo $role['id']; ?>"
                            <?php echo ($user[$column] == $role['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($role['corn_varieties_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

            <?php else: ?>
                <!-- Text input for other columns -->
                <input type="text" name="<?php echo $column; ?>" value="<?php echo htmlspecialchars($user[$column]); ?>"><br>
            <?php endif; ?>

        <?php endif; ?>
    <?php endforeach; ?>

    <button type="submit">Update User</button>
</form>