<?php
include_once('../config.php');
include_once('../dbConnection.php');

session_start();

function login($conn)
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
      !empty($_POST['email']) &&
      !empty($_POST['password'])
    ) {
      $email = $_POST['email'];
      $password = $_POST['password'];

      $sql_find = "SELECT * FROM `users` WHERE `email`='$email'";

      $result = $conn->query($sql_find);

      $row = $result->fetch_assoc();

      if (!$row) {
        header('Location: ' . PROJECT_ROOT . '/auth/login.php');
      }

      if (password_verify($password, $row['password'])) {
        $_SESSION['isLoggedIn'] = true;
        header('Location: ' . PROJECT_ROOT . '/dashboard');
      } else {
        die('Invalid password!');
      }
    } else {
      die('validation failed!');
    }
  }
}

function logout()
{
  session_destroy();
  header('Location: ' . PROJECT_ROOT . '/auth/login.php');
}

function register($conn)
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
      !empty($_POST['name']) &&
      !empty($_POST['email']) &&
      !empty($_POST['password']) &&
      !empty($_POST['confirm_password'])
    ) {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $confirm_password = $_POST['confirm_password'];

      if ($password !== $confirm_password) {
        header("Location: " . PROJECT_ROOT . "/auth/register.php");
      }

      $hash_password = password_hash($password, PASSWORD_BCRYPT);

      $sql_insert = "INSERT INTO `users` (`name`, `email`, `password`) VALUES ('$name', '$email', '$hash_password')";

      $conn->query($sql_insert);

      header('Location: ' . PROJECT_ROOT . '/auth/login.php');
    } else {
      die('validation failed!');
    }
  }
}

$action = $_GET['action'];

switch ($action) {
  case 'login':
    login($conn);
    break;
  case 'logout':
    logout();
    break;
  case 'register':
    register($conn);
    break;
  default:
    //code block
}