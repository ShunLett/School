<?php
$url = $_SERVER['REQUEST_URI'];

$segments = explode('/', trim($url, '/'));

if (strpos($url, 'index.php') === false) {
    $module = $segments[count($segments) - 1];
} else {
    $module = $segments[count($segments) - 2];
}
?>
<nav id="studentSidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= $module == 'index.php' ? 'active' : '' ?>" href="<?= PROJECT_ROOT ?>/studentsdashboard/index.php">
                    <i class="fa-solid fa-house"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $module == 'assignments.php' ? 'active' : '' ?>" href="<?= PROJECT_ROOT ?>/studentsdashboard/assignments.php">
                    <i class="fa-solid fa-clipboard-list"></i>
                    Assignments
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $module == 'grades.php' ? 'active' : '' ?>" href="<?= PROJECT_ROOT ?>/studentsdashboard/grades.php">
                    <i class="fa-solid fa-graduation-cap"></i>
                    Grades
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $module == 'resources.php' ? 'active' : '' ?>" href="<?= PROJECT_ROOT ?>/studentsdashboard/resources.php">
                    <i class="fa-solid fa-book-open"></i>
                    Resources
                </a>
            </li>
        </ul>
    </div>
</nav>
