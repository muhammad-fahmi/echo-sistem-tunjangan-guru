<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, material admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, material design, material dashboard bootstrap 5 dashboard template" />
  <meta name="description" content="MaterialPro is powerful and clean admin dashboard template, inpired from Google's Material Design" />
  <meta name="robots" content="noindex,nofollow" />
  <title><?= $page_title ?></title>
  <link rel="canonical" href="https://www.wrappixel.com/templates/materialpro/" />
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url("/theme/assets/images/favicon.png"); ?>" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets_old/datatables/datatables.min.css'); ?>">
  <!-- This Page CSS -->
  <link rel="stylesheet" href="<?= base_url("theme/dist/libs/select2/dist/css/select2.min.css"); ?>">
  <link rel="stylesheet" href="<?= base_url("theme/dist/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"); ?>">
  <link rel="stylesheet" href="<?= base_url("theme/dist/css/style.min.css"); ?>" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url("theme/overrider/style.css?v=") . em_date('YmdHis'); ?>" rel="stylesheet" />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>

      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  <!-- <script src="<?= base_url("theme/dist/libs/jquery/dist/jquery.min.js"); ?>"></script> -->
  <script src="<?= base_url("assets_old/jquery/jquery-3.5.1.min.js"); ?>"></script>
  <script src="<?= base_url("assets_old/jquery/jquery.form.js"); ?>"></script>
  <script src="<?= base_url("assets_old/jquery-validation/jquery.validate.min.js"); ?>"></script>
  <script src="<?= base_url("assets_old/jquery-validation/additional-methods.min.js"); ?>"></script>
  <!-- Bootstrap tether Core JavaScript -->
  <script src="<?= base_url("theme/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js") ?>"></script>
  <!-- apps -->
  <script src="<?= base_url("theme/dist/js/app.min.js"); ?>"></script>
  <script src="<?= base_url("theme/dist/js/app.init.js"); ?>"></script>
  <script src="<?= base_url("theme/dist/js/app-style-switcher.js"); ?>"></script>
  <!-- slimscrollbar scrollbar JavaScript -->
  <script src="<?= base_url("theme/dist/libs/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.js"); ?>"></script>
  <script src="<?= base_url("theme/dist/libs/jquery-sparkline/jquery.sparkline.min.js"); ?>"></script>
  <!--Wave Effects -->
  <script src="<?= base_url("theme/dist/js/waves.js"); ?>"></script>
  <!--Menu sidebar -->
  <script src="<?= base_url("theme/dist/js/sidebarmenu.js"); ?>"></script>
  <!--Custom JavaScript -->
  <script src="<?= base_url("theme/dist/js/feather.min.js"); ?>"></script>
  <script src="<?= base_url("theme/dist/js/custom.min.js"); ?>"></script>
  <!--This page JavaScript -->
  <script src="<?= base_url("theme/dist/libs/apexcharts/dist/apexcharts.min.js"); ?>"></script>
  <!-- Chart JS -->
  <!-- <script src="<?= base_url("theme/dist/js/pages/dashboards/dashboard1.js"); ?>"></script> -->
  <!--This page plugins -->
  <script src="<?= base_url("theme/dist/libs/datatables.net/js/jquery.dataTables.min.js") ?>"></script>
  <!-- <script src="<?= base_url("assets_old/datatables/datatables.min.js") ?>"></script> -->

  <!-- Picker -->
  <script src="<?= base_url("theme/dist/libs/moment-js/moment.js"); ?>"></script>
  <script src="<?= base_url("theme//dist/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"); ?>"></script>

  <!-- select2 lib -->
  <script src="<?= base_url("theme/dist/libs/select2/dist/js/select2.full.min.js"); ?>"></script>
  <script src="<?= base_url("theme/dist/libs/select2/dist/js/select2.min.js"); ?>"></script>

  <script type="text/javascript" src="<?= base_url("theme/overrider/script.js?v=") . em_date('YmdHis'); ?>"></script>
</head>

