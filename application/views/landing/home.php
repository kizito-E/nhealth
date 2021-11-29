<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>nHealth | e-Health Insurance Management System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/assets/landing/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="/assets/landing/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/landing/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/landing/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/assets/landing/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="/assets/landing/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="/assets/landing/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/assets/landing/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="/assets/landing/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: nHealth - v4.5.0
  * Template URL: https://bootstrapmade.com/nHealth-free-medical-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex justify-content-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope"></i> <a href="mailto:info@nhealth.site">info@nhealth.site</a>
        <i class="bi bi-phone"></i> +234 (0) 813 208 7553
      </div>
    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="/">nHealth</a></h1>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#how-it-works">How it works</a></li>
          <li><a class="nav-link scrollto" href="/docs">Documentation</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <a href="/auth/login" class="appointment-btn scrollto">Sign in</a>

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us section-bg">
      <div class="container">

        <div class="row">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="content">
              <h3>Welcome to nHealth</h3>
              <p>nHealth is a simple and robust health insurance management system that addresses the inefficiences and bottlenecks in the Nigerian National Healtth Insurance Scheme (NHIS) resulting from its poor implementation and adoption of a centralized management system</p>
            </div>
          </div>
          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="icon-boxes d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-xl-6 d-flex align-items-stretch">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-receipt"></i>
                    <h4>Transparency & Accountability</h4>
                  </div>
                </div>
                <div class="col-xl-6 d-flex align-items-stretch">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-cube-alt"></i>
                    <h4>Simple & Robust</h4>
                  </div>
                </div>
              </div>
            </div><!-- End .content-->
          </div>
        </div>

      </div>
    </section><!-- End Why Us Section -->

    <!-- ======= Departments Section ======= -->
    <section id="how-it-works" class="departments">
      <div class="container">

        <div class="section-title">
          <h2>How it Works</h2>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <ul class="nav nav-tabs flex-column">
              <li class="nav-item">
                <a class="nav-link active show" data-bs-toggle="tab" href="#tab-1">Administrator</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-2">Health Manager (HMOs)</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-3">Health Service Providers</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-4">Beneficiaries</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-9 mt-4 mt-lg-0">
            <div class="tab-content">
              <div class="tab-pane active show" id="tab-1">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <p>Administrators can enroll beneficiaries, health management organizations, and health service providers. The get an overview of the utilization of the scheme and can print report that shows the actual amount payable to health management organizations at the end of each month</p>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab-2">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <p>Health managers can enroll beneficiaries and service providers. They get a list of health claims made by beneficiaries through a health service provider of which they can approve, decline, or mark as complete when the service is fufilled</p>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab-3">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <p>Health service providers can create a health claim for a service requested by a beneficiary and can easily track its status every point in time.</p>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab-4">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <p>Beneficiaries of the scheme can track the status of their health claims resulting from a reuested service and can easily update its status if their health manager fails to do so within a reasonable time frame.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Departments Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="container d-md-flex py-4">

      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span>nHealth</span></strong>. All Rights Reserved
        </div>
        <div class="credits">Theme by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
      </div>
      <!--<div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>-->
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="/assets/landing/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/landing/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="/assets/landing/vendor/php-email-form/validate.js"></script>
  <script src="/assets/landing/vendor/purecounter/purecounter.js"></script>
  <script src="/assets/landing/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="/assets/landing/js/main.js"></script>

</body>

</html>