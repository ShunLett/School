<?php include_once('../partials/header.php'); ?>
<?php include_once('../config.php'); // Include your database connection file ?>

<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Student ID is required.');
}

$student_id = $_GET['id'];

// Fetch existing student details
$sql = "SELECT * FROM `students` WHERE `id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id); // Use "i" for integer type
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die('Student not found.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];

        // Use current date for enrollment_date
        $enrollment_date = date('Y-m-d');

        $sql_update = "UPDATE `students` SET `first_name` = ?, `last_name` = ?, `email` = ?, `enrollment_date` = ? WHERE `id` = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssi", $first_name, $last_name, $email, $enrollment_date, $student_id);
        $stmt_update->execute();

        if ($stmt_update->affected_rows > 0) {
            echo 'Student updated successfully.';
        } else {
            echo 'No changes made.';
        }
    } else {
        echo 'Please fill in all fields.';
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <a href="<?= PROJECT_ROOT ?>/students/index.php" type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            Edit Student
        </h1>
    </div>

    <form method="post">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="<?= htmlspecialchars($student['first_name'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="<?= htmlspecialchars($student['last_name'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</main>

<?php include_once('../partials/footer.php'); ?>