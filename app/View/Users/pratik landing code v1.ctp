<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hope Landing Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        #Logo {
            color: #ca2a2a;
        }

        #heroCarousel {

            margin-top: 7px;
        }

        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .carousel-item img {
            height: 500px;
            object-fit: cover;
        }

        .image-gallery img {
            height: 150px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .image-gallery img:hover {
            transform: scale(1.1);
        }

        .contact-form {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .carousel-item {
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .carousel-item-next,
        .carousel-item-prev,
        .carousel-item.active {
            opacity: 1;
        }

        #heroCarousel {
            position: relative;
            width: 100%;
            height: auto;
        }

        * footer section start */ * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -o-box-sizing: border-box;
            -ms-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            font-size: 14px;
            background: #fff;
            max-width: 1920px;
            margin: 0 auto;
            overflow-x: hidden;
            font-family: poppins;


        }

        .navbar-brand {
            font-size: 40px;
            font-weight: 600;
        }

        .auto-size {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            /* Ensures the image fits within the given dimensions while maintaining aspect ratio */
        }

        .fontsize {
            font-size: 15px;
        }

        /* css for dropdown options start */
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            display: none;
        }

        .dropdown-submenu:hover .dropdown-menu {
            display: block;
        }

        /* css for dropdown options end */
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fontsize" style="background-color: #323949; border-bottom: 3px solid #6351ce;">

        <div class="container">
            <a class="navbar-brand" id="Logo">DrM Hope</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                style="filter: invert(1);">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                            style="color: white;">Home</a>

                    </li>
                    <li class="nav-item">
                        <?php echo $this->Html->link(
                            'About Us',
                            ['controller' => 'pages', 'action' => 'about_us'],
                            ['escape' => false, 'class' => 'nav-link', 'style' => 'color: white;']
                        ); ?>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#nogo" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" style="color: white;">Solutions</a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#nogo">Ambulatory Solutions</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <?php echo $this->Html->link('Patient Portal', array('controller' => 'pages', 'action' => 'patient_portal'), array('class' => 'dropdown-item', 'escape' => false)); ?>
                                    </li>
                                    <li>
                                        <?php echo $this->Html->link('Ambulatory EMR', array('controller' => 'pages', 'action' => 'ambulatory_emr'), array('class' => 'dropdown-item', 'escape' => false)); ?>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#nogo">Hospital Solutions</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <?php echo $this->Html->link('Hospital Information Management', array('controller' => 'pages', 'action' => 'hosptal_info_manage'), array('class' => 'dropdown-item', 'escape' => false)); ?>
                                    </li>
                                    <li>
                                        <?php echo $this->Html->link('Inpatient EMR', array('controller' => 'pages', 'action' => 'impatient_emr'), array('class' => 'dropdown-item', 'escape' => false)); ?>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#nogo">Public Sector Solutions</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <?php echo $this->Html->link('Public Health', array('controller' => 'pages', 'action' => 'public_health'), array('class' => 'dropdown-item', 'escape' => false)); ?>
                                    </li>
                                    <li>
                                        <?php echo $this->Html->link('Telemedecine', array('controller' => 'pages', 'action' => 'telemedecine'), array('class' => 'dropdown-item', 'escape' => false)); ?>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#nogo">Specility Solutions</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <?php echo $this->Html->link('OT Scheduling and Management', array('controller' => 'pages', 'action' => 'ot_s_m'), array('class' => 'dropdown-item', 'escape' => false)); ?>
                                    </li>
                                    <li>
                                        <?php echo $this->Html->link('Dental', array('controller' => 'pages', 'action' => 'dental'), array('class' => 'dropdown-item', 'escape' => false)); ?>
                                    </li>
                                    <li>
                                        <?php echo $this->Html->link('Physiotherapy', array('controller' => 'pages', 'action' => 'physio'), array('class' => 'dropdown-item', 'escape' => false)); ?>
                                    </li>
                                    <li>
                                        <?php echo $this->Html->link('Obestrics/Gynacology', array('controller' => 'pages', 'action' => 'obest_gyna'), array('class' => 'dropdown-item', 'escape' => false)); ?>
                                    </li>
                                    <li>
                                        <?php echo $this->Html->link('Opthalmology', array('controller' => 'pages', 'action' => 'opth'), array('class' => 'dropdown-item', 'escape' => false)); ?>
                                    </li>
                                    <li>
                                        <?php echo $this->Html->link('Oncology', array('controller' => 'pages', 'action' => 'oncology'), array('class' => 'dropdown-item', 'escape' => false)); ?>
                                    </li>
                                    <li>
                                        <?php echo $this->Html->link('Cardiology', array('controller' => 'pages', 'action' => 'cardio'), array('class' => 'dropdown-item', 'escape' => false)); ?>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <?php echo $this->Html->link('EHR Software', array('controller' => 'pages', 'action' => 'ehr-software'), array('class' => 'dropdown-item', 'escape' => false)); ?>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <?php echo $this->Html->link(
                            'Handout',
                            array('controller' => 'pages', 'action' => 'drm-brochure'),
                            array(
                                'class' => 'nav-link',
                                'style' => 'color: white;',
                                'escape' => false
                            )
                        ); ?>
                    </li>

                    <li class="nav-item dropdown">
                        <?php echo $this->Html->link(
                            'Services',
                            array('controller' => 'pages', 'action' => 'service'),
                            array('escape' => false, 'class' => 'nav-link dropdown-toggle', 'role' => 'button', 'data-bs-toggle' => 'dropdown', 'aria-expanded' => 'false', 'style' => 'color: white;')
                        ); ?>
                        <ul class="dropdown-menu">
                            <li>
                                <?php echo $this->Html->link(
                                    'Consulting and Implementations',
                                    array('controller' => 'pages', 'action' => 'consulting_implement'),
                                    array('class' => 'dropdown-item', 'escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(
                                    'Healthcare IT Services',
                                    array('controller' => 'pages', 'action' => 'healthcare_itservice'),
                                    array('class' => 'dropdown-item', 'escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(
                                    'Healthcare Application Training Services',
                                    array('controller' => 'pages', 'action' => 'hats'),
                                    array('class' => 'dropdown-item', 'escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(
                                    'Infrastructure Support Services',
                                    array('controller' => 'pages', 'action' => 'infra_support'),
                                    array('class' => 'dropdown-item', 'escape' => false)
                                ); ?>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" style="color: white;">Partners</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'partnership']); ?>">Partnerships</a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'be_our_partner']); ?>">Be
                                    Our Partner</a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" style="color: white;">Company</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'comp_awards_certi']); ?>">Awards
                                    and Events</a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'certification']); ?>">Certifications</a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'faq']); ?>">FAQ</a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'story_so_far']); ?>">Story
                                    So Far</a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" style="color: white;">Benefits</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'free_emr']); ?>">Free
                                    EMR</a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'web_based']); ?>">Web
                                    Based</a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'earn_money']); ?>">Earn
                                    stimulus money</a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'emr-software']); ?>">EMR
                                    Software</a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'stay_secure']); ?>">Stay
                                    secure</a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'emr_comparison']); ?>">EMR
                                    Comparison</a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'support']); ?>">Unlimited
                                    Support</a>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#"
                                    data-bs-toggle="dropdown">Innovations</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item"
                                            href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'adverse_events']); ?>">Adverse
                                            event</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'support_portal']); ?>">Support
                                            portal</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'language_interpreters']); ?>">Language
                                            interpreter video/voice</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'smartroom']); ?>">Smartest
                                            room</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'vap_monitor']); ?>">VAP
                                            quality monitor</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'dshbrd']); ?>">Dashboards</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#signInModal">Sign In</button>
            </div>
        </div>
    </nav>

    <!-- Hero Image Carousel -->

    <style>
        #heroCarousel .carousel-item {
            height: 500px;
            /* Adjust height as needed */
            background-size: cover;
            background-position: center;
        }

        #heroCarousel .carousel-caption {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }
    </style>

    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
        <div class="carousel-item" style="background-image: url('<?php echo $this->Html->url('/img/new_landing/tech2.jpg', true); ?>');">
        <div class="carousel-caption">
                    <h1>Welcome to Hope Hospital</h1>
                    <p>Providing timely help when you need it most.</p>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('<?php echo $this->Html->url('/img/new_landing/dna.jpg', true); ?>');">
                <div class="carousel-caption">
                    <h1>Expert Medical Assistance</h1>
                    <p>Our Expert team is here to ensure your Health.</p>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url(<?php echo $this->Html->url('/img/new_landing/tech.jpg', true); ?>);">
                <div class="carousel-caption">
                    <h1>Reliable Health care Services</h1>
                    <p></p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signInModalLabel">Sign In</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo $this->Form->create('User', array('id' => 'loginForm', 'action' => 'login')); ?>

                <div class="mb-3">
                    <label for="username" class="form-label"><strong>Username / Patient ID</strong></label>
                    <?php echo $this->Form->input('username', array(
                        'class' => 'form-control validate[required,custom[mandatory-enter]]',
                        'id' => 'username',
                        'div' => false,
                        'label' => false,
                        'placeholder' => 'Enter your username or Patient ID'
                    )); ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label"><strong>Password</strong></label>
                    <?php echo $this->Form->input('password', array(
                        'type' => 'password',
                        'class' => 'form-control validate[required,custom[mandatory-enter]]',
                        'id' => 'password',
                        'div' => false,
                        'label' => false,
                        'placeholder' => 'Enter your password'
                    )); ?>
                </div>

                <div class="mb-3">
                    <input type="checkbox" id="login_as_patient" name="login_as_patient" style="width:12px;height:12px; margin-right:5px;" />
                    <label for="login_as_patient"><strong>Login as patient</strong></label>
                </div>

                <input type="hidden" name="client_time_zone" id="client_time_zone" />

                <div class="d-flex justify-content-between mb-3">
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </div>

                <div class="mt-3 text-center">
                    <a href="#" id="forgotPasswordLink" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" title="Forgot Password">Forgot Password!</a>
                </div>

                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo $this->Form->create('User', array('id' => 'forgotPasswordForm', 'action' => 'forgotPassword')); ?>

                <div class="mb-3">
                    <label for="emailOrPatientID" class="form-label"><strong>Email / Patient ID</strong></label>
                    <?php echo $this->Form->input('emailOrPatientID', array(
                        'class' => 'form-control validate[required]',
                        'id' => 'emailOrPatientID',
                        'div' => false,
                        'label' => false,
                        'placeholder' => 'Enter your Email or Patient ID'
                    )); ?>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

