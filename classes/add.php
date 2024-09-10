<?php include_once('../partials/header.php'); ?>
<?php include_once('../config.php'); ?>

<?php
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['name']) && !empty($_POST['teacher_id']) && !empty($_POST['course_id']) && !empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        $name = $_POST['name'];
        $teacher_id = $_POST['teacher_id'];
        $course_id = $_POST['course_id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        // Insert new class record
        $sql_insert = "INSERT INTO `classes` (`name`, `teacher_id`, `course_id`, `start_date`, `end_date`) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sssss", $name, $teacher_id, $course_id, $start_date, $end_date);

        if ($stmt_insert->execute()) {
            echo 'Class created successfully.';
            header('Location: ' . PROJECT_ROOT . '/classes');
            exit();
        } else {
            echo 'Insertion failed: ' . $stmt_insert->error;
        }
    } else {
        die('Please fill in all fields.');
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Classes</h1>
    </div>

    <h2>
        <a href="<?= PROJECT_ROOT ?>/classes" type="button" class="btn btn-sm btn-outline-secondary">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        Create New
    </h2>
    <div class="row my-5">
        <form method="post">
            <div class="col-6 d-grid gap-2">
                <div class="row">
                    <div class="col-3">Name (<span class="text-danger">*</span>)</div>
                    <div class="col-7 fw-bold">
                        <input type="text" name="name" class="form-control" required />
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">Teacher (<span class="text-danger">*</span>)</div>
                    <div class="col-7 fw-bold">
                        <select name="teacher_id" class="form-control" required>
                            <option value="">Select Teacher</option>
                            <?php while ($teacher = $result_teachers->fetch_assoc()) { ?>
                                <option value="<?= htmlspecialchars($teacher['id'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($teacher['name'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">Course (<span class="text-danger">*</span>)</div>
                    <div class="col-7 fw-bold">
                        <select name="course_id" class="form-control" required>
                            <option value="">Select Course</option>
                            <?php while ($course = $result_courses->fetch_assoc()) { ?>
                                <option value="<?= htmlspecialchars($course['id'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($course['name'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">Start Date (<span class="text-danger">*</span>)</div>
                    <div class="col-7 fw-bold">
                        <input type="date" name="start_date" class="form-control" required />
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">End Date (<span class="text-danger">*</span>)</div>
                    <div class="col-7 fw-bold">
                        <input type="date" name="end_date" class="form-control" required />
                    </div>
                </div>
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-7">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

<?php include_once('../partials/footer.php'); ?>