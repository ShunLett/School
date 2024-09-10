<?php
include_once('../config.php');
include_once('../dbConnection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="School Management System">
  <meta name="generator" content="Hugo 0.84.0">
  <title>School Management System</title>

  <!-- Bootstrap core CSS -->
  <link href="<?= PROJECT_ROOT ?>/assets/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom Styles -->
  <style>
    body {
      background-color: #e9f5ff; /* Light blue background */
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .register-container {
      background: white;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .register-container h2 {
      color: #007bff; /* Blue color for header */
      font-weight: 700;
      margin-bottom: 20px;
    }

    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }

    .btn-primary:hover {
      background-color: #0056b3; /* Darker blue on hover */
      border-color: #0056b3;
    }
  </style>

  <!-- Favicons -->
  <link rel="icon" href="<?= PROJECT_ROOT ?>/assets/img/favicons/favicon.ico">
  <meta name="theme-color" content="#007bff">
</head>

<body>
  <div class="register-container">
    <form action="<?= PROJECT_ROOT ?>/auth/process.php?action=register" method="POST">
      <h2 class="text-center">Registration Form</h2>
      <div class="mb-3">
        <label for="inputName" class="form-label">Name</label>
        <input name="name" type="text" class="form-control" id="inputName" required>
      </div>
      <div class="mb-3">
        <label for="inputEmail" class="form-label">Email</label>
        <input name="email" type="email" class="form-control" id="inputEmail" required>
      </div>
      <div class="mb-3">
        <label for="inputPassword" class="form-label">Password</label>
        <input name="password" type="password" class="form-control" id="inputPassword" required>
      </div>
      <div class="mb-3">
        <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
        <input name="confirm_password" type="password" class="form-control" id="inputConfirmPassword" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
  </div>

  <script src="<?= PROJECT_ROOT ?>/assets/bootstrap.bundle.min.js"></script>
</body>

</html>
