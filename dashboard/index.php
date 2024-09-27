<?php include_once('../partials/header.php'); ?>

<?php
// Fetch total counts
$totalStudents = $conn->query("SELECT COUNT(*) as count FROM `students`")->fetch_assoc()['count'];
$totalTeachers = $conn->query("SELECT COUNT(*) as count FROM `teachers`")->fetch_assoc()['count'];
$totalCourses = $conn->query("SELECT COUNT(*) as count FROM `courses`")->fetch_assoc()['count'];
$totalClasses = $conn->query("SELECT COUNT(*) as count FROM `classes`")->fetch_assoc()['count'];

// Fetch latest entries
$latestStudents = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) as name FROM `students` ORDER BY id DESC LIMIT 5");
$latestCourses = $conn->query("SELECT id, name FROM `courses` ORDER BY id DESC LIMIT 5");
$latestClasses = $conn->query("SELECT id, name FROM `classes` ORDER BY id DESC LIMIT 5");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
  </div>

  <!-- Statistics Overview -->
  <div class="row">
    <div class="col-md-3">
      <div class="card mb-3" style="background-color: #d0e4ff; color: #004085; border: none; transition: transform 0.2s;">
        <div class="card-header">Students</div>
        <div class="card-body">
          <h5 class="card-title"><?= $totalStudents ?></h5>
          <p class="card-text">Total Students</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card mb-3" style="background-color: #d4edda; color: #155724; border: none; transition: transform 0.2s;">
        <div class="card-header">Teachers</div>
        <div class="card-body">
          <h5 class="card-title"><?= $totalTeachers ?></h5>
          <p class="card-text">Total Teachers</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card mb-3" style="background-color: #cde5f0; color: #0c5460; border: none; transition: transform 0.2s;">
        <div class="card-header">Courses</div>
        <div class="card-body">
          <h5 class="card-title"><?= $totalCourses ?></h5>
          <p class="card-text">Total Courses</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card mb-3" style="background-color: #fff3cd; color: #856404; border: none; transition: transform 0.2s;">
        <div class="card-header">Classes</div>
        <div class="card-body">
          <h5 class="card-title"><?= $totalClasses ?></h5>
          <p class="card-text">Total Classes</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Latest Entries -->
   <hr>
  <div class="row">
    <div class="col-md-4">
      <h4>Latest Students</h4>
      <ul class="list-group">
        <?php while ($student = $latestStudents->fetch_assoc()): ?>
          <li class="list-group-item">
            <a href="<?= PROJECT_ROOT ?>/students/show.php?id=<?= $student['id'] ?>">
              <?= htmlspecialchars($student['name']) ?>
            </a>
          </li>
        <?php endwhile; ?>
      </ul>
    </div>
    <div class="col-md-4">
      <h4>Latest Courses</h4>
      <ul class="list-group">
        <?php while ($course = $latestCourses->fetch_assoc()): ?>
          <li class="list-group-item">
            <a href="<?= PROJECT_ROOT ?>/courses/index.php?id=<?= $course['id'] ?>">
              <?= htmlspecialchars($course['name']) ?>
            </a>
          </li>
        <?php endwhile; ?>
      </ul>
    </div>
    <div class="col-md-4">
      <h4>Latest Classes</h4>
      <ul class="list-group">
        <?php while ($class = $latestClasses->fetch_assoc()): ?>
          <li class="list-group-item">
            <a href="<?= PROJECT_ROOT ?>/classes/index.php?id=<?= $class['id'] ?>">
              <?= htmlspecialchars($class['name']) ?>
            </a>
          </li>
        <?php endwhile; ?>
      </ul>
    </div>
  </div>
</main>

<style>
  .card:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }
</style>

<?php include_once('../partials/footer.php'); ?>
