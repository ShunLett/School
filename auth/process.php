<?php
include_once('../config.php');
include_once('../dbConnection.php');

session_start();

function login($conn)
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

          
            $sql_find = "SELECT * FROM `users` WHERE `email`='$email'";
            $result = $conn->query($sql_find);
            $row = $result->fetch_assoc();

            if (!$row) {
                die('User does not exist.');
            }

           
            if (password_verify($password, $row['password'])) {
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['usertype'] = $row['usertype'];
                $_SESSION['email'] = $row['email']; 

              
                $sql_student = "SELECT id FROM `students` WHERE `email` = ?";
                $stmt_student = $conn->prepare($sql_student);
                $stmt_student->bind_param("s", $email);
                $stmt_student->execute();
                $result_student = $stmt_student->get_result();
                $student = $result_student->fetch_assoc();

                if ($student) {
                    $_SESSION['student_id'] = $student['id']; 
                } else {
                    $_SESSION['student_id'] = null; 
                }

                // Redirect 
                if ($row['usertype'] == 'admin') {
                    header('Location: ' . PROJECT_ROOT . '/dashboard');
                } else {
                    header('Location: ' . PROJECT_ROOT . '/studentsdashboard');
                }
            } else {
                die('Invalid password!');
            }
        } else {
            die('Please fill all fields.');
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
                die('Passwords do not match.');
            }

           
            $hash_password = password_hash($password, PASSWORD_BCRYPT);

            // Set default usertype to 'user'
            $usertype = 'user';

            // SQL to insert the new user
            $sql_insert = "INSERT INTO `users` (`name`, `email`, `password`, `usertype`) VALUES ('$name', '$email', '$hash_password', '$usertype')";

            if ($conn->query($sql_insert) === TRUE) {
                // Redirect to login page after successful registration
                header('Location: ' . PROJECT_ROOT . '/auth/login.php');
            } else {
                die('Error: ' . $conn->error);
            }
        } else {
            die('Please fill all fields.');
        }
    }
}


$action = $_GET['action'] ?? '';

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
        die('Invalid action.');
}
?>
