<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page_title ?></title>
  <?php
  /// |----------------------------------------------------------------------
  /// | IMPORT CSS HERE
  /// |----------------------------------------------------------------------
  ?>
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.1.3/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/flatpickr/flatpickr.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/flatpickr/themes/dark.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/datatables/datatables.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/all.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/select2/css/select2.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/leaflet/leaflet.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/custom/style.css?ver=4'); ?>">
  <?php
  /// |----------------------------------------------------------------------
  /// | IMPORT JS HERE
  /// |----------------------------------------------------------------------
  ?>
  <script src="<?= base_url('assets/jquery/jquery-3.5.1.min.js'); ?>"></script>
  <script src="<?= base_url('assets/jquery/jquery.form.js'); ?>"></script>
  <script src="<?= base_url('assets/jquery-validation/jquery.validate.min.js'); ?>"></script>
  <script src="<?= base_url('assets/bootstrap-5.1.3/js/bootstrap.min.js'); ?>"></script>
  <script src="<?= base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
  <script src="<?= base_url('assets/flatpickr/flatpickr.min.js'); ?>"></script>
  <script src="<?= base_url('assets/datatables/datatables.min.js'); ?>"></script>
  <script src="<?= base_url('assets/select2/js/select2.min.js'); ?>"></script>
  <script src="<?= base_url('assets/notifyjs/notify.min.js'); ?>"></script>
  <script src="<?= base_url('assets/leaflet/leaflet.js'); ?>"></script>
  <script src="<?= base_url('assets/easyqrcode/easy.qrcode.min.js'); ?>"></script>
  <script src="<?= base_url('assets/custom/script.js'); ?>"></script>

</head>

<body>
  <?php
  /// |----------------------------------------------------------------------
  /// | >> FULLSCREEN LOADING
  /// |----------------------------------------------------------------------
  ?>
  <div id="echo_fullscreen_loading">
    <div id="echo_loading_box">
      <div id="echo_loading_text" class="mb-2">LOADING_TXT</div>
      <div id="echo_loading_bar" class="mb-3">
        <div id="echo_loading_progress"></div>
      </div>
      <div id="echo_loading_button" class="btn btn-sm btn-warning">LOADING_BUTTON</div>
    </div>
  </div>

  <?php
  /// |----------------------------------------------------------------------
  /// | SIDEBAR MENU
  /// |----------------------------------------------------------------------
  ?>
  <div class="echo_sidebar_clickout"></div>
  <div class="echo_sidebar">
    <div class="header">
      <div class="title text-center">SISMAP</div>
      <div class="subtitle text-center">Sistem Manajemen Presensi<br>Kota SAMARINDA</div>
    </div>
    <div class="list">
      <?php
      // $priv = $this->session->userdata('privilege');
      // $cur_menu = $this->session->userdata('menu');
      // menu_loader($priv, $cur_menu);
      /// |----------------------------------------------------------------------
      /// | GUNAKAN MENU SIDEBAR SEPERTI DI PEMBAYARAN PAJAK
      /// |----------------------------------------------------------------------
      echo menu_loader_sipedal($this->session->userdata('username'), $this->session->userdata('kewenangan'));
      ?>
    </div>
  </div>

  <div class="echo-container">
    <?php $this->load->view($view); ?>
  </div>

  <?php
  /// |----------------------------------------------------------------------
  /// | HEADER & FOOTER
  /// |----------------------------------------------------------------------
  $date = datetime_array();
  $footer_year = ($date['year'] == '2021') ? '2021' : '2021 - ' . $date['year'];
  ?>

  <div class="echo_header">
    <div class="echo_sidebar_trigger">
      <i class="fas fa-bars fa-fw"></i>
    </div>
    <div class="title"><?= $page_title; ?></div>
  </div>

  <div class="echo_footer">
    SISTEM MANAJEMEN PRESENSI KOTA SAMARINDA <?= $footer_year; ?>
  </div>

  <?php
  /// |----------------------------------------------------------------------
  /// | MODAL
  /// |----------------------------------------------------------------------
  ?>
  <div class="modal fade" id="my_modal" tabindex="-1" data-bs-focus="false" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
      <div id="modal" class="modal-content">
      </div>
    </div>
  </div>

  <?php
  /// |----------------------------------------------------------------------
  /// | ELEMENT TO SHOW CI3 SESSION AND DATA PASSED TO THE VIEWS
  /// | - require ci3_button_cog style, script, and elements
  /// | - require ci3_info_panel style, script, and elements
  /// | - require trans_show, trans_hide custom css
  /// | - require jquery
  /// | - require bootstrap 5
  /// | - require fontawesome
  /// | - require custom css of <pre> tag
  /// |----------------------------------------------------------------------
  if (ENVIRONMENT === 'development') {
  ?>
    <div id="ci3_button_cog" class="ci3_button_cog" title="CI3 Settings">
      <i class="fas fa-cog"></i>
    </div>
    <div id="ci3_info_panel" class="ci3_info_panel trans_hide">
      <div class="body">
        <div class="content">
          <?php
          // do ini_set to change the default color of highlight_string
          ini_set('highlight.default', '#98B9EB');
          ini_set('highlight.keyword', '#B7F2BF');
          ini_set('highlight.string', '#E9BE8F');
          // output the things that you wanted to show
          echo '<hr>';
          echo '<h3>SESSION</h3>';
          echo '<hr>';
          if (isset_nn_nes($this->session->userdata())) {
            highlight_string("<?php SESSION = " . var_export($this->session->userdata(), true) . "; ?>");
          } else {
            echo '<small>no session data created yet.</small>';
          }
          echo '<hr>';
          echo '<h3>DATA</h3>';
          echo '<hr>';
          if (isset_nn_nes($data)) {
            highlight_string("<?php DATA = " . var_export($data, true) . "; ?>");
          } else {
            echo '<small>no data passed to this view.</small>';
          }
          echo '<hr>';
          ?>
        </div>
      </div>
    </div>
  <?php
  }
  ?>

  <script>
    <?php
    /// |----------------------------------------------------------------------
    /// | TEMPLATE SCRIPT GO HERE
    /// |----------------------------------------------------------------------
    ?>
    const ci3_info_panel = $('#ci3_info_panel');
    const ci3_button_cog = $('#ci3_button_cog');
    $(ci3_button_cog).on('click', function(e) {
      if (ci3_info_panel.hasClass('trans_show')) {
        ci3_info_panel.removeClass('trans_show');
        ci3_info_panel.addClass('trans_hide');
      } else {
        ci3_info_panel.removeClass('trans_hide');
        ci3_info_panel.addClass('trans_show');
      }
    });

    // deklarasi semua const variable yang akan di handle
    const sidebar = $('.echo_sidebar');
    const clickout = $('.echo_sidebar_clickout');
    const trigger = $('.echo_sidebar_trigger');
    // fungsi clickout handler : utk hide sidebar
    clickout.on('click', function(e) {
      if (clickout.hasClass('show')) {
        clickout.removeClass('show');
        sidebar.removeClass('show');
      }
    });
    // fungsi trigger sidebar
    trigger.on('click', function(e) {
      sidebar.addClass('show');
      clickout.addClass('show');
    });
  </script>

</body>

</html>