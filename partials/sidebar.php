
<?php
  $url = $_SERVER['REQUEST_URI'];

  // Split the URL by '/' and get the second-to-last segment
  $segments = explode('/', trim($url, '/'));

  if (strpos($url, 'index.php') === false) {
    $module = $segments[count($segments) - 1];
  } else {
    $module = $segments[count($segments) - 2];
  }
?>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link <?= $module == 'dashboard' ? 'active' : '' ?>" aria-current="page" href="<?= PROJECT_ROOT ?>/dashboard">
          <span data-feather="home"></span>
          Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $module == 'teachers' ? 'active' : '' ?>" href="<?= PROJECT_ROOT ?>/teachers">
          <i class="fa-solid fa-chalkboard-user"></i>
          Teachers
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $module == 'courses' ? 'active' : '' ?>" href="<?= PROJECT_ROOT ?>/courses">
        <i class="fa-solid fa-book"></i>
          Courses
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $module == 'classes' ? 'active' : '' ?>" href="<?= PROJECT_ROOT ?>/classes">
        <i class="fa-solid fa-school"></i>
        
          Classes
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $module == 'students' ? 'active' : '' ?>" href="<?= PROJECT_ROOT ?>/students">
        <i class="fa-solid fa-user"></i>
          Students
        </a>
      </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>Saved reports</span>
      <a class="link-secondary" href="#" aria-label="Add a new report">
        <span data-feather="plus-circle"></span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="file-text"></span>
          Current month
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="file-text"></span>
          Year-end sale
        </a>
      </li>
    </ul>
  </div>
</nav>