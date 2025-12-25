<?php
include('../includes/db.php');

$result = $conn->query("SELECT * FROM doctors");
?>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctors List</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .actions a {
            display: inline-block;
            margin: 2px 4px 2px 0;
            padding: 6px 10px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            font-size: 0.9em;
        }
        .edit-btn { background-color: #17a2b8; }
        .delete-btn { background-color: #dc3545; }
        .appoint-btn { background-color: #007bff; }

        .back-btn {
            display: inline-block;
            margin-bottom: 15px;
            background-color: #6c757d;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div id="list-box">

    <!-- Back to Dashboard -->
    <a href="../index.php" class="back-btn">← Back to Dashboard</a>

    <!-- Add Doctor Button -->
    <a href="add.php" style="display:inline-block; margin-left: 10px; background-color:#28a745; color:white; padding:10px 15px; text-decoration:none; border-radius:5px;">➕ Add New Doctor</a>

    <h2 style="margin-top: 20px;">All Doctors</h2>

    <!-- Doctors Table -->
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Specialty</th>
            <th>Contact</th>
            <th>Actions</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['specialty']) ?></td>
                    <td><?= htmlspecialchars($row['contact']) ?></td>
                    <td class="actions">
                        <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this doctor?')">Delete</a>
                        <a href="../appointments/add.php?doctor_id=<?= $row['id'] ?>" class="appoint-btn">Make Appointment</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5"style="text-align:center;">No doctors found.</td></tr>
        <?php endif; ?>
    </table>
</div>
<?php include('../includes/footer.php'); ?>
</body>
</html>
