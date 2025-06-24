<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Dashboard Sekolah</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </div>
</div>

<div class="container-fluid">

  <div class="row">

    <!-- <?php
          $show_debug = true;
          if ($show_debug) {
          ?>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">SESSION DATA (DEBUG)</h4>
            <small>
              <?php highlight_string("<?php\nSESSION = " . var_export($this->session->userdata(), true) . ";\n?>"); ?>
              <?php highlight_string("<?php\nDATA = " . var_export($data, true) . ";\n?>"); ?>
            </small>
          </div>
        </div>
      </div>
    <?php
          }
    ?> -->

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- <h4 class="card-title">Dashboard Sekolah</h4> -->
          Selamat Datang <b><?= $this->session->userdata('username'); ?></b> di aplikasi PROGURINDA - Pangkalan Data, berikut ini profil sekolah Anda :
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title space-between">
            <div>PROFIL SEKOLAH</div>
            <div class="btn btn-sm btn-warning pull-right" onclick="<?= site_url('pdt_profil_sekolah') ?>">UPDATE PROFIL SEKOLAH <i class="fas fa-arrow-right ms-2"></i></div>
          </h4>
        </div>
        <div class="card-body">
          <div class="row">
            <!-- FOTO GEDUNG SEKOLAH -->
            <div class="col-12 col-lg-4 d-flex-center" style="display: block; align-content: center;">
              <div class="card">
                <div class="text-center">FOTO GEDUNG</div>
              </div>
            </div>
            <!-- DATA INFORMASI SEKOLAH -->
            <div class="col-12 col-lg-8">
              <table class="table table-sm table-hover">
                <tr>
                  <td style="min-width: 150px;">NAMA</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'ket_ukerja', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">JENJANG</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'jenjang', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">STATUS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <?php
                    $status = check_var($data, 'status', null);
                    $ket_status = '-';
                    if ($status == 'N') $ket_status = 'Negeri';
                    if ($status == 'S') $ket_status = 'Swasta';
                    echo $ket_status;
                    ?>
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NPSN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'npsn', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NSS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'nss', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. STATISTIK BANGUNAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'no_statistik_bangunan', '-') ?></td>
                </tr>
              </table>
            </div>

            <div class="col-12 col-lg-12">
              <table class="table table-sm table-hover">
                <tr>
                  <td style="min-width: 150px;">AKREDITASI</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'akreditasi', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">INKLUSIF</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'inklusif', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">ALAMAT</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'alamat', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">KELURAHAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'id_kelurahan', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">KECAMATAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'id_kecamatan', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">KODE POS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'kode_pos', '-') ?></td>
                </tr>
                <!-- <tr>
                  <td style="min-width: 150px;">LATITUDE</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'lat', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">LONGITUDE</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'long', '-') ?></td>
                </tr> -->
                <tr>
                  <td style="min-width: 150px;">NO. TELEPON</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'telepon', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">WEBSITE</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'website', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">EMAIL</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'email', '-') ?></td>
                </tr>
                <!-- <tr>
                  <td style="min-width: 150px;">NO. REK BANK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'no_rek_bank', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NAMA BANK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'nama_bank', '-') ?></td>
                </tr> -->
                <tr>
                  <td style="min-width: 150px;">CABANG KCP UNIT</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'cabang_kcp_unit', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NAMA WAJIB PAJAK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'nama_wajib_pajak', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NPWP</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'npwp', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. SK PENDIRIAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'no_sk_pendirian', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">TGL SK PENDIRIAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'tgl_sk_pendirian', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. SK IZIN OPERASIONAL</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'no_sk_izin_operasional', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">TGL SK OPERASIONAL</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'tgl_sk_izin_operasional', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">LUAS TANAH</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'luas_tanah', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">KEPEMILIKAN TANAH</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'kepemilikan_tanah', '-') ?></td>
                </tr>
              </table>
            </div>
          </div>

          <div class="row">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.659744381474!2d117.1386300758696!3d-0.5108356352720974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67fbb2d3ac943%3A0xf8018e7d7a7a8af2!2sSMP%20Negeri%203%20Samarinda!5e0!3m2!1sid!2sid!4v1750324897367!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
        <div class="card-footer">
          <h4 class="card-title space-between">
            <div>PROFIL KEPALA SEKOLAH</div>
            <div class="btn btn-sm btn-info pull-right" onclick="<?= site_url('pdt_profil_sekolah') ?>">UPDATE PROFIL KEPALA SEKOLAH <i class="fas fa-arrow-right ms-2"></i></div>
          </h4>
        </div>
        <div class="card-body">
          <div class="row">
            <!-- FOTO KEPALA SEKOLAH -->
            <div class="col-12 col-lg-4 d-flex-center" style="display: block; align-content: center;">
              <div class="card">
                <div class="text-center">FOTO KEPSEK</div>
              </div>
            </div>
            <!-- DATA INFORMASI SEKOLAH -->
            <div class="col-12 col-lg-8">
              <table class="table table-sm table-hover">
                <tr>
                  <td style="min-width: 150px;">NAMA</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'nama', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NIP</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'nip', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NUPTR</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'nuptr', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NURS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'nurs', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NRG</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'nrg', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NIK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'nik', '-') ?></td>
                </tr>
              </table>
            </div>

            <div class="col-12 col-lg-12">
              <table class="table table-sm table-hover">
                <tr>
                  <td style="min-width: 150px;">JENIS KELAMIN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'jenis_kelamin', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">TGL LAHIR</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'tgl_lahir', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">ALAMAT SAAT INI</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'alamat_saat_ini', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">STATUS PERNIKAHAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'status_pernikahan', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">KODE DIDIK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'kode_didik', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">PENDIDIKAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'pendidikan', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. SERTIFIKAT PENDIDIKAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'no_sertifikat_pendidikan', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. SERTIFIKAT GP</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'no_sertifikat_gp', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. SERTIFIKAT CRS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'no_sertifikat_crs', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. REK BANK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'no_rek_bank', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NPWP</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'npwp', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">MENERIMA TTP INSENTIF</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'menerima_ttp_insentif', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">STATUS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'status', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">EMAIL</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'email', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. TELEPON / HP</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'no_hp', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">AGAMA</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'kode_agama', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">PERIODE</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'periode_ke', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">MASA PENUGASAN (MULAI)</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'masa_penugasan_mulai', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">MASA PENUGASAN (SELESAI)</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'masa_penugasan_selesai', '-') ?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

<script>
  $(document).ready(function() {
    // do something on document ready
  });
</script>