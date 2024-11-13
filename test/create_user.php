<?php
include 'config.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the columns for the users table
    $columns = getUserColumns($conn);

    $data = [];
    $placeholders = [];
    $bindTypes = ""; // To store bind types for bind_param()

    foreach ($columns as $column) {
        if (isset($_POST[$column]) && $column != 'cbd_id') {
            $value = $_POST[$column];
            $data[$column] = $value;
            $placeholders[] = "?";

            // Add the appropriate bind type based on the column type
            if (is_numeric($value)) {
                $bindTypes .= "i"; // Integer type
            } else {
                $bindTypes .= "s"; // String type
            }
        }
    }

    $columnList = implode(", ", array_keys($data));
    $placeholderList = implode(", ", $placeholders);
    $sql = "INSERT INTO tbl_corn_breeding_data ($columnList) VALUES ($placeholderList)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param($bindTypes, ...array_values($data));

    if ($stmt->execute()) {
        echo "New record added successfully!";
        header("Location: read_users.php"); // Redirect after successful insert
        exit();
    } else {
        echo "Error adding record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

$columns = getUserColumns($conn);
?>

<!-- Form for adding a new user -->
<form action="" method="post">
    <?php foreach ($columns as $column): ?>
        <?php if ($column === 'users_id'): ?>
            <!-- Dropdown for selecting existing user IDs to satisfy foreign key constraint -->
            <label>User ID:</label>
            <select name="users_id">
                <?php
                $userQuery = "SELECT users_id, first_name FROM tbl_users";
                $userResult = $conn->query($userQuery);
                while ($userRow = $userResult->fetch_assoc()): ?>
                    <option value="<?php echo $userRow['users_id']; ?>">
                        <?php echo $userRow['first_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br>
        <?php endif; ?>

        <?php if ($column != 'cbd_id' && $column != 'name_of_cut_corn_variety'&& $column != 'users_id' ): ?>
            <label><?php echo ucfirst($column); ?>:</label>

            <?php if ($column === 'first_corn_variety' || $column === 'second_corn_variety'): ?>
                <!-- Dropdown for 'corn_varieties' column, populated from tbl_corn_varieties -->
                <?php
                $cornQuery = "SELECT id, corn_varieties_name FROM tbl_corn_varieties";
                $cornResult = $conn->query($cornQuery);
                ?>
                <select name="<?php echo $column; ?>">
                    <option value="">Select Corn Variety</option>
                    <?php while ($cornRow = $cornResult->fetch_assoc()): ?>
                        <option value="<?php echo $cornRow['id']; ?>">
                            <?php echo $cornRow['corn_varieties_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select><br>
            <?php else: ?>
                <input type="text" name="<?php echo $column; ?>"><br>
            <?php endif; ?>

        <?php endif; ?>
    <?php endforeach; ?>

    <button type="submit">Add Record</button>
</form> 
