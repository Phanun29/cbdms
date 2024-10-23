<?php
// Define the current page URL
$current_menu = basename($_SERVER['PHP_SELF']);
?>

<!-- Sidebar -->
<ul style="background:#185519; transition: 0.5s;" class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div>
            <img style="width: 50px;" src="../assets/img/logo_ksit.PNG" alt="">
        </div>
        <div class="sidebar-brand-text mx-3">KSIT</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li <?= ($current_menu == "index.php") ? 'class="nav-item active"' : 'class="nav-item"' ?>>
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Corn Breeding Data -->
    <li <?= ($current_menu == "list_corn_breeding_data.php" || $current_menu == "add_corn_breeding_data.php" || $current_menu == "edit_corn_breeding_data.php" ||  $current_menu === "view_corn_breeding_data.php") ? 'class="nav-item active"' : 'class="nav-item"' ?>>
        <a class="nav-link" href="list_corn_breeding_data.php">
            <i class="fas fa-database"></i>
            <span>បញ្ជីទិន្នន័យបង្កាត់ពូជពោត</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Compare Corn Breeding Data -->
    <li <?= ($current_menu == "compare_corn_breeding_data.php") ? 'class="nav-item active"' : 'class="nav-item"' ?>>
        <a class="nav-link" href="compare_corn_breeding_data.php">
            <i class="fa-solid fa-code-compare"></i>
            <span>ប្រៀបធៀបពូជពោត</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Corn Varieties -->
    <li class="nav-item <?= ($current_menu == "list_of_original_corn_varieties.php" || $current_menu == "list_of_hybrid_corn_varieties.php") ? 'active' : '' ?>">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseCornVarieties" aria-expanded="<?= ($current_menu == "list_of_original_corn_varieties.php" || $current_menu == "list_of_hybrid_corn_varieties.php") ? 'true' : 'false' ?>">
            <i class="fa fa-database" aria-hidden="true"></i>
            <span>បញ្ជីពូជពោត</span>
        </a>
        <div id="collapseCornVarieties" class="collapse <?= ($current_menu == "list_of_original_corn_varieties.php" || $current_menu == "list_of_hybrid_corn_varieties.php") ? 'show' : '' ?>" aria-labelledby="headingCornVarieties" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?= ($current_menu == "list_of_original_corn_varieties.php") ? 'active' : '' ?>" href="list_of_original_corn_varieties.php">បញ្ជីពូជពោតដើម</a>
                <a class="collapse-item <?= ($current_menu == "list_of_hybrid_corn_varieties.php") ? 'active' : '' ?>" href="list_of_hybrid_corn_varieties.php">បញ្ជីពូជពោតបង្កាត់</a>
            </div>
        </div>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <?php
    $user_type = $fetch_info['user_type'];
    if ($user_type == "admin") { ?>
        <!-- Nav Item - Users -->
        <li <?= ($current_menu == "list_users.php" || $current_menu == "edit_users.php" || $current_menu == "add_users.php") ? 'class="nav-item active"' : 'class="nav-item"' ?>>
            <a class="nav-link" href="list_users.php">
                <i class="fas fa-users"></i>
                <span>បញ្ជីអ្នកប្រើប្រាស់</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <!-- <hr class="sidebar-divider d-none d-md-block"> -->
    <?php  } ?>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none mt-2 d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->