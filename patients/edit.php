<?php
include('../includes/db.php');

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM patients WHERE id = $id");
$patient = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];

    $stmt = $conn->prepare("UPDATE patients SET name=?, dob=?, gender=?, contact=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $dob, $gender, $contact, $id);

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
    <title>Edit Patient</title>
    <link rel="stylesheet" href="../css/style.css">
    <script>
        function confirmUpdate() {
            return confirm("Are you sure you want to save changes?");
        }
    </script>
</head>
<body>
    <div id="form-box">
        <a href="list.php" class="back-btn">← Back to Patients</a>

        <h2>Edit Patient</h2>

        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($patient['name']) ?>" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="<?= $patient['dob'] ?>" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?= $patient['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $patient['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
            </select>

            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($patient['contact']) ?>" required>

            <button type="submit">Confirm & Update</button>
        </form>
    </div>
</body>
</html>
