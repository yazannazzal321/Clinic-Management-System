<?php
include('../includes/db.php');

$id = $_GET['id'];
$doctor = $conn->query("SELECT * FROM doctors WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $contact = $_POST['contact'];

    $stmt = $conn->prepare("UPDATE doctors SET name=?, specialty=?, contact=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $specialty, $contact, $id);

    if ($stmt->execute()) {
        header("Location: list.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
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
    <title>Edit Doctor</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div id="form-box">
    <!-- <a href="list.php" style="display:inline-block; margin-bottom:15px; background-color:#007BFF; color:white; padding:10px 15px; text-decoration:none; border-radius:5px;">← Back to Doctors</a> -->
        <a href="list.php" class="back-btn">← Back to Doctors</a>

    <h2>Edit Doctor</h2>
    <form method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($doctor['name']) ?>" required><br><br>

        <label>Specialty:</label><br>
        <input type="text" name="specialty" value="<?= htmlspecialchars($doctor['specialty']) ?>" required><br><br>

        <label>Contact:</label><br>
        <input type="text" name="contact" value="<?= htmlspecialchars($doctor['contact']) ?>" required><br><br>

        <button type="submit">Update Doctor</button>
    </form>
</div>
</body>
</html>
