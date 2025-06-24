<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

include('../includes/db.php');

// Use LEFT JOIN to avoid hiding appointments with missing patient/doctor references
$sql = "SELECT a.id, 
               p.name AS patient_name, 
               d.name AS doctor_name, 
               a.appointment_date, 
               a.notes,
               a.status
        FROM appointments a
        LEFT JOIN patients p ON a.patient_id = p.id
        LEFT JOIN doctors d ON a.doctor_id = d.id
        ORDER BY a.appointment_date DESC";

$result = $conn->query($sql);
if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Appointment List</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .back-btn {
            display: inline-block;
            margin-bottom: 15px;
            background-color: #6c757d;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .add-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 10px;
        }

        .actions a {
            display: inline-block;
            padding: 5px 10px;
            margin-right: 5px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 0.9em;
        }

        .edit-btn {
            background-color: #17a2b8;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .status {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div id="list-box">
        <a href="../index.php" class="back-btn">← Back to Dashboard</a>
        <a href="add.php" class="add-btn">➕ Add New Appointment</a>

        <h2 style="margin-top: 20px;">All Appointments</h2>

        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date & Time</th>
                <th>Status</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['patient_name'] ?? 'Unknown') ?></td>
                        <td><?= htmlspecialchars($row['doctor_name'] ?? 'Unknown') ?></td>
                        <td><?= $row['appointment_date'] ?></td>
                        <td class="status"><?= htmlspecialchars($row['status']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['notes'])) ?></td>
                        <td class="actions">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">No appointments found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
<?php include('../includes/footer.php'); ?>
</body>
</html>
