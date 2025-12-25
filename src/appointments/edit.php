<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

include('../includes/db.php');

$id = $_GET['id'] ?? 0;

// Fetch appointment
$appointment = $conn->query("SELECT * FROM appointments WHERE id = $id")->fetch_assoc();
if (!$appointment) {
    die("Appointment not found.");
}

// Fetch dropdown values
$patients = $conn->query("SELECT id, name FROM patients");
$doctors = $conn->query("SELECT id, name FROM doctors");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $date = $_POST['appointment_date'];
    $notes = $_POST['notes'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE appointments SET patient_id=?, doctor_id=?, appointment_date=?, notes=?, status=? WHERE id=?");
    $stmt->bind_param("iisssi", $patient_id, $doctor_id, $date, $notes, $status, $id);

    if ($stmt->execute()) {
        header("Location: list.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Appointment</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div id="form-container">
    <a href="list.php" class="back-btn">← Back to Appointment List</a>

    <h2>Edit Appointment</h2>
    <form method="POST">
        <label>Select Patient:</label>
        <select name="patient_id" required>
            <?php while ($p = $patients->fetch_assoc()): ?>
                <option value="<?= $p['id'] ?>" <?= ($p['id'] == $appointment['patient_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Select Doctor:</label>
        <select name="doctor_id" required>
            <?php while ($d = $doctors->fetch_assoc()): ?>
                <option value="<?= $d['id'] ?>" <?= ($d['id'] == $appointment['doctor_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($d['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Appointment Date & Time:</label>
        <input type="datetime-local" name="appointment_date" value="<?= date('Y-m-d\TH:i', strtotime($appointment['appointment_date'])) ?>" required>

        <label>Status:</label>
        <select name="status" required>
            <option value="Scheduled" <?= ($appointment['status'] === 'Scheduled') ? 'selected' : '' ?>>Scheduled</option>
            <option value="Completed" <?= ($appointment['status'] === 'Completed') ? 'selected' : '' ?>>Completed</option>
            <option value="Cancelled" <?= ($appointment['status'] === 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
        </select>

        <label>Notes:</label>
        <textarea name="notes" rows="4"><?= htmlspecialchars($appointment['notes']) ?></textarea>

        <button type="submit">Update Appointment</button>
    </form>
</div>
</body>
</html>
