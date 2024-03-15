<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from pix-placewise.vercel.app/service.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 29 Oct 2023 19:25:10 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="landing page starter kit">
    <meta name="keywords" content="bootstrap 5, saas, landing page">
    <meta name="author" content="asaduzzaman">
    <title>Smartshule - <?php echo $template['title']; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet">

    <?php echo theme_css('fonts/material-icon.css'); ?>
    <?php echo theme_css('fonts/fontawesome.css'); ?>

    <?php echo theme_css('fonts/ff-1.css'); ?>
    <link rel="icon" href="<?php echo base_url() ?>assets/themes/iga/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../unpkg.com/leaflet%401.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="">

    <?php echo theme_css('plugins.css'); ?>
    <?php echo theme_css('style.css'); ?>
</head>

<body>
    <!-- preloader -->
    <div class="preloader">
        <div class="preloader__img">
            <img src="<?php echo base_url() ?>assets/themes/iga/img/favicon.png" alt="image">
        </div>
    </div>
    <!-- preloader End -->
    <!-- Header Top  -->
    <div class="py-5 border-bottom header-top bg-neutral-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="list list-row flex-wrap gap-3 align-items-center justify-content-between">
                        <li>
                            <a href="<?php echo base_url('iga')?>" class="link d-inline-block">
                                <img src="<?php echo base_url() ?>assets/themes/iga/img/favicon.png" alt="logo" class="logo d-xl-none">
                                <img src="<?php echo base_url() ?>uploads/files/<?php echo $this->school->document ?>" alt="logo" class="logo d-none d-xl-inline-block">
                            </a>
                        </li>
                        <li>
                            <ul class="list list-row flex-wrap align-items-center list-divider">
                                <li>
                                    <div class="d-flex align-items-center gap-5">
                                        <div class="w-10 h-10 rounded-circle bg-primary-300 d-grid place-content-center flex-shrink-0">
                                            <span class="material-symbols-outlined mat-icon fs-24 clr-neutral-0 fw-300"> phone_in_talk </span>
                                        </div>
                                        <div class="d-none d-lg-block">
                                            <span class="fs-12 d-block"> Free Call </span>
                                            <a href="tel:<?php echo $this->school->tel ?>" class="link d-block clr-neutral-700 :clr-primary-300"> <?php echo $this->school->tel ?> </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center gap-5">
                                        <div class="w-10 h-10 rounded-circle bg-secondary-300 d-grid place-content-center flex-shrink-0">
                                            <span class="material-symbols-outlined mat-icon fs-24 clr-neutral-700 fw-300"> mark_as_unread </span>
                                        </div>
                                        <div class="d-none d-lg-block">
                                            <span class="fs-12 d-block"> Online Support </span>
                                            <a href="mailto:<?php echo $this->school->email ?>" class="link d-block clr-neutral-700 :clr-primary-300"> <?php echo $this->school->email ?> </a>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Header Top  -->
    <!-- Header -->
    <header class="header header--sticky border-bottom bg-neutral-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="menu d-lg-flex justify-content-lg-between align-items-lg-center">
                        <div class="menu-mobile-nav d-flex align-items-center justify-content-between py-3 py-lg-0 order-lg-2">
                            <button class="menu-toggle w-10 h-10 p-0 border-0 lh-1 bg-primary-50 clr-primary-500 transition :clr-primary-50 :bg-primary-500 rounded-1 flex-shrink-0 order-2 order-lg-1 d-lg-none">
                                <span class="material-symbols-outlined mat-icon fs-28"> menu </span>
                            </button>
                            <ul class="list list-row gap-4 flex-wrap align-items-center order-1">


                                <li>
                                    <div class="dropdown">
                                        <a href="#" class="link d-inline-block" data-bs-toggle="dropdown" data-bs-offset="0,16">
                                            <img src="<?php echo base_url() ?>assets/themes/iga/img/user-1.jpg" alt="image" class="img-fluid w-10 h-10 rounded-circle objec-fit-cover">
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end p-0 border border-neutral-30">
                                            <div class="p-6">
                                                <div class="d-flex align-items-center gap-4 max-width">
                                                    <img src="<?php echo base_url() ?>assets/themes/iga/img/user-1.jpg" alt="image" class="img-fluid w-12 h-12 rounded-circle object-fit-cover flex-shrink-0">
                                                    <div class="flex-grow-1">
                                                        <h5 class="mb-0"><?php echo $this->user->first_name ?> <?php echo $this->user->last_name ?></h5>

                                                    </div>
                                                </div>
                                                <div class="hr-dashed mt-4 mb-2"></div>
                                                <ul class="list">
                                                    <li>
                                                        <a href="#" class="link d-flex align-items-center gap-3 clr-neutral-400 dropdown-item px-2">
                                                            <span class="material-symbols-outlined mat-icon fs-28 flex-shrink-0"> person </span>
                                                            <span class="d-block fs-14 fw-medium flex-grow-1"> My Account </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="link d-flex align-items-center gap-3 clr-neutral-400 dropdown-item px-2">
                                                            <span class="material-symbols-outlined mat-icon fs-28 flex-shrink-0"> event_note </span>
                                                            <span class="d-block fs-14 fw-medium flex-grow-1"> My Bookings </span>
                                                        </a>
                                                    </li>

                                                </ul>
                                                <div class="hr-dashed my-2"></div>
                                                <ul class="list">
                                                    <li>
                                                        <a href="#" class="link d-flex align-items-center gap-3 clr-neutral-400 dropdown-item px-2">
                                                            <span class="material-symbols-outlined mat-icon fs-28 flex-shrink-0"> info </span>
                                                            <span class="d-block fs-14 fw-medium flex-grow-1"> Help </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url('admin/logout') ?>" class="link d-flex align-items-center gap-3 clr-neutral-400 dropdown-item px-2">
                                                            <span class="material-symbols-outlined mat-icon fs-28 flex-shrink-0"> exit_to_app </span>
                                                            <span class="d-block fs-14 fw-medium flex-grow-1"> Log out </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <ul class="list list-lg-row menu-nav order-lg-1">
                            <li class="menu-list current-page">
                                <a href="<?php echo base_url('iga')?>" class="link menu-link "> Home </a>
                                
                            </li>
      
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- /Header -->
    <!-- Service -->
    <section class="auth-container auth-container--max overflow-hidden">
       <?php echo $template['body']?>
    </section>
    <!-- /Service -->

    <div class="section-space--sm-bottom bg-primary-5p pt-3">
        <div class="section-space--sm-bottom">
            <div class="container">
            </div>
        </div>
    </div>

    <div class="bg-neutral-900">

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="py-8 border-top border-primary-500">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-6">
                                <p class="m-0 clr-neutral-0 text-center text-lg-start"> Copyright &copy; <?php echo date('Y') ?> <span class="clr-tertiary-300"><?php echo $this->school->school ?></span>. Designed By <a href="https://smartshule.com" class="link clr-secondary-300" target="_blank">Smartshule</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Footer -->
    <!-- scrpts -->
    <script src="../unpkg.com/leaflet%401.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <?php echo theme_js('plugins.js'); ?>
    <?php echo theme_js('app.js'); ?>
</body>


<!-- Mirrored from pix-placewise.vercel.app/service.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 29 Oct 2023 19:25:10 GMT -->

</html>