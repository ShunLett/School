<?php include_once('../partials/header.php'); ?>
<?php include_once('../config.php'); // Include your database connection file ?>

<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Teacher ID is required.');
}

$teacher_id = $_GET['id'];

// Fetch existing teacher details
$sql = "SELECT * FROM `teachers` WHERE `id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$teacher = $result->fetch_assoc();

if (!$teacher) {
    die('Teacher not found.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['education'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $education = $_POST['education'];

        // Update teacher details
        $sql_update = "UPDATE `teachers` SET `name` = ?, `email` = ?, `education` = ? WHERE `id` = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssss", $name, $email, $education, $teacher_id);
        $stmt_update->execute();

        if ($stmt_update->affected_rows > 0) {
            echo 'Teacher updated successfully.';
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
            <a href="<?= PROJECT_ROOT ?>/teachers" type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            Edit Teacher
        </h1>
    </div>

    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($teacher['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($teacher['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="education" class="form-label">Education</label>
            <textarea name="education" id="education" class="form-control" required><?= htmlspecialchars($teacher['education']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</main>

<?php include_once('../partials/footer.php'); ?>