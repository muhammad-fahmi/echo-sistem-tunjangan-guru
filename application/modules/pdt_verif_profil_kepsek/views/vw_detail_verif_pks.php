<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Detail Dokumen Profil Kepala Sekolah</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?= site_url('pdt_verif_profil_kepsek') ?>">Verifikasi Profil Kepala Sekolah</a>
      </li>
      <li class="breadcrumb-item active">Detail Dokumen</li>
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
            <div><i class="fas fa-file me-2"></i>Data Dokumen</div>
          </h4>
          <div>

            <div class="row g-1">

              <table style="width: 100%;" class="table table-hover mb-1">
                <tr>
                  <td style="min-width: 150px;">Periode</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'periode_bln', '-') . '/' . check_var($data, 'periode_thn', '-')  ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Dibuat Pada</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= em_date('j F Y, H:i:s', 'set', check_var($data, 'create_on', '')) ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Status Dokumen</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <?php
                    $ket_status = check_var($data, 'ket_status_dokumen', '-');
                    $col_status = check_var($data, 'col_status_dokumen', 'secondary');
                    echo '<span class="badge bg-' . $col_status . '">' . $ket_status . '</span>';
                    ?>
                  </td>
                </tr>

              </table>

            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title space-between mb-3">
            <div><i class="fas fa-history me-2"></i>Riwayat Dokumen</div>
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
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title space-between mb-3">
            <div><i class="fas fa-building me-2"></i>Profil Kepala Sekolah</div>
            <div></div>
          </h4>

          <div class="row g-2">
            <div class="col-12 col-lg-3 col-xl-1">
              <div class="img_profil_md">
                <img src="http://36.66.236.83/simpeg/foto/<?= check_var($data, 'nip', '0000') ?>.jpg" onerror="this.onerror=null; this.src='<?= base_url('theme/assets/images/default-profile.jpg') ?>';" alt="ALT_Description">
              </div>
            </div>

            <div class="col-12 col-lg-9 col-xl-11">
              <div class="row g-2">

                <div class="col-12">
                  <div class="desc_block">
                    <label>Sekolah / Unit Kerja</label>
                    <div><?= check_var($data, 'ket_ukerja', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>NIP</label>
                    <div><?= check_var($data, 'nip', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Status</label>
                    <div><?= check_var($data, 'ket_status', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Gelar Depan</label>
                    <div><?= check_var($data, 'gelar_dpn', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Nama</label>
                    <div><?= check_var($data, 'nama', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Gelar Belakang</label>
                    <div><?= check_var($data, 'gelar_blk', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>NIK</label>
                    <div><?= check_var($data, 'nik', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Tgl. Lahir</label>
                    <div><?= em_date('j F Y', 'set', check_var($data, 'tgl_lahir', '')) ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Jenis Kelamin</label>
                    <div>
                      <?php
                      $jkelamin = check_var($data, 'jenis_kelamin', '');
                      if ($jkelamin == 'P') {
                        echo 'Perempuan';
                      } elseif ($jkelamin == 'L') {
                        echo 'Laki-Laki';
                      } else {
                        echo '-';
                      }
                      ?>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Agama</label>
                    <div><?= check_var($data, 'ket_agama', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Status Pernikahan</label>
                    <div><?= check_var($data, 'ket_status_pernikahan', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Pangkat / Gol. Ruang</label>
                    <div><?= check_var($data, 'pangkat', '-') . ' / ' . check_var($data, 'gol_ruang', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Jabatan</label>
                    <div><?= check_var($data, 'jenjang_jabatan', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Pendidikan</label>
                    <div><?= check_var($data, 'kode_didik', '-') . ' / ' . check_var($data, 'pendidikan', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Alamat Saat Ini</label>
                    <div><?= check_var($data, 'alamat_saat_ini', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>NUPTR</label>
                    <div><?= check_var($data, 'nuptr', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>NURS</label>
                    <div><?= check_var($data, 'nurs', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>NRG</label>
                    <div><?= check_var($data, 'nrg', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>No. Sertifikat Pendidik</label>
                    <div><?= check_var($data, 'no_sertifikat_pendidik', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>No. Sertifikat GP</label>
                    <div><?= check_var($data, 'no_sertifikat_gp', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>No. Sertifikat CRS</label>
                    <div><?= check_var($data, 'no_sertifikat_crs', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>No. Rekening Bank</label>
                    <div><?= check_var($data, 'no_rek_bank', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Nama Rekening Bank</label>
                    <div><?= check_var($data, 'nama_rek_bank', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Nama Bank</label>
                    <div><?= check_var($data, 'nama_bank', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>NPWP</label>
                    <div><?= check_var($data, 'npwp', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <?php
                  $mttpi = (check_var($data, 'menerima_ttp_insentif', '-'));
                  if ($mttpi == 'Y') {
                    $mttpi = 'Ya';
                  } elseif ($mttpi == 'N') {
                    $mttpi = 'Tidak';
                  }
                  ?>
                  <div class="desc_block">
                    <label>Menerima TTP Insentif</label>
                    <div><?= $mttpi ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>E-mail</label>
                    <div><?= check_var($data, 'email', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>No. HP</label>
                    <div><?= check_var($data, 'no_hp', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Periode Ke</label>
                    <div><?= check_var($data, 'periode_ke', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>No. SK Kepala Sekolah</label>
                    <div><?= check_var($data, 'no_sk_kepsek', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Tgl. SK Kepala Sekolah</label>
                    <?php
                    $tgl_sk_kepsek = em_date('j F Y', 'set', check_var($data, 'tgl_sk_kepsek', ''));
                    ?>
                    <div><?= check_var($tgl_sk_kepsek, null, '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Penandatangan SK Kepala Sekolah</label>
                    <div><?= check_var($data, 'nama_ttd_sk_kepsek', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Masa / Tgl. Penugasan (Mulai)</label>
                    <div>
                      <?php
                      $mp_mulai = check_var($data, 'masa_penugasan_mulai', '');
                      $mp_text = check_var(em_date('j F Y', 'set', $mp_mulai), null, '-');
                      echo $mp_text;
                      ?>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Masa / Tgl. Penugasan (Selesai)</label>
                    <div>
                      <?php
                      $mp_selesai = check_var($data, 'masa_penugasan_selesai', '');
                      $mp_text = check_var(em_date('j F Y', 'set', $mp_selesai), null, '-');
                      echo $mp_text;
                      ?>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Status Riwayat</label>
                    <div>
                      <?php
                      $s_aktif = check_var($data, 's_aktif', '-');
                      if ($s_aktif == '1') $s_aktif = 'Riwayat Terbaru (Aktif)';
                      if ($s_aktif == '0') $s_aktif = 'Bukan Riwayat Terbaru (Non-Aktif)';
                      echo $s_aktif;
                      ?>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>

        </div>
      </div>
    </div>

  </div>

</div>

<script>
  function request_riwayat() {
    // you may add more than one param to send
    let loading_riwayat = $('.loading_riwayat_dokumen');
    let container_riwayat = $('#row_riwayat_dokumen');
    $.ajax({
      type: "POST",
      url: "<?= site_url('pangkalan_data/get_riwayat_dokumen') ?>",
      data: {
        id_dokumen: '<?= $data['id_dokumen'] ?>',
        jenis_dokumen: 'PROFIL_KEPSEK'
      },
      dataType: 'json',
      beforeSend: function(e) {
        loading_riwayat.addClass('show');
      },
      success: function(e) {
        if (e.status) {
          // what to do when the response status = true
          container_riwayat.html(e.html);
          loading_riwayat.removeClass('show');
        } else {
          // what to do when the response status = false
          show_notify('error', e.message);
        }
      },
      error: function(xhr, status, error) {
        show_notify('error', error);
        console.error(error);
      },
    });
  }

  /// |----------------------------------------
  /// | DOCUMENT READY
  /// |----------------------------------------
  $(document).ready(function() {
    // REQUEST RIWAYAT
    request_riwayat();
  });
</script>