<?php
session_start();
include 'config.php'; // Include your database connection

// Fetch all corn breeding data from the database
$query = "SELECT * FROM tbl_corn_breeding_data ORDER BY cbd_id DESC";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Corn Breeding Data</title>
</head>

<body>
    <h1>Corn Breeding Data</h1>
    <?php if (isset($_SESSION['success_message_cbd'])): ?>
        <p style="color:green;"><?php echo $_SESSION['success_message_cbd'];
                                unset($_SESSION['success_message_cbd']); ?></p>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>First Corn Variety</th>
            <th>Second Corn Variety</th>
            <th>Version</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['cbd_id']; ?></td>
                <td><?php echo $row['first_corn_variety']; ?></td>
                <td><?php echo $row['second_corn_variety']; ?></td>
                <td><?php echo $row['version']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $row['cbd_id']; ?>">Edit</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>