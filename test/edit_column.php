<?php
include "config.php";

if (isset($_POST['edit'])) {
    $column_name = $_POST['column_name'];

    // Display a form to edit the column (just an example of column name edit)
    echo "<form method='post'>
            <label>New Column Name: </label>
            <input type='text' name='new_column_name' value='$column_name'>
            <input type='hidden' name='column_name' value='$column_name'>
            <button type='submit' name='submit_edit'>Submit Edit</button>
          </form>";
}

if (isset($_POST['submit_edit'])) {
    $column_name = $_POST['column_name'];
    $new_column_name = $_POST['new_column_name'];

    // Alter the table to rename the column (MySQL query)
    $sql = "ALTER TABLE tbl_corn_breeding_data CHANGE `$column_name` `$new_column_name` VARCHAR(255)";

    if ($conn->query($sql) === TRUE) {
        echo "Column renamed successfully!";
        header("location: show.php");
        exit();
    } else {
        echo "Error renaming column: " . $conn->error;
    }
}
