<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Update Rombongan Belajar</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Data Tahun Ajaran</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?= site_url('pdt_rombongan_belajar') ?>">Rombongan Belajar</a>
      </li>
      <li class="breadcrumb-item active">Update</li>
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
            <h4 class="card-title">DATA (DEBUG)</h4>
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

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title space-between">
            <div><i class="fas fa-building me-2"></i>Profil Rombongan Belajar</div>
            <div></div>
          </h4>
          <div>

            <div class="row g-1">

              <table style="width: 100%;" class="table table-hover mb-1">
                <tr>
                  <td style="min-width: 150px;">Sekolah</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'nama_sekolah', '-') ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Kelas / Rombel</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'tingkat', '-') . '/' . check_var($data, 'nama_rombel', '-')  ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Semester</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'semester', '-') ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Tahun Ajaran</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'tahun_ajaran', '-') ?></td>
                </tr>

              </table>

            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <form id="form_edit_rombongan_belajar" action="<?= site_url('pdt_rombongan_belajar/edit') ?>" method="POST">
        <input type="hidden" name="id_rombel" value="<?= check_var($data, 'id_rombel', '') ?>">

        <div class="card">
          <div class="card-body">
            <h4 class="card-title space-between mb-3">
              <div><i class="fas fa-user me-2"></i>Daftar Peserta Didik</div>
              <div></div>
            </h4>

            <div class="row g-2">

              <div class="col-12">
                <div class="row g-2">

                  <div id="list_peserta_didik" class="row g-2 list_peserta_didik">

                    <div class="col-12">
                      <div class="_loading loading_list_peserta_didik behind-navbar">
                        <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>LOADING...</div>
                      </div>
                    </div>

                  </div>

                </div>
              </div>

            </div>

          </div>
        </div>

      </form>
    </div>

  </div>

</div>

<script>
  // function request_riwayat() {
  //   // you may add more than one param to send
  //   let loading_list_pd = $('.loading_list_peserta_didik');
  //   let container_list_pd = $('#list_peserta_didik');
  //   $.ajax({
  //     type: "POST",
  //     url: "<?= site_url('pangkalan_data/get_riwayat_dokumen') ?>",
  //     data: {
  //       id_dokumen: '<?= $data['id_dokumen'] ?>',
  //       jenis_dokumen: 'PROFIL_SEKOLAH'
  //     },
  //     dataType: 'json',
  //     beforeSend: function(e) {
  //       loading_list_pd.addClass('show');
  //     },
  //     success: function(e) {
  //       if (e.status) {
  //         // what to do when the response status = true
  //         container_list_pd.html(e.html);
  //         loading_list_pd.removeClass('show');
  //       } else {
  //         // what to do when the response status = false
  //         show_notify('error', e.message);
  //       }
  //     },
  //     error: function(xhr, status, error) {
  //       show_notify('error', error);
  //       console.error(error);
  //     },
  //   });
  // }

  /// |----------------------------------------
  /// | DOCUMENT READY
  /// |----------------------------------------
  $(document).ready(function() {
    // REQUEST RIWAYAT
    // request_riwayat();
  });
</script>