<?php
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $contact = $_POST['contact'];

    $stmt = $conn->prepare("INSERT INTO doctors (name, specialty, contact) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $specialty, $contact);

    if ($stmt->execute()) {
        header("Location: add.php?success=1");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
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
    <title>Add Doctor</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div id="form-container">

    <a href="list.php" style="display:inline-block; margin-bottom:15px; background-color:#007BFF; color:white; padding:10px 15px; text-decoration:none; border-radius:5px;">← View All Doctors</a>

    <?php if ($success): ?>
        <div style="color: green; margin-bottom: 15px;">✅ Doctor added successfully.</div>
    <?php endif; ?>

    <h2>Add New Doctor</h2>
    <form method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Specialty:</label><br>
        <input type="text" name="specialty" required><br><br>

        <label>Contact:</label><br>
        <input type="text" name="contact" required><br><br>

        <button type="submit">Add Doctor</button>
    </form>
</div>
<?php include('../includes/footer.php'); ?>
</body>
</html>
