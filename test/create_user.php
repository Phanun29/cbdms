<?php
include 'config.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the columns for the users table
    $columns = getUserColumns($conn);

    $data = [];
    $placeholders = [];
    $bindTypes = "";

    // Assuming $columns is an array containing column names
    foreach ($columns as $column) {
        if (isset($_POST[$column]) && $column != 'cbd_id') {
            $value = $_POST[$column];

            if ($column == 'first_variety_name') {
                $data[$column] = $value;
                $placeholders[] = "?";
                $bindTypes .= "s";

                // Retrieve the first corn variety name
                $query_first_variety = "SELECT corn_varieties_name FROM tbl_corn_varieties WHERE id = ?";
                $stmt1 = $conn->prepare($query_first_variety);
                $stmt1->bind_param('i', $value);
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                $first_variety_name = $result1->fetch_assoc()['corn_varieties_name'] ?? 'N/A';
                $stmt1->close();
            }

            if ($column == 'second_variety_name') {
                $data[$column] = $value;
                $placeholders[] = "?";
                $bindTypes .= "s";

                // Retrieve the second corn variety name
                $query_second_variety = "SELECT corn_varieties_name FROM tbl_corn_varieties WHERE id = ?";
                $stmt2 = $conn->prepare($query_second_variety);
                $stmt2->bind_param('i', $value);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $second_variety_name = $result2->fetch_assoc()['corn_varieties_name'] ?? 'N/A';
                $stmt2->close();
            }

            if ($column == 'version') {
                $data[$column] = $value;
                $placeholders[] = "?";
                $bindTypes .= "s";
                $version = $value;
            }

            if (!in_array($column, ['first_variety_name', 'second_variety_name', 'version'])) {
                $data[$column] = $value;
                $placeholders[] = "?";
                $bindTypes .= is_numeric($value) ? "i" : "s";
            }
        }
    }

    if (isset($first_variety_name, $second_variety_name, $version)) {
        // Construct the unique corn variety name
        $name_of_cut_corn_variety = $first_variety_name . " x " . $second_variety_name . " " . $version;

        // Check if this variety name already exists in tbl_corn_varieties
        $query_check = "SELECT COUNT(*) FROM tbl_corn_varieties WHERE corn_varieties_name = ?";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bind_param('s', $name_of_cut_corn_variety);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($count > 0) {
            echo "Corn variety already exists!";
        } else {
            $query_insert = "INSERT INTO tbl_corn_varieties (corn_varieties_name, status) VALUES (?, '1')";
            $stmt_insert = $conn->prepare($query_insert);
            $stmt_insert->bind_param('s', $name_of_cut_corn_variety);

            if ($stmt_insert->execute()) {
                echo "Corn variety inserted successfully!";
            } else {
                echo "Error inserting corn variety: " . $stmt_insert->error;
            }
            $stmt_insert->close();
        }

        // Add name_of_cut_corn_variety to the $data array for insertion into tbl_corn_breeding_data
        $data['name_of_cut_corn_variety'] = $name_of_cut_corn_variety;
        $placeholders[] = "?";
        $bindTypes .= "s";
    }

    // Insert data into tbl_corn_breeding_data
    $columnList = implode(", ", array_keys($data));
    $placeholderList = implode(", ", $placeholders);
    $sql = "INSERT INTO tbl_corn_breeding_data ($columnList) VALUES ($placeholderList)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }

    // Bind and execute the insert statement
    $stmt->bind_param($bindTypes, ...array_values($data));

    if ($stmt->execute()) {
        echo "New record added successfully!";
        header("Location: read_users.php");
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

        <?php if ($column != 'cbd_id' && $column != 'name_of_cut_corn_variety' && $column != 'users_id'): ?>
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