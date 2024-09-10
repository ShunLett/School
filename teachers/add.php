<?php include_once('../partials/header.php'); ?>

<?php
  $insert_id = '';
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['education'])) {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $education = $_POST['education'];

      $sql_insert = "INSERT INTO `teachers` (`name`, `email`, `education`) VALUES ('$name', '$email', '$education')";

      $result_insert = $conn->query($sql_insert);

      $insert_id = $conn->insert_id;

      $teacher_id = 'T' . str_pad($insert_id, 3, '0', STR_PAD_LEFT);

      $sql_update = "UPDATE `teachers` SET teacher_id='$teacher_id' WHERE id=$insert_id";

      $result_update = $conn->query($sql_update);
    }
    else {
      die('validation failed!');
    }
  }
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Teachers</h1>
  </div>

  <h2>
    <a href="<?= PROJECT_ROOT ?>/teachers" type="button" class="btn btn-sm btn-outline-secondary">
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
            <input type="text" name="name" class="form-control" />
          </div>
        </div>
        <div class="row">
          <div class="col-3">Email (<span class="text-danger">*</span>)</div>
          <div class="col-7 fw-bold">
            <input type="email" name="email" class="form-control" />
          </div>
        </div>
        <div class="row">
          <div class="col-3">Education(<span class="text-danger">*</span>)</div>
          <div class="col-7 fw-bold">
            <textarea name="education" class="form-control"></textarea>
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