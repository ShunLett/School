<?php include_once('../partials/header.php'); ?>

<?php
if (!isset($_GET['id'])) {
    header('Location: index.php');
}

$id = $_GET['id'];

$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    header('Location: index.php');
    exit();
}

// Fetch attended classes
$sql_classes = "SELECT classes.*, registrations.*, DATE_FORMAT(classes.time, '%h:%i %p') AS formatted_time FROM `classes` 
                JOIN registrations ON registrations.class_id = classes.id 
                WHERE registrations.student_id = ?";
$stmt_classes = $conn->prepare($sql_classes);
$stmt_classes->bind_param("i", $id);
$stmt_classes->execute();
$result_classes = $stmt_classes->get_result();

$sql_credits = "SELECT SUM(classes.credits) AS total_credits 
                FROM classes 
                JOIN registrations ON registrations.class_id = classes.id 
                WHERE registrations.student_id = ?";
$stmt_credits = $conn->prepare($sql_credits);
$stmt_credits->bind_param("i", $id);
$stmt_credits->execute();
$result_credits = $stmt_credits->get_result();
$credits_row = $result_credits->fetch_assoc();
$total_credits = $credits_row['total_credits'] ?? 0;
$is_certified = ($total_credits >= 25) ? 'Yes' : 'No';

// Fetch available classes
$sql_available_classes = "SELECT * FROM `classes` WHERE id NOT IN (SELECT class_id FROM registrations WHERE student_id = ?)";
$stmt_available_classes = $conn->prepare($sql_available_classes);
$stmt_available_classes->bind_param("i", $id);
$stmt_available_classes->execute();
$result_available_classes = $stmt_available_classes->get_result();

// Handle class enrollment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
    $sql_enroll = "INSERT INTO registrations (student_id, class_id) VALUES (?, ?)";
    $stmt_enroll = $conn->prepare($sql_enroll);
    $stmt_enroll->bind_param("ii", $id, $class_id);

    if ($stmt_enroll->execute()) {
        header("Location: show.php?id=$id");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Failed to enroll in the class.</div>";
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Student Details</h1>
  </div>

  <h2>
    <a href="<?= PROJECT_ROOT ?>/students/index.php" type="button" class="btn btn-sm btn-outline-secondary">
      <i class="fa-solid fa-arrow-left"></i>
      Back to List
    </a>
  </h2>

  <div class="row my-5">
    <div class="col-6">
      <div class="row">
        <div class="col-3">Name</div>
        <div class="col-7 fw-bold"><?= htmlspecialchars($row['first_name'].' '.$row['last_name'], ENT_QUOTES, 'UTF-8') ?></div>
      </div>
      <div class="row mt-2">
        <div class="col-3">Email</div>
        <div class="col-7 fw-bold"><?= htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') ?></div>
      </div>
      <div class="row mt-2">
        <div class="col-3">Credits</div>
        <div class="col-7 fw-bold"><?= htmlspecialchars($total_credits, ENT_QUOTES, 'UTF-8') ?></div>
    </div>
    <div class="row mt-2">
        <div class="col-3">Certified</div>
        <div class="col-7 fw-bold"><?= htmlspecialchars($is_certified, ENT_QUOTES, 'UTF-8') ?></div>
    </div>

      <div class="row mt-2">
        <div class="col-3">Enrollment Date</div>
        <div class="col-7 fw-bold"><?= htmlspecialchars($row['enrollment_date'], ENT_QUOTES, 'UTF-8') ?></div>
      </div>
    </div>
  </div>

  <hr/>

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>Attended Classes</h3>
    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#enrollClassModal">
      <span data-feather="plus"></span>
      Enroll Class
    </button>
  </div>
  
  <div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
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
          <td>
            <a href="<?= PROJECT_ROOT ?>/classes/show.php?id=<?= htmlspecialchars($row_class['id'], ENT_QUOTES, 'UTF-8') ?>">
              <?= htmlspecialchars($row_class['name'], ENT_QUOTES, 'UTF-8') ?>
            </a>
          </td>
          <td><?= htmlspecialchars($row_class['credits'], ENT_QUOTES, 'UTF-8') ?></td> 
          <td><?= htmlspecialchars($row_class['formatted_time'], ENT_QUOTES, 'UTF-8') ?></td> 
          <td><?= htmlspecialchars($row_class['start_date'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($row_class['end_date'], ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

  <div class="modal fade" id="enrollClassModal" tabindex="-1" aria-labelledby="enrollClassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="">
          <div class="modal-header">
            <h5 class="modal-title" id="enrollClassModalLabel">Enroll in a Class</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="class_id">Select Class</label>
              <select name="class_id" id="class_id" class="form-control" required>
                <?php while ($available_class = $result_available_classes->fetch_assoc()) { ?>
                  <option value="<?= htmlspecialchars($available_class['id'], ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($available_class['name'], ENT_QUOTES, 'UTF-8') ?>
                  </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Enroll</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<?php include_once('../partials/footer.php'); ?>