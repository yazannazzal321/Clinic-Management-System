<?php
include('../includes/db.php');

$id = $_GET['id'];

// Fetch patient name
$patientResult = $conn->query("SELECT name FROM patients WHERE id = $id");
if ($patientResult->num_rows === 0) {
    echo "❌ Patient not found.";
    exit;
}
$patient = $patientResult->fetch_assoc();
$patientName = htmlspecialchars($patient['name']);

// Check for existing appointments
$result = $conn->query("SELECT COUNT(*) AS total FROM appointments WHERE patient_id = $id");
$count = $result->fetch_assoc()['total'];

if ($count > 0 && !isset($_GET['force'])) {
    // Show confirmation warning with patient's name
    echo "
        <div style='font-family:Arial;padding:20px;max-width:600px;margin:40px auto;border:1px solid #ccc;border-radius:8px;background:#fff;text-align:center;'>
            <h3 style='color:red;'>❌ Cannot delete patient</h3>
            <p>Patient <strong>$patientName</strong> has <strong>$count</strong> existing appointment(s).</p>
            <p>Are you sure you want to delete <strong>$patientName</strong> and all their appointments?</p>
            <a href='delete.php?id=$id&force=1' style='
                background-color:#dc3545;
                color:white;
                padding:10px 20px;
                text-decoration:none;
                border-radius:5px;
                margin-right:10px;
                display:inline-block;'>Yes, delete anyway</a>
            <a href='list.php' style='
                background-color:#6c757d;
                color:white;
                padding:10px 20px;
                text-decoration:none;
                border-radius:5px;
                display:inline-block;'>Cancel</a>
        </div>
    ";
    exit;
}

// If confirmed or no appointments, proceed to delete
$conn->query("DELETE FROM appointments WHERE patient_id = $id");
$conn->query("DELETE FROM patients WHERE id = $id");

header("Location: list.php");
exit;
?>