<body>
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <div class="preloader">
    <svg class="tea lds-ripple" width="37" height="48" viewbox="0 0 37 48" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z" stroke="#1e88e5" stroke-width="2"></path>
      <path d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34" stroke="#1e88e5" stroke-width="2"></path>
      <path id="teabag" fill="#1e88e5" fill-rule="evenodd" clip-rule="evenodd" d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z"></path>
      <path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="#1e88e5"></path>
      <path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="#1e88e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
  </div>
  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar">
      <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header">
          <!-- This is for the sidebar toggle which is visible on mobile only -->
          <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
          <!-- ============================================================== -->
          <!-- Logo -->
          <!-- ============================================================== -->
          <a class="navbar-brand" href="<?= site_url(); ?>">
            <!-- Logo icon -->
            <b class="logo-icon">
              <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
              <!-- Dark Logo icon -->
              <img src="<?= base_url("theme/assets/images/logo/logo_tut_wuri_handayani.png") ?>" alt="homepage" class="dark-logo" style="max-width:40px" />
              <!-- Light Logo icon -->
              <img src="<?= base_url("theme/assets/images/logo/logo_tut_wuri_handayani.png") ?>" alt="homepage" class="light-logo" style="max-width:40px" />
            </b>
            <!--End Logo icon -->
            <!-- Logo text -->
            <span class="logo-text">
              <h3 style="color:white;font-weight:600">PROGURINDA</h3>
              <!-- dark Logo text -->
              <!-- <img src="<?= base_url("theme/assets/images/logo-text.png") ?>" alt="homepage" class="dark-logo" /> -->
              <!-- Light Logo text -->
              <!-- <img src="<?= base_url("theme/assets/images/logo-light-text.png") ?>" class="light-logo" alt="homepage" /> -->
            </span>
          </a>
          <!-- ============================================================== -->
          <!-- End Logo -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- Toggle which is visible on mobile only -->
          <!-- ============================================================== -->
          <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
          <!-- ============================================================== -->
          <!-- toggle and nav items -->
          <!-- ============================================================== -->
          <ul class="navbar-nav me-auto">
            <!-- This is  -->
            <li class="nav-item">
              <a class="
                    nav-link
                    sidebartoggler
                    d-none d-md-block
                    waves-effect waves-dark
                  " href="javascript:void(0)"><i class="ti-menu"></i></a>
            </li>
          </ul>
          <!-- ============================================================== -->
          <!-- Right side toggle and nav items -->
          <!-- ============================================================== -->
          <ul class="navbar-nav">
            <!-- ============================================================== -->
            <!-- Profile -->
            <!-- ============================================================== -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="<?= base_url("theme/assets/images/users/1.jpg") ?>" alt="user" width="30" class="profile-pic rounded-circle" />
              </a>
              <div class="
                    dropdown-menu dropdown-menu-end
                    user-dd
                    animated
                    flipInY
                  ">
                <div class="
                      d-flex
                      no-block
                      align-items-center
                      p-3
                      bg-info
                      text-white
                      mb-2
                    ">
                  <div class="">
                    <img src="<?= base_url("theme/assets/images/users/1.jpg") ?>" alt="user" class="rounded-circle" width="60" />
                  </div>
                  <div class="ms-2">
                    <h4 class="mb-0 text-white">Steave Jobs</h4>
                    <p class="mb-0">varun@gmail.com</p>
                  </div>
                </div>
                <a class="dropdown-item" href="#"><i data-feather="user" class="feather-sm text-info me-1 ms-1"></i>
                  My Profile</a>
                <!-- <a class="dropdown-item" href="#"><i data-feather="credit-card" class="feather-sm text-info me-1 ms-1"></i>
                  My Balance</a> -->
                <!-- <a class="dropdown-item" href="#"><i data-feather="mail" class="feather-sm text-success me-1 ms-1"></i>
                  Inbox</a> -->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#"><i data-feather="settings" class="feather-sm text-warning me-1 ms-1"></i>
                  Account Setting</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#"><i data-feather="log-out" class="feather-sm text-danger me-1 ms-1"></i>
                  Logout</a>
                <div class="dropdown-divider"></div>
                <!-- <div class="pl-4 p-2">
                  <a href="#" class="btn d-block w-100 btn-info rounded-pill">View Profile</a>
                </div> -->
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile position-relative" style="
              background: url(<?= base_url("theme/assets/images/background/user-info.jpg"); ?>)
                no-repeat;
            ">
          <!-- User profile image -->
          <div class="profile-img">
            <img src="<?= base_url("theme/assets/images/users/profile.png") ?>" alt="user" class="w-100" />
          </div>
          <!-- User profile text-->
          <div class="profile-text pt-1 dropdown">
            <a href="#" class="
                  dropdown-toggle
                  u-dropdown
                  w-100
                  text-white
                  d-block
                  position-relative
                " id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><?= $this->session->userdata("username"); ?></a>
            <div class="dropdown-menu animated flipInY" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="#"><i data-feather="user" class="feather-sm text-info me-1 ms-1"></i>
                My Profile</a>
              <!-- <a class="dropdown-item" href="#"><i data-feather="mail" class="feather-sm text-success me-1 ms-1"></i>
                Inbox</a> -->
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#"><i data-feather="settings" class="feather-sm text-warning me-1 ms-1"></i>
                Account Setting</a>
              <div class="dropdown-divider"></div>
              <!-- <a class="dropdown-item" href="authentication-login3.html"><i data-feather="log-out" class="feather-sm text-danger me-1 ms-1"></i>
                Logout</a> -->
              <div class="dropdown-divider"></div>
              <div class="ps-4 p-2">
                <a href="#" class="btn d-block w-100 btn-info rounded-pill">View Profile</a>
              </div>
            </div>
          </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="mdi mdi-dots-horizontal"></i>
              <span class="hide-menu">Menu Sistem</span>
            </li> 
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= site_url("dashboard"); ?>" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard Monitoring</span></a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu">Setup</span></a>
              <ul aria-expanded="false" class="collapse first-level">
                <?php if ($this->session->userdata("kewenangan") == "00") { ?>
                  <li class="sidebar-item">
                    <a href="<?= site_url("user"); ?>" class="sidebar-link"><i class="mdi mdi-format-align-left"></i><span class="hide-menu">
                        User
                      </span></a>
                  </li>
                <?php } ?>
                <li class="sidebar-item">
                  <a href="<?= site_url("mapel_guru"); ?>" class="sidebar-link"><i class="mdi mdi-format-align-left"></i><span class="hide-menu">
                      Mapel Guru
                    </span></a>
                </li>
                <li class="sidebar-item">
                  <a href="<?= site_url("tugas_tambahan"); ?>" class="sidebar-link"><i class="mdi mdi-format-align-left"></i><span class="hide-menu">
                      Tugas Tambahan Guru
                    </span></a>
                </li>
              </ul>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-pencil"></i><span class="hide-menu">Input Data</span></a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                  <a href="<?= site_url("presensi"); ?>" class="sidebar-link"><i class="mdi mdi-format-align-left"></i><span class="hide-menu">
                      Presensi Pegawai
                    </span></a>
                </li>
                <li class="sidebar-item">
                  <a href="<?= site_url("jurnal_mengajar"); ?>" class="sidebar-link"><i class="mdi mdi-format-align-left"></i><span class="hide-menu">
                      Jurnal Mengajar
                    </span></a>
                </li>
              </ul>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= site_url("tpp_per_bulan") ?>" aria-expanded="false"><i class="mdi mdi-directions"></i><span class="hide-menu">List TPP Per Bulan</span></a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= site_url("tpp_per_bulan") ?>" aria-expanded="false"><i class="mdi mdi-directions"></i><span class="hide-menu">Cuti</span></a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="hide-menu">Laporan</span></a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                  <a href="<?= site_url("laporan/tpp_3_bln") ?>" class="sidebar-link"><i class="mdi mdi-format-align-left"></i><span class="hide-menu">
                      TPP Per 3 Bulan
                    </span></a>
                </li>
                <li class="sidebar-item">
                  <a href="<?= site_url("laporan/jurnal_bulanan") ?>" class="sidebar-link"><i class="mdi mdi-format-align-left"></i><span class="hide-menu">
                      Jurnal Mengajar
                    </span></a>
                </li>
              </ul>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= site_url("login/logout") ?>" aria-expanded="false"><i class="mdi mdi-directions"></i><span class="hide-menu">Log Out</span></a>
            </li>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
      <!-- Bottom points-->
      <div class="sidebar-footer">
        <!-- item-->
        <a href="" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Settings"><i class="ti-settings"></i></a>
        <!-- item-->
        <!-- <a href="" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Email"><i class="mdi mdi-gmail"></i></a> -->
        <!-- item-->
        <a href="<?= site_url() ?>" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Logout"><i class="mdi mdi-power"></i></a>
      </div>
      <!-- End Bottom points-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
      <!-- ============================================================== -->
      <!-- Page Content -->
      <!-- ============================================================== -->
      <?php $this->load->view($view, $data); ?>
      <!-- ============================================================== -->
      <!-- End Page Content -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- footer -->
      <!-- ============================================================== -->
      <footer class="footer">
        All Rights Reserved Dinas Pendidikan dan Kebudayaan Kota Samarinda. Template Material Pro @ Wrappixel.
      </footer>
      <!-- ============================================================== -->
      <!-- End footer -->
      <!-- ============================================================== -->
    </div>
  </div>
  <!-- End Sidebar scroll-->
  <!-- Bottom points-->
  <div class="sidebar-footer">
    <!-- item-->
    <a href="" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Settings"><i class="ti-settings"></i></a>
    <!-- item-->
    <!-- <a href="" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Email"><i class="mdi mdi-gmail"></i></a> -->
    <!-- item-->
    <a href="" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Logout"><i class="mdi mdi-power"></i></a>
  </div>
  <!-- End Bottom points-->

  <div class="modal fade" id="whole_modal_id" tabindex="-1" data-bs-focus="false" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
      <div id="modal_content_id" class="modal-content">
      </div>
    </div>
    <div class="modal fade" id="bs-modal-lg" tabindex="-1" aria-labelledby="bs-modal-lg" data-bs-focus="false" data-bs-backdrop="static" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div id="modal-content-lg" class="modal-content-lg">

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
</body>

</html>