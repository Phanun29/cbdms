<?php
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $columnName = $_POST['column_name'];
    $dataType = $_POST['data_type'];
    $nullable = $_POST['nullable'] == 'YES' ? 'NULL' : 'NOT NULL';
    $default = !empty($_POST['default_value']) ? "DEFAULT '{$_POST['default_value']}'" : '';

    $sql = "ALTER TABLE tbl_corn_breeding_data ADD COLUMN $columnName $dataType $nullable $default";

    if ($conn->query($sql) === TRUE) {
        echo "Column added successfully!";
    } else {
        echo "Error adding column: " . $conn->error;
    }

    // $conn->close();
}



// Display the current columns in the table
$sql = "SHOW COLUMNS FROM tbl_corn_breeding_data";
$result = $conn->query($sql);

echo "<h3>Existing Columns in 'tbl_corn_breeding_data' Table</h3>";
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Column Name</th>
                <th>Data Type</th>
                <th>Nullable</th>
                <th>Key</th>
                <th>Default</th>    
                <th>Extra</th>
                <th>Action</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['Field']}</td>
                <td>{$row['Type']}</td>
                <td>{$row['Null']}</td>
                <td>{$row['Key']}</td>
                <td>{$row['Default']}</td>
                <td>{$row['Extra']}</td>
                <td><a href='delete_column.php?column={$row['Field']}'>delete</a>
                    <a href='edit_column1.php?column={$row['Field']}'>Edit</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No columns found in the table.";
}

$conn->close();
?>

<h3>Add New Column</h3>
<form action="" method="post">
    Column Name: <input type="text" name="column_name" required><br>
    Data Type (e.g., VARCHAR(100), INT): <input type="text" name="data_type" required><br>
    Nullable: <select name="nullable">
        <option value="YES">Yes</option>
        <option value="NO">No</option>
    </select><br>
    Default Value: <input type="text" name="default_value"><br>
    <button type="submit">Add Column</button>
</form>