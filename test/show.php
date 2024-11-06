<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Columns List</title>
</head>

<body>
    <h1>Columns of the Table</h1>
    
    <!-- Form to add a new column -->
    <h2>Add a New Column</h2>
    <form method="post">
        <label for="new_column_name">Column Name: </label>
        <input type="text" name="new_column_name" id="new_column_name" required>
        <label for="new_column_type">Column Type: </label>
        <select name="new_column_type" id="new_column_type" required>
            <option value="VARCHAR(255)">VARCHAR(255)</option>
            <option value="INT">INT</option>
            <option value="TEXT">TEXT</option>
            <option value="DATE">DATE</option>
            <!-- Add more types as needed -->
        </select>
        <button type="submit" name="add_column">Add Column</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>#</th>
                <th>Column Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "config.php";

            // Handle adding a new column
            if (isset($_POST['add_column'])) {
                $new_column_name = $_POST['new_column_name'];
                $new_column_type = $_POST['new_column_type'];

                // SQL to add a new column
                $add_column_sql = "ALTER TABLE tbl_corn_breeding_data ADD `$new_column_name` $new_column_type";
                
                if ($conn->query($add_column_sql) === TRUE) {
                    echo "<p>Column '$new_column_name' added successfully!</p>";
                } else {
                    echo "<p>Error adding column: " . $conn->error . "</p>";
                }
            }

            // SQL query to list all columns of a table
            $table_name = 'tbl_corn_breeding_data'; // Replace with your table name
            $sql = "SHOW COLUMNS FROM $table_name";

            $result = $conn->query($sql);

            // Check if there are columns
            if ($result->num_rows > 0) {
                $counter = 1; // Initialize counter for numbering rows
                // Output the column names
                while ($row = $result->fetch_assoc()) {
                    $column_name = $row['Field'];

                    // Exclude 'cbd_id' and 'user_id' from actions
                    if ($column_name != 'cbd_id' && $column_name != 'user_id') {
                        echo "<tr>
                                <td>" . $counter++ . "</td>
                                <td>" . $column_name . "</td>
                                <td>
                                    <form method='post' action='edit_column.php'>
                                        <input type='hidden' name='column_name' value='$column_name'>
                                        <button type='submit' name='edit'>Edit</button>
                                    </form>
                                    <form method='post' action='delete_column.php'>
                                        <input type='hidden' name='column_name' value='$column_name'>
                                        <button type='submit' name='delete' onclick='return confirm(\"Are you sure you want to delete this column?\")'>Delete</button>
                                    </form>
                                </td>
                              </tr>"; // Display column name and actions
                    } else {
                        // For columns that cannot be edited or deleted, display without actions
                        echo "<tr>
                                <td>" . $counter++ . "</td>
                                <td>" . $column_name . "</td>
                                <td>No actions allowed</td>
                              </tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='3'>No columns found in the table</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>
