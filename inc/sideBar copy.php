<?php $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav" style="color:black !important">
            <a class="nav-link <?= $page == 'index.php' ? 'active' : '' ?>" href="index.php">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <a class="nav-link collapsed <?= $page == 'allProduct.php' || $page == 'allProductCreate.php' || $page == 'allProductEdit.php' || $page == 'allProductDetail.php' || $page == 'borrowCreate.php' || $page == 'takeuse.php' || $page == 'productStatus.php' || $page == 'borrow.php' || $page == 'borrowHistory.php' ? 'active' : '' ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div>
                បញ្ជីសម្ភារ
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?= $page == 'allProduct.php' || $page == 'allProductCreate.php' || $page == 'allProductEdit.php' || $page == 'allProductDetail.php' || $page == 'borrowCreate.php' || $page == 'takeuse.php' || $page == 'productStatus.php' || $page == 'borrow.php' || $page == 'borrowHistory.php' ? 'show' : '' ?>" id="collapseLayouts2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link <?= $page == 'allProduct.php' || $page == 'allProductCreate.php' || $page == 'allProductEdit.php' || $page == 'allProductDetail.php' || $page == 'borrowCreate.php' || $page == 'takeuse.php' || $page == 'productStatus.php' ? 'active' : '' ?>" href="./allProduct.php"><i class="fa-solid fa-minus"></i> សម្ភារសរុប <?php if ($_SESSION["userType"] != 'guest') { ?> និងបន្ថែមសម្ភារ <?php } ?></a>
                    <?php
                    if ($_SESSION["userType"] !== 'guest') { ?>
                        <a class="nav-link <?= $page == 'borrow.php' || $page == 'borrowHistory.php' ? 'active' : '' ?>" href="./borrow.php"><i class="fa-solid fa-minus"></i> បញ្ចីខ្ចី</a>
                    <?php } ?>
                </nav>
            </div>
            <?php
            if ($_SESSION["userType"] == 'admin') { ?>
                <a class="nav-link <?= $page == 'usersList.php' ? 'active' : '' ?>" href="./usersList.php"><i class="fa-solid fa-circle-user"></i> បញ្ជីអ្នកប្រើប្រាស់</a>

                <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#userslist" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        អ្នកប្រើប្រាស់
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="userslist" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="./usersList.php"><i class="fa-solid fa-circle-user"></i>  បញ្ជីអ្នកប្រើប្រាស់</a>
                    
                    </nav>
                </div>                -->
            <?php } else {
            } ?>
            <a class="nav-link  <?= $page == 'report.php' ? 'active' : '' ?>" href="./report.php"><i class="fa-regular fa-newspaper"></i> របាយការណ៍</a>
            <?php
            if ($_SESSION["userType"] !== 'guest') { ?>
                <a class="nav-link collapsed  
                    <?=
                    $page == 'account.php' || $page == 'accountCreate.php' || $page == 'accountEdit.php' ||
                        $page == 'sub_account.php' || $page == 'sub_accountCreate.php' || $page == 'sub_accountEdit.php' ||
                        $page == 'productName.php' || $page == 'productNameCreate.php' || $page == 'productNameEdit.php' ||
                        $page == 'country.php' || $page == 'countryCreate.php' || $page == 'countryEdit.php' ||
                        $page == 'think.php' || $page == 'thinkCreate.php' || $page == 'thinkEdit.php' ||
                        $page == 'place.php' || $page == 'placeCreate.php' || $page == 'placeEdit.php' ||
                        $page == 'skill.php' || $page == 'skillCreate.php' || $page == 'skillEdit.php'
                        ? 'active' : '' ?>"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="true" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    បន្ថែម
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?=
                                        $page == 'account.php' || $page == 'accountCreate.php' || $page == 'accountEdit.php' ||
                                            $page == 'sub_account.php' || $page == 'sub_accountCreate.php' || $page == 'sub_accountEdit.php' ||
                                            $page == 'productName.php' || $page == 'productNameCreate.php' || $page == 'productNameEdit.php' ||
                                            $page == 'country.php' || $page == 'countryCreate.php' || $page == 'countryEdit.php' ||
                                            $page == 'think.php' || $page == 'thinkCreate.php' || $page == 'thinkEdit.php' ||
                                            $page == 'place.php' || $page == 'placeCreate.php' || $page == 'placeEdit.php' ||
                                            $page == 'skill.php' || $page == 'skillCreate.php' || $page == 'skillEdit.php'
                                            ? 'show' : '' ?>" id="collapseLayouts" aria-labelledby="" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'account.php' || $page == 'accountCreate.php' || $page == 'accountEdit.php'  ? 'active' : '' ?>" href="./account.php"><i class="fa-solid fa-minus"></i> គណនី</a>
                        <a class="nav-link <?= $page == 'sub_account.php' || $page == 'sub_accountCreate.php' || $page == 'sub_accountEdit.php'  ? 'active' : '' ?>" href="./sub_account.php"><i class="fa-solid fa-minus"></i> អនុគណនី</a>
                        <a class="nav-link <?= $page == 'productName.php' || $page == 'productNameCreate.php' || $page == 'productNameEdit.php'  ? 'active' : '' ?>" href="./productName.php"><i class="fa-solid fa-minus"></i> ឈ្មោះសម្ភារ</a>
                        <a class="nav-link <?= $page == 'country.php' || $page == 'countryCreate.php' || $page == 'countryEdit.php'  ? 'active' : '' ?>" href="./country.php"><i class="fa-solid fa-minus"></i> ប្រទេសផលិត</a>
                        <a class="nav-link <?= $page == 'think.php' || $page == 'thinkCreate.php' || $page == 'thinkEdit.php'  ? 'active' : '' ?>" href="./think.php"><i class="fa-solid fa-minus"></i> ឯកតា</a>
                        <a class="nav-link <?= $page == 'place.php' || $page == 'placeCreate.php' || $page == 'placeEdit.php'  ? 'active' : '' ?>" href="./place.php"><i class="fa-solid fa-minus"></i> ទីកន្លែង</a>
                        <a class="nav-link <?= $page == 'skill.php' || $page == 'skillCreate.php' || $page == 'skillEdit.php'  ? 'active' : '' ?>" href="./skill.php"><i class="fa-solid fa-minus"></i> ជំនាញ</a>
                        <!-- <a class="nav-link" href=""><i class="fa-solid fa-minus"></i> អ្នកប្រើប្រាស់</a> -->
                    </nav>
                </div>
            <?php } else {
            } ?>
            <!-- <a class="nav-link" href="./numberofrow.php"><i class="fa-regular fa-newspaper"></i>  កំណត់ចំនួនបង្ហាញ</a> -->
        </div>
    </div>

</nav>