<?php
$cur_kewenangan = $this->session->userdata('kewenangan');
$cur_unor = $this->session->userdata('kode_unor');
?>
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Profile</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item active">Setting Akun</li>
    </ol>
  </div>
</div>

<div class="container-fluid">

  <div class="row">

    <?php
    $show_debug = false;
    if ($show_debug) {
    ?>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">SESSION DATA (DEBUG)</h4>
            <small>
              <?php highlight_string("<?php\nSESSION = " . var_export($this->session->userdata(), true) . ";\n\n?>"); ?>
              <?php highlight_string("<?php\nDATA = " . var_export($data, true) . ";\n\n?>"); ?>
            </small>
          </div>
        </div>
      </div>
    <?php
    }
    ?>

    <?php
    /// |----------------------------------------------------------------------
    /// | >> TAMPILAN PROFIL SAAT INI
    /// |----------------------------------------------------------------------
    ?>
    <div class="col-12">
      <div class="card">
        <div class="card-title space-between">
          <div>Data Profile</div>
        </div>
        <div class="card-body">
          <div class="_loading loading_profile">
            <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
          </div>

          <div class="row g-2">

            <?php
            $profile_img = check_var($data, 'profile_img', false);
            $url_profile_img = ($profile_img) ? site_url('pdt_profile/image') : '';
            ?>
            <div class="col-12 col-lg-3 text-center d-flex justify-content-center align-items-center">
              <div style="position: relative;">
                <div style="cursor: pointer;" onclick="modal(`upload_gambar`)" class="profil_img_container">
                  <img id="profile_img" src="<?= $url_profile_img ?>" onerror="this.onerror=null; this.src='<?= base_url('theme/assets/images/logo/logo_tut_wuri_handayani.png') ?>';" alt="ALT_Description">
                </div>
                <div class="edit_profile_icon">
                  <i class="fas fa-edit"></i>
                </div>
              </div>
            </div>

            <div class="col-12 col-lg-9 text-start">
              <div class="row g-2">
                <div class="col-12">
                  <div class="desc_block">
                    <label>Username</label>
                    <div><?= check_var($data, 'id_user', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Kewenangan</label>
                    <div><?= check_var($data, 'ket_kewenangan', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Nama / Instansi</label>
                    <div id="display_nama"><?= check_var($data, 'username', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>No. HP</label>
                    <div id="display_no_hp"><?= check_var($data, 'no_hp', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>E-mail</label>
                    <div id="display_email"><?= check_var($data, 'email_user', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Sekolah / Unit Kerja</label>
                    <div><?= check_var($data, 'ket_ukerja', '-') . ' [ ' . check_var($data, 'kode_ukerja', '-') . ' ]' ?></div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="card-footer text-end">
          <div class="btn btn-sm btn-success ms-1" onclick="modal(`update_profile`)"><i class="fas fa-edit me-1"></i>Update Data</div>
          <div class="btn btn-sm btn-warning ms-1" onclick="modal(`ganti_password`)"><i class="fas fa-unlock me-1"></i>Ganti Password</div>
        </div>
      </div>
    </div>

  </div>

</div>

<script>
  function modal(the_action, the_id = '') {
    var url = "<?= site_url('pdt_profile/modal') ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {
        action: the_action,
        id: the_id
      },
      success: function(res) {
        if (res.status) {
          $("#modal_content_id").html(res.html).show();
          $("#whole_modal_id").modal("show");
        } else {
          show_notify('error', res.message);
        }
      },
      error: function(xhr, status, error) {
        show_notify('error', xhr.status + ' : ' + error);
      }
    });
  }

  function get_updated_profile() {
    // you may add more than one param to send
    $.ajax({
      type: "POST",
      url: "<?= site_url('pdt_profile/get_data_profile') ?>",
      data: {},
      dataType: 'json',
      beforeSend: function(e) {
        // what to do before sending the AJAX
        // for example showing loading element
        $('.loading_profile').addClass('show');
      },
      success: function(e) {
        if (e.status) {
          // what to do when the response status = true
          // update value di vw_profile
          if (e.data) {
            let dataset = e.data;
            $('#display_nama').html(dataset.username);
            $('#display_no_hp').html(dataset.no_hp);
            $('#display_email').html(dataset.email_user);
          }
        } else {
          // what to do when the response status = false
          show_notify('error', e.message);
        }

        $('.loading_profile').removeClass('show');
      },
      error: function(xhr, status, error) {
        show_notify('error', error);
        console.error(error);
      },
    });
  }

  $(document).ready(function() {});
</script>