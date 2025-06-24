<?php
include('../includes/db.php');
$result = $conn->query("SELECT * FROM patients");
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
    <title>Patient List</title>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<div id="list-box">
    <a href="../index.php" class="back-btn">← Back to Dashboard</a>
    <a href="add.php" style="display:inline-block; margin-left: 10px; background-color:#4CAF50; color:white; padding:10px 15px; text-decoration:none; border-radius:5px;">➕ Add New Patient</a>

    <h2 style="margin-top: 20px;">Patient List</h2>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>DOB</th>
            <th>Gender</th>
            <th>Contact</th>
            <th>Actions</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['dob'] ?></td>
                <td><?= $row['gender'] ?></td>
                <td><?= htmlspecialchars($row['contact']) ?></td>
                <td class="actions">
                    <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                    <a href="../appointments/add.php?patient_id=<?= $row['id'] ?>" class="appoint-btn">Make Appointment</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center;">No patients found.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
<?php include('../includes/footer.php'); ?>
</body>
</html>
