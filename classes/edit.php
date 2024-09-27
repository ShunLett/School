<?php include_once('../partials/header.php'); ?>
<?php include_once('../config.php'); ?>

<?php

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Class ID is required.');
}

$class_id = $_GET['id'];

// Fetch the class details
$sql_class = "SELECT * FROM `classes` WHERE `id` = ?";
$stmt_class = $conn->prepare($sql_class);
$stmt_class->bind_param("i", $class_id);
$stmt_class->execute();
$result_class = $stmt_class->get_result();
$class = $result_class->fetch_assoc();

if (!$class) {
    die('Class not found.');
}

// Fetch teachers
$sql_teachers = "SELECT id, name FROM `teachers`";
$result_teachers = $conn->query($sql_teachers);

if (!$result_teachers) {
    die('Query failed: ' . $conn->error);
}

// Fetch courses
$sql_courses = "SELECT id, name FROM `courses`";
$result_courses = $conn->query($sql_courses);

if (!$result_courses) {
    die('Query failed: ' . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['name']) && !empty($_POST['teacher_id']) && !empty($_POST['course_id']) && !empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['time']) && !empty($_POST['credits'])) {
        $name = $_POST['name'];
        $teacher_id = $_POST['teacher_id'];
        $course_id = $_POST['course_id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $time = $_POST['time'];
        $credits = $_POST['credits'];
      
        $sql_update = "UPDATE `classes` SET `name` = ?, `teacher_id` = ?, `course_id` = ?, `start_date` = ?, `end_date` = ?, `time` = ?, `credits` = ? WHERE `id` = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssssssi", $name, $teacher_id, $course_id, $start_date, $end_date, $time, $credits, $class_id);
        $stmt_update->execute();

        if ($stmt_update->affected_rows > 0) {
            echo 'Class updated successfully.';
        } else {
            echo 'No changes made or error occurred.';
        }
    } else {
        echo 'Please fill in all fields.';
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <a href="<?= PROJECT_ROOT ?>/classes" type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            Edit Class
        </h1>
    </div>

    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($class['name'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="mb-3">
            <label for="teacher_id" class="form-label">Teacher</label>
            <select name="teacher_id" id="teacher_id" class="form-control" required>
                <option value="">Select Teacher</option>
                <?php while ($teacher = $result_teachers->fetch_assoc()) { ?>
                    <option value="<?= htmlspecialchars($teacher['id'], ENT_QUOTES, 'UTF-8') ?>" <?= $teacher['id'] == $class['teacher_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($teacher['name'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="credits" class="form-label">Credits</label>
            <input type="number" name="credits" id="credits" class="form-control" value="<?= htmlspecialchars($class['credits'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="mb-3">
            <label for="course_id" class="form-label">Course</label>
            <select name="course_id" id="course_id" class="form-control" required>
                <option value="">Select Course</option>
                <?php while ($course = $result_courses->fetch_assoc()) { ?>
                    <option value="<?= htmlspecialchars($course['id'], ENT_QUOTES, 'UTF-8') ?>" <?= $course['id'] == $class['course_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($course['name'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= htmlspecialchars($class['start_date'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="<?= htmlspecialchars($class['end_date'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="mb-3">
            <label for="time" class="form-label">Time</label> 
            <input type="time" class="form-control" id="time" name="time" value="<?= htmlspecialchars($class['time'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</main>

<?php include_once('../partials/footer.php'); ?>
