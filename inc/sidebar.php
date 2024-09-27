<?php
// Define the current page URL
$current_menu = basename($_SERVER['PHP_SELF']);
?>

<!-- Sidebar -->
<ul style="background:#185519;" class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div>
            <!-- <i class="fas fa-laugh-wink"></i> -->
            <img style="width: 50px;" class="fas fa-laugh-wink" src="../assets/img/logo_ksit.PNG" alt="">
        </div>
        <div class="sidebar-brand-text mx-3">CBDMS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li <?= ($current_menu == "index.php") ? 'class="nav-item active"' : 'class="nav-item"' ?>>
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li <?= ($current_menu == "list_corn_breeding_data.php" || $current_menu == "add_corn_breeding_data.php" || $current_menu == "edit_corn_breeding_data.php") ? 'class="nav-item active"' : 'class="nav-item"' ?>>
        <a class="nav-link" href="list_corn_breeding_data.php">

            <i class="fas fa-database"></i>
            <span>បញ្ជីទិន្នន័យបង្កាត់ពូជពោត</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li <?= ($current_menu == "compare_corn_breeding_data.php") ? 'class="nav-item active"' : 'class="nav-item"' ?>>
        <a class="nav-link" href="compare_corn_breeding_data.php">

            <i class="fa-solid fa-code-compare"></i>

            <span>ប្រៀបធៀបពូជពោត</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li <?= ($current_menu == "list_corn_varieties.php") ? 'class="nav-item active"' : 'class="nav-item"' ?>>
        <a class="nav-link" href="list_corn_varieties.php">
            <i class="fa fa-database" aria-hidden="true"></i>
            <span>បញ្ជីពូជពោត</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li <?= ($current_menu == "list_users.php" || $current_menu == "edit_users.php" || $current_menu == "add_users.php") ? 'class="nav-item active"' : 'class="nav-item"' ?>>
        <a class="nav-link" href="list_users.php">

            <i class="fas fa-users"></i>
            <span>បញ្ជីអ្នកប្រើប្រាស់</span></a>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>
<!-- End of Sidebar -->