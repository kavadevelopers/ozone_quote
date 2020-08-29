<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <nav class="pcoded-navbar">
            <div class="pcoded-inner-navbar main-menu">
                <div class="pcoded-navigatio-lavel">Navigation</div>
                <ul class="pcoded-item pcoded-left-item">
                    <li class="<?= menu(1,["dashboard"])[0]; ?>">
                        <a href="<?= base_url('dashboard') ?>">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>
                </ul>

                <ul class="pcoded-item pcoded-left-item">
                    <li class="<?= menu(1,["quotation"])[0]; ?>">
                        <a href="<?= base_url('quotation') ?>">
                            <span class="pcoded-micon"><i class="fa fa-industry"></i></span>
                            <span class="pcoded-mtext">Quotation</span>
                        </a>
                    </li>
                </ul>

                <ul class="pcoded-item pcoded-left-item">
                    <li class="<?= menu(1,["products"])[0]; ?>">
                        <a href="<?= base_url('products') ?>">
                            <span class="pcoded-micon"><i class="fa fa-product-hunt"></i></span>
                            <span class="pcoded-mtext">Products</span>
                        </a>
                    </li>
                </ul>

                <ul class="pcoded-item pcoded-left-item">
                    <li class="<?= menu(1,["manufacturer"])[0]; ?>">
                        <a href="<?= base_url('manufacturer') ?>">
                            <span class="pcoded-micon"><i class="fa fa-id-card-o"></i></span>
                            <span class="pcoded-mtext">Manufacturer</span>
                        </a>
                    </li>
                </ul>

                <ul class="pcoded-item pcoded-left-item">
                    <li class="<?= menu(1,["import"])[0]; ?>">
                        <a href="<?= base_url('import') ?>">
                            <span class="pcoded-micon"><i class="fa fa-file-excel-o"></i></span>
                            <span class="pcoded-mtext">Upload Products</span>
                        </a>
                    </li>
                </ul>

                <ul class="pcoded-item pcoded-left-item">
                    <li class="">
                        <a href="<?= base_url('login/logout') ?>">
                            <span class="pcoded-micon"><i class="feather icon-log-out"></i></span>
                            <span class="pcoded-mtext">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">