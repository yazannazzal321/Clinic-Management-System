<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include('includes/db.php');

// Count records
$patients = $conn->query("SELECT COUNT(*) AS total FROM patients")->fetch_assoc()['total'];
$doctors = $conn->query("SELECT COUNT(*) AS total FROM doctors")->fetch_assoc()['total'];
$appointments = $conn->query("SELECT COUNT(*) AS total FROM appointments")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Clinic Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f1f1f1;
            padding: 10px 20px;
            margin-bottom: 20px;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <div class="top-bar">
        <div>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></div>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div id="dashboard">
        <h1>Clinic Management Dashboard</h1>

        <div class="stats">
            <div class="box doctors">👨‍⚕️ Doctors <span><?= $doctors ?></span></div>
            <div class="box patients">🧑‍🤝‍🧑 Patients <span><?= $patients ?></span></div>
            <div class="box appointments">📅 Appointments <span><?= $appointments ?></span></div>
        </div>

        <div class="nav-links">
            <a href="doctors/list.php">Manage Doctors</a>
            <a href="patients/list.php">Manage Patients</a>
            <a href="appointments/list.php">Manage Appointments</a>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>     
</body>

</html>
