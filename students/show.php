<?php include_once('../partials/header.php'); ?>

<?php
  if (!isset($_GET['id'])) {
    header('Location: index.php');
  }

  $id = $_GET['id'];

  $sql = "SELECT * FROM students WHERE id=$id";

  $result = $conn->query($sql);

  $row = $result->fetch_assoc();

  if (!$row) {
    header('Location: index.php');
  }

  $sql_classes = "SELECT * FROM `classes` JOIN registrations ON registrations.class_id = classes.id WHERE registrations.student_id = $id";

  $result_classes = $conn->query($sql_classes);

  if (!$result_classes) {
    die('query failed: ' . $conn->error);
  }
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Students</h1>
  </div>

  <h2>
    <a href="<?= PROJECT_ROOT ?>/students" type="button" class="btn btn-sm btn-outline-secondary">
    <i class="fa-solid fa-arrow-left"></i>
    </a>
    Detail
  </h2>
  <div class="row my-5">
    <div class="col-6">
      <div class="row">
        <div class="col-3">Name</div>
        <div class="col-7 fw-bold"><?= $row['first_name'].' '.$row['last_name'] ?></div>
      </div>
      <div class="row mt-2">
        <div class="col-3">Email</div>
        <div class="col-7 fw-bold"><?= $row['email'] ?></div>
      </div>
      <div class="row mt-2">
        <div class="col-3">Enrollment Date</div>
        <div class="col-7 fw-bold"><?= $row['enrollment_date'] ?></div>
      </div>
    </div>
  </div>

  <hr/>

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>Attended Classes</h3>
    <button type="button" class="btn btn-sm btn-outline-secondary">
      <span data-feather="plus"></span>
      Enroll Class
    </button>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Start Date</th>
          <th scope="col">End Date</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row_class = $result_classes->fetch_assoc()) { ?>
          <tr>
            <td><?= $row_class['id'] ?></td>
            <td>
              <a href="<?= PROJECT_ROOT ?>/classes/show.php?id=<?= $row_class['id'] ?>">
                <?= $row_class['name'] ?>
              </a>
            </td>
            <td>Aug 01, 2024</td>
            <td>Sep 30, 2024</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</main>

<?php include_once('../partials/footer.php'); ?>