<?php include_once('../partials/header.php'); ?>
<?php include_once('../config.php'); // Include your database connection file ?>

<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Course ID is required.');
}

$course_id = $_GET['id'];

$sql = "SELECT * FROM `courses` WHERE `id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $course_id); // Use "s" for VARCHAR type
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();

if (!$course) {
    die('Course not found.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['name']) && !empty($_POST['description'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];

        $sql_update = "UPDATE `courses` SET  `name` = ?, `description` = ? WHERE `id` = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sss", $name, $description, $course_id);
        $stmt_update->execute();

        if ($stmt_update->affected_rows > 0) {
            echo 'Course updated successfully.';
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
            <a href="<?= PROJECT_ROOT ?>/courses" type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            Edit Class
        </h1>
    </div>

    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($course['name'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description" id="description" class="form-control" value="<?= htmlspecialchars($course['description'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</main>

<?php include_once('../partials/footer.php'); ?>