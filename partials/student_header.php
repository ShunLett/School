<?php
  include_once('../config.php');
  include_once('../dbconnection.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="School Management System">
  <meta name="generator" content="Hugo 0.84.0">
  <title>Student Dashboard</title>

  <link href="<?= PROJECT_ROOT ?>/assets/bootstrap.min.css" rel="stylesheet"/>

  <link rel="icon" href="<?= PROJECT_ROOT ?>/assets/img/favicons/favicon.ico">
  <meta name="theme-color" content="#7952b3">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>

  <link href="<?= PROJECT_ROOT ?>/assets/dashboard.css" rel="stylesheet"/>
</head>

<body>

  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">SYNC</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-nav px-3">
      <form action="<?= PROJECT_ROOT ?>/auth/process.php?action=logout" method="POST" style="display:inline;">
        <button type="submit" class="btn btn-sm btn-outline-secondary me-2">
          Logout
        </button>
      </form>
    </div>
  </header>
  <div class="container-fluid">
    <div class="row">
      <?php include_once('student_sidebar.php'); ?>