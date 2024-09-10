<?php
include_once('../partials/header.php'); // Include header
include_once('../config.php'); // Include your database connection file

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Class ID is required.');
}

$class_id = $_GET['id'];

// Prepare SQL statement to prevent SQL injection
$sql = "DELETE FROM `classes` WHERE `id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $class_id);

// Execute the statement
if ($stmt->execute()) {
    // Redirect with a success message
    header("Location: index.php?delete=success");
} else {
    // Redirect with a failure message
    header("Location: index.php?delete=failure");
}

$stmt->close(); // Close the statement
$conn->close(); // Close the database connection
exit();
?>