</div>


    <!-- Image Gallery Section -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Our Facilities</h2>
        <div class="row image-gallery">
            <div class="col-md-6" style="border: 2px solid #333; padding: 15px; border-radius: 1px;">
                <h1 class="text-center text-danger">Multiple Award Winner in Healthcare Innovation</h1>
            </div>
            <div class="col-md-6">
                <img src="https://hopesoftwares.com/img/iigp-top50.gif" class="img-fluid" alt="Gallery 2"
                    style="box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, rgb(51, 51, 51) 0px 0px 0px 3px;">
            </div>



            <div style="font-size: 15px;padding-top:20px;">
                <div style="font-size: 20px"><strong>
                        <font color=" #6351ce">DrMhope, A Reliable Hospital Management Solution</font>
                    </strong> </div>
                <div style="font-size: 16px;padding-top:5px;"><strong>Award Winning, ISO 9001:2008 Certified, HIPAA
                        Compliant Hospital Management Software</strong> </div>
                <div
                    style="font-size: 14px;padding-top:5px;line-height: 25px;text-align: justify;font-family: Arial,Helvetica,sans-serif;">
                    <b>DrMHope</b> is one of the first Saas based ENTERPRIZE LEVEL Hospital Management Information
                    Software,registered for patients in US & India for Hospital Information Systems. It will change the
                    way your doctors, clinicians, and medical staff share patient information.</br>
                    <b>DrMHope</b> is patented, subscription based application certified & tested under the ONC HIT
                    Certificate Program 2014 edition certification criteria (USA) for both ambulatory and inpatient.
                    </br>This <b>SaaS</b> based Cloud Hospital management System for both Ambulatory and Inpatient will
                    enhance your hospital`s, Patient-care management, improve patient safety, reduce cost, a few notches
                    higher; enhancing overall productivity of your hospital and patient`s clinical experience.Employee
                    Management, Billing & Administration.</br>
                    Aimed at the Critical Care facilities, DrM EMR & EHR is the answer to all your HMS problems. </br>
                    Family clinics and General practioners will love our easy to use Ambulatory EMR.</br>

                    <div class="clr"></div>

                    <div style="padding-top:20px;">

                        <div style="font-size: 20px"><strong>
                                <font color=" #6351ce">Member of the UBM Medica Network</font>
                            </strong> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Remove the container if you want to extend the Footer to full width. -->
    <div>

        <!-- Footer -->
        <footer class="text-center text-lg-start text-white" style="background-color: #1c2331">
            <!-- Section: Social media -->
            <section class="d-flex justify-content-between p-1" style="background-color: #6351ce">

            </section>
            <!-- Section: Social media -->

            <!-- Section: Links  -->
            <section class>
                <div class="container text-center text-md-start mt-5">
                    <!-- Grid row -->
                    <div class="row mt-3">
                        <!-- Grid column -->
                        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                            <!-- Content -->
                            <h6 class="text-uppercase fw-bold">DrMHope</h6>
                            <hr class="mb-4 mt-0 d-inline-block mx-auto"
                                style="width: 60px; background-color: #7c4dff; height: 2px" />
                            <p>

                                <img src="https://hopesoftwares.com/img/onc-ambulatory.png" alt="">
                                <img src="https://hopesoftwares.com/img/onc-inpatient.png" alt="">

                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold">Connect Us On</h6>
                            <hr class="mb-4 mt-0 d-inline-block mx-auto"
                                style="width: 60px; background-color: #7c4dff; height: 2px" />
                            <p>
                                <a href="http://www.twitter.com/DrMHope" class="text-white"><i
                                        class="fab fa-twitter"></i> Twitter</a>
                            </p>
                            <p>
                                <a href="http://www.facebook.com/drmhopeCLOUD" class="text-white"><i
                                        class="fab fa-facebook-f"></i> Facebook</a>
                            </p>
                            <p>
                                <a href="https://plus.google.com/101489643999327172156" class="text-white"><i
                                        class="fab fa-google"></i> Google Plus</a>
                            </p>
                            <p>
                                <a href="http://www.youtube.com/drmhopedemos" class="text-white"><i
                                        class="fab fa-youtube"></i> YouTube</a>
                            </p>
                            <p>
                                <a href="mailto:info@drmhope.com" class="text-white"><i class="fas fa-envelope"></i>
                                    Mail</a>
                            </p>
                            <p>

                                <?php echo $this->Html->link('<i class="fas fa-life-ring" style="margin-right: 5px;"></i> Help', array('controller' => 'pages', 'action' => 'manual'), array('escape' => false)); ?>

                            </p>
                        </div>
                        <!-- Grid column -->


                        <!-- Grid column -->
                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold">
                                <a href="<?php echo $this->Html->url(['controller' => 'contacts', 'action' => 'index']); ?>"
                                    style="color: white;">Contact</a>
                            </h6>

                            <hr class="mb-4 mt-0 d-inline-block mx-auto"
                                style="width: 60px; background-color: #7c4dff; height: 2px" />
                            <p><i class="fas fa-home mr-3"></i> Beside Gogas Auto LPG,
                                2, Kamptee Rd, Nagpur,
                                Maharashtra 440017</p>
                            <p><i class="fas fa-envelope mr-3"></i>
                                info@hopehospital.com</p>
                            <p><i class="fas fa-phone mr-3"></i> 09373111709</p>
                            <br>
                            <div class="contact">
                                <a href="http://drmhope.com/downloads/brochure-drmhope.pdf" title="Download Brochure"
                                    target="_blank">
                                    <?php echo $this->Html->image('btn-download.png'); ?>
                                </a>


                            </div>
                            <!-- Grid column -->
                        </div>
                        <!-- Grid row -->
                    </div>
            </section>
            <!-- Section: Links  -->

            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
                DrMHope version 2.0

            </div>
            <!-- Copyright -->
        </footer>
        <!-- Footer -->

    </div>
    <!-- End of .container -->
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentIndex = 0;
        const items = document.querySelectorAll('.carousel-item');
        const totalItems = items.length;

        function showNextImage() {
            items[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % totalItems;
            items[currentIndex].classList.add('active');
        }
        // Initial image
        items[currentIndex].classList.add('active');

        // Change images every 2 seconds
        setInterval(showNextImage, 2000);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Ensure Bootstrap's dropdown functionality works
            document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(toggle => {
                toggle.addEventListener('click', (e) => e.stopPropagation());
            });

            // Handle submenu clicks
            document.querySelectorAll('.dropdown-submenu > a').forEach(submenu => {
                submenu.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();

                    const siblingMenu = submenu.nextElementSibling;

                    // Toggle the submenu and close others
                    document.querySelectorAll('.dropdown-submenu .dropdown-menu').forEach(menu => {
                        if (menu !== siblingMenu) menu.classList.remove('show');
                    });

                    siblingMenu.classList.toggle('show');
                });
            });

            // Close all dropdowns on outside click
            document.addEventListener('click', () => {
                document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.remove('show'));
            });
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Handle Forgot Password Form Submission
    const forgotPasswordForm = document.getElementById("forgotPasswordForm");
    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener("submit", function (event) {
            const emailOrPatientID = document.getElementById("emailOrPatientID");
            if (!emailOrPatientID.value.trim()) {
                event.preventDefault();
                alert("Please enter your Email or Patient ID.");
                emailOrPatientID.focus();
            }
        });
    }
});

</script>




</body>

</html>