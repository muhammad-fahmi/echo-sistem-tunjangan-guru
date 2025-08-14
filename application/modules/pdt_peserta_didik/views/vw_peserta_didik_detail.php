<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Detail Peserta Didik</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?= site_url('pdt_peserta_didik') ?>">Peserta Didik</a>
      </li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </div>
</div>

<div class="container-fluid">

  <div class="row">

    <?php
    /// |----------------------------------------
    /// | SHOW DEBUG
    /// |----------------------------------------
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
        <div class="card-title">
          <h4 class="card-title space-between">
            <div><i class="fas fa-building me-2"></i>Profil Sekolah Peserta Didik</div>
            <div></div>
          </h4>
        </div>
        <div class="card-body">
          <div>

            <div class="row g-1">

              <table style="width: 100%;" class="table table-hover mb-1">
                <tr>
                  <td style="min-width: 150px;">Sekolah</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'ket_sekolah', '-') ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Kelas / Rombel</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'ket_kelas', '-') . '/' . check_var($data, 'nama_rombel', '-')  ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Jenjang</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'ket_jenjang', '-') ?></td>
                </tr>

              </table>

            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title space-between mb-3">
            <div><i class="fas fa-history me-2"></i>Riwayat Peserta Didik</div>
            <div></div>
          </h4>
          <div>

            <div id="row_riwayat_dokumen" class="row g-2 row_riwayat_dokumen">

              <div class="col-12">
                <div class="_loading loading_riwayat_dokumen behind-navbar">
                  <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>LOADING...</div>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div> -->

    <div class="col-12">
      <form id="form_edit_profil_sekolah" action="<?= site_url('pdt_profil_sekolah/edit') ?>" method="POST">
        <input type="hidden" name="id_dokumen" value="<?= check_var($data, 'id_dokumen', '') ?>">

        <div class="card">
          <div class="card-title">
            <h4 class="card-title space-between">
              <div><i class="fas fa-user me-2"></i>Profil Peserta Didik</div>
              <div></div>
            </h4>
          </div>
          <div class="card-body">

            <div class="row g-2">

              <!-- <div class="col-12 col-lg-3 col-xl-1"></div> -->

              <!-- <div class="col-12 col-lg-9 col-xl-11"> -->
              <div class="col-12">
                <div class="row g-2">

                  <div class="col-12">
                    <div class="desc_block">
                      <label>NISN</label>
                      <div><?= check_var($data, 'nisn', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="nama">Nama Lengkap</label>
                      <div class="text_value"><?= check_var($data, 'nama', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="status">NIK</label>
                      <div class="text_value"><?= check_var($data, 'nik', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="ket_jenis_kelamin">Jenis Kelamin</label>
                      <div class="text_value"><?= check_var($data, 'ket_jns_kelamin', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="ket_agama">Agama</label>
                      <div class="text_value"><?= check_var($data, 'ket_agama', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="nama_ayah">Nama Ayah</label>
                      <div class="text_value"><?= check_var($data, 'nama_ayah', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="nama_ibu">Nama Ibu</label>
                      <div class="text_value"><?= check_var($data, 'nama_ibu', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="no_kk">No. KK</label>
                      <div class="text_value"><?= check_var($data, 'no_kk', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="alamat">Alamat</label>
                      <div class="text_value"><?= nl2br(check_var($data, 'alamat', '-')) ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="tgl_masuk">Tgl. Masuk</label>
                      <div class="text_value"><?= check_var($data, 'tgl_masuk', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="tgl_keluar">Tgl. Keluar</label>
                      <div class="text_value"><?= check_var($data, 'tgl_keluar', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="alasan_keluar">Alasan Keluar</label>
                      <div class="text_value"><?= check_var($data, 'alasan_keluar', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="ket_disabilitas">Penyandang Disabilitas</label>
                      <div class="text_value"><?= check_var($data, 'ket_disabilitas', '-') ?></div>
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
  //   let loading_riwayat = $('.loading_riwayat_dokumen');
  //   let container_riwayat = $('#row_riwayat_dokumen');
  //   $.ajax({
  //     type: "POST",
  //     url: "<?= site_url('pangkalan_data/get_riwayat_dokumen') ?>",
  //     data: {
  //       id_dokumen: '<?= $data['id_dokumen'] ?>',
  //       jenis_dokumen: 'PROFIL_SEKOLAH'
  //     },
  //     dataType: 'json',
  //     beforeSend: function(e) {
  //       loading_riwayat.addClass('show');
  //     },
  //     success: function(e) {
  //       if (e.status) {
  //         // what to do when the response status = true
  //         container_riwayat.html(e.html);
  //         loading_riwayat.removeClass('show');
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