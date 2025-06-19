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
    ?>

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Dashboard Sekolah</h4>
          Selamat Datang <b><?= $this->session->userdata('username'); ?></b> di aplikasi PROGURINDA - Pangkalan Data, berikut ini profil sekolah Anda :
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title space-between">
            <div>PROFIL</div>
            <div class="btn btn-sm btn-warning pull-right" onclick="on_dev()">UPDATE PROFIL ></div>
          </h4>
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
    </div>

  </div>

</div>

<script>
  $(document).ready(function() {
    // do something on document ready
  });
</script>