<?php include_once('../partials/student_header.php'); ?> <!-- Using the new student-specific header -->
<?php
// Assuming session holds the student's ID
session_start();
$student_id = $_SESSION['student_id'];

// Fetch student information
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Fetch classes the student is enrolled in
$sql_classes = "SELECT classes.*, DATE_FORMAT(classes.time, '%h:%i %p') AS formatted_time 
                FROM `classes` 
                JOIN registrations ON registrations.class_id = classes.id 
                WHERE registrations.student_id = ?";
$stmt_classes = $conn->prepare($sql_classes);
$stmt_classes->bind_param("i", $student_id);
$stmt_classes->execute();
$result_classes = $stmt_classes->get_result();

// Fetch total credits and check certification eligibility
$sql_credits = "SELECT SUM(classes.credits) AS total_credits 
                FROM classes 
                JOIN registrations ON registrations.class_id = classes.id 
                WHERE registrations.student_id = ?";
$stmt_credits = $conn->prepare($sql_credits);
$stmt_credits->bind_param("i", $student_id);
$stmt_credits->execute();
$result_credits = $stmt_credits->get_result();
$credits_row = $result_credits->fetch_assoc();
$total_credits = $credits_row['total_credits'] ?? 0;
$is_certified = ($total_credits >= 25) ? 'Yes' : 'No';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Welcome, <?= htmlspecialchars($student['first_name'].' '.$student['last_name'], ENT_QUOTES, 'UTF-8') ?></h1>
  </div>

  <!-- Display Certification Status -->
  <div class="alert alert-info">
    <strong>Eligible for Certificate:</strong> <?= htmlspecialchars($is_certified, ENT_QUOTES, 'UTF-8') ?>
  </div>

  <!-- Display enrolled classes -->
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>Your Enrolled Classes</h3>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">Class ID</th>
          <th scope="col">Class Name</th>
          <th scope="col">Credits</th>
          <th scope="col">Time</th>
          <th scope="col">Start Date</th>
          <th scope="col">End Date</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row_class = $result_classes->fetch_assoc()) { ?>
          <tr>
            <td><?= htmlspecialchars($row_class['id'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($row_class['name'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($row_class['credits'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($row_class['formatted_time'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($row_class['start_date'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($row_class['end_date'], ENT_QUOTES, 'UTF-8') ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</main>

<?php include_once('../partials/footer.php'); ?>
