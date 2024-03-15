<!DOCTYPE html>
<html lang="en" data-footer="true" data-color="light-blue" data-override='{"attributes": {"placement": "horizontal","radius":"flat", "layout": "boxed" }, "storagePrefix": "service-provider"}'>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Smartshule - <?php echo $template['title']; ?></title>
    <link rel="icon" type="image/png" href="img/favicon/favicon-32x32.png" sizes="32x32" />
    <?php echo theme_css('plugins/bootstrap.min.css'); ?>
    <?php echo theme_css('plugins/OverlayScrollbars.min.css'); ?>
    <?php echo theme_css('multiselect.css'); ?>
    <?php echo theme_css('styles.css'); ?>
    <?php echo theme_css('main.css'); ?>
    <?php echo theme_js('site/loader.js'); ?>

    <?php echo theme_js('offline.min.js'); ?>
    <script src="<?php echo base_url('assets/themes/admin/plugins/libs.js?t='); ?><?php echo time(); ?>"></script>
    <script>
        var BASE_URL = '<?php echo base_url(); ?>';
    </script>
</head>

<body class="modal-open">
    <div id="root">
        <div id="nav" class="nav-container d-flex">
            <div class="nav-content d-flex">
                <div class="logo position-relative">
                    <a href="<?php echo base_url('/') ?>">
                        <?php echo theme_image('jg.png', ['height' => '50']); ?>
                        <div class="img"></div>
                    </a>
                </div>

                <div class="user-container d-flex">
                    <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo theme_image('avatar/' . $this->user->avt . '/50.png', ['class' => 'profile avatar']); ?>
                        <div class="name"><b><?php echo $this->user->first_name . ' ' . $this->user->last_name ?></b><em class="sm-icon ni ni-chevron-down"></em></div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end user-menu wide">
                        <div class="row mb-3 ms-0 me-0">
                            

                            <div class="col-6 ps-1 pe-1">

                            </div>


                            <div class="col-6 ps-1 pe-1">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#">
                                            <i class="fe-help-circle" data-cs-size="17"></i>
                                            <span class="align-middle">Profile</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>


                        </div>

                        <div class="row mb-1 ms-0 me-0">
                            
                            <div class="col-6 ps-1 pe-1">

                            </div>
                            <div class="col-6 pe-1 ps-1">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="<?php echo base_url('transport/logout'); ?>">
                                            <i data-cs-icon="logout" class="me-2" data-cs-size="17"></i>
                                            <span class="align-middle">Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="list-unstyled list-inline text-center menu-icons">
                    <li class="list-inline-item">
                        <a href="#" id="colorButton">
                            <em class="icon ni ni-sun"></em>
                        </a>
                    </li>
                </ul>

                <div class="menu-container flex-grow-1">
                    <ul id="menu" class="menu show">
                        <li>
                            <a href="<?php echo base_url('/') ?>">
                                <?php echo theme_image('sm-logo.png', ['height' => '30 ']); ?>
                                <span class="label"><strong>SMARTSHULE</strong></span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mobile-buttons-container">
                    <a href="#" id="mobileMenuButton" class="menu-button">
                        <em class="icon ni ni-menu"></em>
                    </a>
                </div>
            </div>
            <div class="nav-shadow"></div>
        </div>

        <main>
            <div class="container">
                <div class="row">
                    <!-- Menu -->
                    <div class="col-auto d-none d-lg-flex">
                        <ul class="sw-25 side-menu mb-0 primary" id="menuSide">
                            <li>
                                <a href="<?php echo base_url('/') ?>">
                                    <em class="icon ni ni-home-alt"></em>
                                    <span class="label">Overview</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('/') ?>" data-bs-target="#services">
                                    <i data-cs-icon="grid-1" class="icon" data-cs-size="18"></i>
                                    <span class="label">Student Transport</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="javascript:void()" @click="show(1)">
                                            <em class="icon ni ni-user-add-fill"></em>
                                            <span class="label">Bus Checkin</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void()" @click="show(2)">
                                            <em class="icon ni ni-user-remove-fill"></em>
                                            <span class="label">Bus Checkout</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-bs-target="#account">
                                    <i data-cs-icon="user" class="icon" data-cs-size="18"></i>
                                    <span class="label">Account</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="<?php echo base_url('transport/profile')?>">
                                            <em class="icon ni ni-user-fill"></em>
                                            <span class="label">My Profile</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="col">
                        <?php echo $template['body']; ?>
                    </div>
                </div>
            </div>
        </main>

        <footer>
            <div class="footer-content">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <p class="mb-0 text-muted text-medium">Keypad <?php echo date('Y'); ?></p>
                        </div>
                        <div class="col-sm-6 d-none d-sm-block">
                            <ul class="breadcrumb pt-0 pe-0 mb-0 float-end">
                                <li class="breadcrumb-item mb-0 text-medium">
                                    <a href="#" target="_blank" class="btn-link">Review</a>
                                </li>
                                <li class="breadcrumb-item mb-0 text-medium">
                                    <a href="#" target="_blank" class="btn-link">Purchase</a>
                                </li>
                                <li class="breadcrumb-item mb-0 text-medium"><a href="#" class="btn-link">Docs</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <?php echo theme_js('vendor/jquery-3.5.1.min.js'); ?>
    <?php echo theme_js('vendor/bootstrap.bundle.min.js'); ?>
    <?php echo theme_js('vendor/OverlayScrollbars.min.js'); ?>
    <?php echo theme_js('site/helpers.js'); ?>
    <?php echo theme_js('site/globals.js'); ?>
    <?php echo theme_js('site/nav.js'); ?>
    <?php echo theme_js('site/settings.js'); ?>
    <?php echo theme_js('site/init.js'); ?>
</body>

</html>