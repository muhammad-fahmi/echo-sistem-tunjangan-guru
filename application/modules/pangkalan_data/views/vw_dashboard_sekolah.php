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

    <?php
    $data_kepsek = check_var($data, 'kepsek', []);
    $data_sekolah = check_var($data, 'sekolah', []);
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
            <a href="<?= site_url('pdt_profil_sekolah') ?>" class="btn btn-sm btn-warning pull-right">UPDATE PROFIL SEKOLAH <i class="fas fa-arrow-right ms-2"></i></a>
          </h4>
        </div>

        <?php
        /// |----------------------------------------------------------------------
        /// | >> DATA PROFIL SEKOLAH
        /// |----------------------------------------------------------------------
        ?>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <table class="table table-sm table-hover">
                <tr>
                  <td style="min-width: 150px;">NAMA</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'ket_ukerja', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">JENJANG</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'jenjang', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">STATUS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <?php
                    $status = check_var($data_sekolah, 'status', null);
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
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'npsn', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NSS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'nss', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. STATISTIK BANGUNAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'no_statistik_bangunan', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">AKREDITASI</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'akreditasi', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">INKLUSIF</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <?php
                  $inklusif = check_var($data_sekolah, 'inklusif', '-');
                  if ($inklusif == '1') $inklusif = 'Ya';
                  if ($inklusif == '0') $inklusif = 'Tidak';
                  ?>
                  <td style="width: 100%;"><?= $inklusif ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">ALAMAT</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'alamat', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">KELURAHAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'nama_kelurahan', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">KECAMATAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'nama_kecamatan', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">KODE POS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'kode_pos', '-') ?></td>
                </tr>
                <!-- <tr>
                  <td style="min-width: 150px;">LATITUDE</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'lat', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">LONGITUDE</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'long', '-') ?></td>
                </tr> -->
                <tr>
                  <td style="min-width: 150px;">NO. TELEPON</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'telepon', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">WEBSITE</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'website', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">EMAIL</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'email', '-') ?></td>
                </tr>
                <!-- <tr>
                  <td style="min-width: 150px;">NO. REK BANK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'no_rek_bank', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NAMA BANK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'nama_bank', '-') ?></td>
                </tr> -->
                <tr>
                  <td style="min-width: 150px;">CABANG KCP UNIT</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'cabang_kcp_unit', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NAMA WAJIB PAJAK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'nama_wajib_pajak', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NPWP</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'npwp', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. SK PENDIRIAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'no_sk_pendirian', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">TGL. SK PENDIRIAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <?php
                  $tgl_sk_pendirian = check_var($data_sekolah, 'tgl_sk_pendirian', '');
                  $tgl_sk_pendirian_display = check_var(em_date('j F Y', 'set', $tgl_sk_pendirian), null, '-');
                  ?>
                  <td style="width: 100%;"><?= $tgl_sk_pendirian_display ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. SK IZIN OPERASIONAL</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'no_sk_izin_operasional', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">TGL. SK IZIN OPERASIONAL</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <?php
                  $tgl_sk_izin_operasional = check_var($data_sekolah, 'tgl_sk_izin_operasional', '');
                  $tgl_sk_izin_operasional_display = check_var(em_date('j F Y', 'set', $tgl_sk_izin_operasional), null, '-');
                  ?>
                  <td style="width: 100%;"><?= $tgl_sk_izin_operasional_display ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">LUAS TANAH</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= to_rp(check_var($data_sekolah, 'luas_tanah', '-'), false) . ' m<sup>2</sup>' ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">KEPEMILIKAN TANAH</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_sekolah, 'kepemilikan_tanah', '-') ?></td>
                </tr>
              </table>
            </div>

            <div class="col-12">
              <div style="display: block; position: relative; width: calc(100% - 40px);">
                <div id="map_location" style="height: 500px; z-index: 1;"></div>
              </div>
            </div>
          </div>

        </div>

        <div class="card-footer">
          <h4 class="card-title space-between">
            <div>PROFIL KEPALA SEKOLAH</div>
            <a href="<?= site_url('pdt_profil_kepsek') ?>" class="btn btn-sm btn-info pull-right">UPDATE PROFIL KEPALA SEKOLAH <i class="fas fa-arrow-right ms-2"></i></a>
          </h4>
        </div>

        <?php
        /// |----------------------------------------------------------------------
        /// | >> DATA PROFIL KEPALA SEKOLAH
        /// |----------------------------------------------------------------------
        ?>
        <div class="card-body">
          <div class="row">
            <!-- FOTO KEPALA SEKOLAH -->
            <div class="col-12 col-lg-3 col-xl-1">
              <div class="img_profil_md">
                <img src="http://36.66.236.83/simpeg/foto/<?= check_var($data_kepsek, 'nip', '0000') ?>.jpg" onerror="this.onerror=null; this.src='<?= base_url('theme/assets/images/default-profile.jpg') ?>';" alt="ALT_Description">
              </div>
            </div>
            <!-- DATA INFORMASI SEKOLAH -->
            <div class="col-12 col-lg-9 col-xl-11">
              <table class="table table-sm table-hover">
                <tr>
                  <td style="min-width: 150px;">NAMA</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'nama', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NIP</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'nip', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NUPTR</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'nuptr', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NURS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'nurs', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NRG</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'nrg', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NIK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'nik', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">JENIS KELAMIN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <?php
                  $jkelamin = check_var($data_kepsek, 'jenis_kelamin', '-');
                  if ($jkelamin == 'L') $jkelamin = 'Laki-Laki';
                  if ($jkelamin == 'P') $jkelamin = 'Perempuan';
                  ?>
                  <td style="width: 100%;"><?= $jkelamin ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">TGL. LAHIR</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <?php
                  $tgl_lahir = check_var($data_kepsek, 'tgl_lahir', '');
                  $tgl_lahir_display = em_date('j F Y', 'set', $tgl_lahir);
                  ?>
                  <td style="width: 100%;"><?= check_var($tgl_lahir_display, null, '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">ALAMAT SAAT INI</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'alamat_saat_ini', '-') ?></td>
                </tr>
                <!-- <tr>
                  <td colspan="3">
                    <?php highlight_string("<?php\nOUTPUT = " . var_export($data_kepsek, true) . ";\n?>"); ?>
                  </td>
                </tr> -->
                <tr>
                  <td style="min-width: 150px;">STATUS PERNIKAHAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'ket_status_pernikahan', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">KODE DIDIK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'kode_didik', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">PENDIDIKAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'pendidikan', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. SERTIFIKAT PENDIDIKAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'no_sertifikat_pendidikan', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. SERTIFIKAT GP</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'no_sertifikat_gp', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. SERTIFIKAT CRS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'no_sertifikat_crs', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. REK BANK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'no_rek_bank', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NPWP</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'npwp', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">MENERIMA TTP INSENTIF</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <?php
                  $menerima_ttp = check_var($data_kepsek, 'menerima_ttp_insentif', '-');
                  if ($menerima_ttp == 'Y') $menerima_ttp = 'Menerima';
                  if ($menerima_ttp == 'N') $menerima_ttp = 'Tidak Menerima';
                  ?>
                  <td style="width: 100%;"><?= $menerima_ttp ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">STATUS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'ket_status', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">EMAIL</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'email', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. TELEPON / HP</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'no_hp', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">AGAMA</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'ket_agama', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">PERIODE</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data_kepsek, 'periode_ke', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">MASA PENUGASAN (MULAI)</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <?php
                  $tgl_mulai = check_var($data_kepsek, 'masa_penugasan_mulai', '');
                  $tgl_selesai = check_var($data_kepsek, 'masa_penugasan_selesai', '');
                  $mulai_display = check_var(em_date('j F Y', 'set', $tgl_mulai), null, '-');
                  $selesai_display = check_var(em_date('j F Y', 'set', $tgl_selesai), null, '-');
                  ?>
                  <td style="width: 100%;"><?= $mulai_display ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">MASA PENUGASAN (SELESAI)</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= $selesai_display ?></td>
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
    /// |----------------------------------------
    /// | MAP FUNCTIONALITY
    /// |----------------------------------------
    // Default coordinates if no value is set
    const defaultLat = <?= check_var($data_sekolah, 'lat', ' -0.492215') ?>;
    const defaultLng = <?= check_var($data_sekolah, 'long', '117.1432875') ?>;

    // Get initial coordinates
    let lat = $('#lat').val() || defaultLat;
    let lng = $('#long').val() || defaultLng;

    // Init map
    const map = L.map('map_location').setView([lat, lng], 17);

    // STADIAMAPS
    // L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png', {
    //   maxZoom: 20,
    //   attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, © OpenMapTiles, © OpenStreetMap contributors'
    // }).addTo(map);

    // CARTO VOYAGER
    // L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
    //   attribution: '&copy; <a href="https://carto.com/">CARTO</a> © OpenStreetMap contributors',
    //   subdomains: 'abcd',
    //   maxZoom: 20
    // }).addTo(map);

    // OPEN STREET MAP
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors',
      maxZoom: 19
    }).addTo(map);

    // Marker
    let marker = L.marker([lat, lng], {
      draggable: false
    }).addTo(map);
  });
</script>