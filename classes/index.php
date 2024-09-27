<?php

include_once('../partials/header.php');
$sqlClasses = "SELECT id, name, course_id, teacher_id, credits, DATE_FORMAT(time, '%h:%i %p') AS time, start_date, end_date FROM `classes`";
$resultClasses = $conn->query($sqlClasses);

if (!$resultClasses) {
    die('Query failed: ' . $conn->error);
}
$classes = $resultClasses->fetch_all(MYSQLI_ASSOC);

$sqlCourses = "SELECT id, name FROM `courses`";
$resultCourses = $conn->query($sqlCourses);

if (!$resultCourses) {
    die('Query failed: ' . $conn->error);
}
$courses = $resultCourses->fetch_all(MYSQLI_ASSOC);

$sqlTeachers = "SELECT id, name FROM `teachers`";
$resultTeachers = $conn->query($sqlTeachers);

if (!$resultTeachers) {
    die('Query failed: ' . $conn->error);
}
$teachers = $resultTeachers->fetch_all(MYSQLI_ASSOC);

$courseLookup = [];
foreach ($courses as $course) {
    $courseLookup[$course['id']] = $course['name'];
}

$teacherLookup = [];
foreach ($teachers as $teacher) {
    $teacherLookup[$teacher['id']] = $teacher['name'];
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Classes</title>
    <link rel="stylesheet" href="<?= PROJECT_ROOT ?>/path/to/your/css/styles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
</head>
<body>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Classes</h1>
            <a href="<?= PROJECT_ROOT ?>/classes/add.php" type="button" class="btn btn-sm btn-outline-secondary">
                <span data-feather="plus"></span>
                Create New
            </a>
        </div>

        <h2>Listing</h2>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Course</th>
                        <th scope="col">Teacher</th>
                        <th scope="col">Credits</th> 
                        <th scope="col">Time</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($classes as $class): ?>
                        <tr>
                            <td><?= htmlspecialchars($class['name']) ?></td>
                            <td><?= htmlspecialchars($courseLookup[$class['course_id']] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($teacherLookup[$class['teacher_id']] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($class['credits'] ?? 'N/A') ?></td> 
                            <td><?= htmlspecialchars($class['time'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($class['start_date']) ?></td>
                            <td><?= htmlspecialchars($class['end_date']) ?></td>
                            <td>
                                <a href="<?= PROJECT_ROOT ?>/classes/edit.php?id=<?= $class['id'] ?>" class="btn btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="<?= PROJECT_ROOT ?>/classes/delete.php?id=<?= $class['id'] ?>" class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include_once('../partials/footer.php'); ?>
</body>
</html>
