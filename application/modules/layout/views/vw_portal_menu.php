<!DOCTYPE html>
<html dir="ltr">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="" />
  <meta name="description" content="Sistem Penyusunan Kerangka Acuan Kerja Perencanaan Kegiatan" />
  <meta name="robots" content="noindex,nofollow" />
  <title><?php echo $page_title; ?></title>

  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url("theme/assets/images/favicon.ico"); ?>" />

  <!-- Custom CSS -->
  <link href="<?php echo base_url("theme/dist/css/style.min.css") ?>" rel="stylesheet" />

  <!-- -------------------------------------------------------------- -->
  <!-- All Required js -->
  <!-- -------------------------------------------------------------- -->
  <script src="<?php echo base_url("theme/dist/libs/jquery/dist/jquery.min.js"); ?>"></script>
  <!-- Bootstrap tether Core JavaScript -->
  <script src="<?php echo base_url("theme/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"); ?>"></script>
  <!-- slimscrollbar scrollbar JavaScript -->
  <script src="<?php echo base_url("theme/dist/libs/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.js"); ?>"></script>
  <script src="<?php echo base_url("theme/dist/libs/jquery-sparkline/jquery.sparkline.min.js"); ?>"></script>
  <!--Wave Effects -->
  <script src="<?php echo base_url("theme/dist/js/waves.js"); ?>"></script>
  <!--Menu sidebar -->
  <!-- <script src="<?php echo base_url("theme/dist/js/sidebarmenu.js"); ?>"></script> -->
  <!--Custom JavaScript -->
  <script src="<?php echo base_url("theme/dist/js/feather.min.js"); ?>"></script>
  <script src="<?php echo base_url("theme/dist/js/custom.min.js"); ?>"></script>
  <script src="<?php echo base_url("theme/assets/extra-libs/jqbootstrapvalidation/validation.js"); ?>"></script>
  <script src="<?php echo base_url("theme/dist/js/plugins/toastr-init.js"); ?>"></script>
</head>

<body>

  <?php $this->load->view($view, $data) ?>

  <script></script>
</body>

</html>