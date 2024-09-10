<?php include_once('../partials/header.php'); ?>
<?php include_once('../config.php'); // Include your database connection file ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        
        // Automatically set enrollment date to current date
        $enrollment_date = date('Y-m-d'); // Format: YYYY-MM-DD

        // Use prepared statements to prevent SQL injection
        $sql_insert = "INSERT INTO `students` (`first_name`, `last_name`, `email`, `enrollment_date`) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssss", $first_name, $last_name, $email, $enrollment_date);
        $stmt_insert->execute();

        if ($stmt_insert->affected_rows > 0) {
            echo 'Student added successfully.';
        } else {
            echo 'Failed to add student.';
        }
    } else {
        echo 'Please fill in all fields.';
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Student</h1>
  </div>

  <h2>
    <a href="<?= PROJECT_ROOT ?>/students/index.php" type="button" class="btn btn-sm btn-outline-secondary">
      <i class="fa-solid fa-arrow-left"></i>
      Back to List
    </a>
  </h2>

  <div class="row my-5">
    <form method="post">
      <div class="col-6 d-grid gap-2">
        <div class="row mb-3">
          <div class="col-3">First Name (<span class="text-danger">*</span>)</div>
          <div class="col-7">
            <input type="text" name="first_name" class="form-control" required />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-3">Last Name (<span class="text-danger">*</span>)</div>
          <div class="col-7">
            <input type="text" name="last_name" class="form-control" required />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-3">Email (<span class="text-danger">*</span>)</div>
          <div class="col-7">
            <input type="email" name="email" class="form-control" required />
          </div>
        </div>
        <div class="row">
          <div class="col-3"></div>
          <div class="col-7">
            <button type="submit" class="btn btn-primary">Add Student</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</main>

<?php include_once('../partials/footer.php'); ?>