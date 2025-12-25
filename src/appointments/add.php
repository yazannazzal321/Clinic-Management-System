<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

include('../includes/db.php');

// Get doctor_id and patient_id from URL if provided
$selected_doctor_id = isset($_GET['doctor_id']) ? (int)$_GET['doctor_id'] : 0;
$selected_patient_id = isset($_GET['patient_id']) ? (int)$_GET['patient_id'] : 0;

// Get patients and doctors for dropdowns
$patients = $conn->query("SELECT id, name FROM patients");
$doctors = $conn->query("SELECT id, name FROM doctors");

$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $date = $_POST['appointment_date'];
    $notes = $_POST['notes'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, notes, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $patient_id, $doctor_id, $date, $notes, $status);

    if ($stmt->execute()) {
        header("Location: add.php?success=1");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$success = isset($_GET['success']) && $_GET['success'] == 1;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Appointment</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div id="form-container">

    <a href="list.php" class="back-btn">← View All Appointments</a>

    <?php if ($success): ?>
        <div style="color: green; margin-bottom: 15px;">✅ Appointment added successfully.</div>
    <?php endif; ?>

    <h2>Add Appointment</h2>
    <form method="POST">
        <label>Select Patient:</label><br>
        <select name="patient_id" required>
            <option value="">-- Select Patient --</option>
            <?php while ($p = $patients->fetch_assoc()): ?>
                <option value="<?= $p['id'] ?>" <?= ($p['id'] == $selected_patient_id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['name']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Select Doctor:</label><br>
        <select name="doctor_id" required>
            <option value="">-- Select Doctor --</option>
            <?php while ($d = $doctors->fetch_assoc()): ?>
                <option value="<?= $d['id'] ?>" <?= ($d['id'] == $selected_doctor_id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($d['name']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Appointment Date & Time:</label><br>
        <input type="datetime-local" name="appointment_date" required><br><br>

        <label>Notes:</label><br>
        <textarea name="notes" rows="4" style="width:100%;"></textarea><br><br>

        <label>Status:</label><br>
        <select name="status" required>
            <option value="Scheduled">Scheduled</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
        </select><br><br>

        <button type="submit">Add Appointment</button>
    </form>
</div>
<?php include('../includes/footer.php'); ?>
</body>
</html>
