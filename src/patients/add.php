<?php
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];

    $stmt = $conn->prepare("INSERT INTO patients (name, dob, gender, contact) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $dob, $gender, $contact);

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
    <title>Add Patient</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div id="form-container">

    <!-- Button to go to list page -->
    <a href="list.php" style="
        display: inline-block;
        margin-bottom: 15px;
        background-color: #007BFF;
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 5px;
    ">← View All Patients</a>

    <!-- Success Message -->
    <?php if ($success): ?>
        <div style="color: green; margin-bottom: 15px;">✅ Patient added successfully.</div>
    <?php endif; ?>

    <h2>Add New Patient</h2>
    <form method="POST" action="">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Date of Birth:</label><br>
        <input type="date" name="dob" required><br><br>

        <label>Gender:</label><br>
        <select name="gender" required>
            <option value="">--Select--</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br><br>

        <label>Contact:</label><br>
        <input type="text" name="contact" required><br><br>

        <button type="submit">Add Patient</button>
    </form>
</div>
<?php include('../includes/footer.php'); ?>
</body>
</html>
