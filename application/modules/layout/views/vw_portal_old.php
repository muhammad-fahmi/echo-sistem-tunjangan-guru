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
  <link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/all.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/custom/style.css'); ?>">
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
  <script src="<?= base_url('assets/notifyjs/notify.min.js'); ?>"></script>
  <script src="<?= base_url('assets/custom/script.js'); ?>"></script>

</head>

<body>

  <?php $this->load->view($view); ?>

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
  </script>

</body>

</html>