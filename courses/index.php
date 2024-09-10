<?php include_once('../partials/header.php'); ?>

<?php
  $sql = "SELECT * FROM `courses`";

  $result = $conn->query($sql);

  if (!$result) {
    die('query failed: ' . $conn->error);
  }
  function getCourses($conn) {
    $sql = "SELECT * FROM `courses`";
    $result = $conn->query($sql);
    if (!$result) {
        die('query failed: ' . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Courses</h1>
    <a href="<?= PROJECT_ROOT ?>/courses/add.php" type="button" class="btn btn-sm btn-outline-secondary">
      <span data-feather="plus"></span>
      Create New
    </a>
  </div>

  <h2>Listing</h2>
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">Course ID</th>
          <th scope="col">Name</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?= $row['course_id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['description'] ?></td>
            <td>
              <a href="<?= PROJECT_ROOT ?>/courses/edit.php?id=<?= $row['id'] ?>" class="btn btn-warning">
              <i class="fa-solid fa-pen-to-square"></i>
              </a>
              <a href="<?= PROJECT_ROOT ?>/courses/delete.php?id=<?= $row['id'] ?>" class="btn btn-danger">
              <i class="fa-solid fa-trash"></i>
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</main>

<?php include_once('../partials/footer.php'); ?>