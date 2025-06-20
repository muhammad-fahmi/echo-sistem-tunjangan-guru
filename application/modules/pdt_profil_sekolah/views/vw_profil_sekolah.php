<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Update Profil Sekolah</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item">Update Profil</li>
      <li class="breadcrumb-item active">Sekolah</li>
    </ol>
  </div>
</div>

<div class="container-fluid">

  <div class="row">

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title space-between">
            <div>PROFIL SEKOLAH</div>
            <div class="btn btn-sm btn-warning pull-right" onclick="on_dev()">UPDATE PROFIL ></div>
          </h4>
          <div class="row">
            <!-- FOTO GEDUNG SEKOLAH -->
            <div class="col-4 d-flex-center" style="display: block; align-content: center;">
              <div class="card">
                <div class="text-center">FOTO GEDUNG</div>
              </div>
              <div class="d-flex">
                <input type="file" name="foto_sekolah" id="foto_sekolah" class="form-control form-control">
              </div>
            </div>
            <!-- DATA INFORMASI SEKOLAH -->
            <div class="col-8">
              <table class="table table-sm table-hover">
                <tr>
                  <td style="min-width: 150px;">NAMA</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="nama" id="nama" class="form-control form-input-bg" value="<?= check_var($data, 'ket_ukerja', '-') ?>">
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">JENJANG</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="jenjang" id="jenjang" class="form-control form-input-bg" value="<?= check_var($data, 'jenjang', '-') ?>">
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">STATUS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <select name="status" id="status" class="form-control form-control" style="width:100%">
                      <?php $selected = ($data["status"] != "") ? "selected" : ""; ?>
                      <option value=""> - - - Pilih Status Sekolah - - - </option>
                      <option value="S"> SWASTA </option>
                      <option value="N"> NEGERI </option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NPSN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="npsn" id="npsn" class="form-control form-input-bg" value="<?= check_var($data, 'npsn', '-') ?>">
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NSS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="nss" id="nss" class="form-control form-input-bg" value="<?= check_var($data, 'nss', '-') ?>">
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. STATISTIK BANGUNAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="no_statistik_bangunan" id="no_statistik_bangunan" class="form-control form-input-bg" value="<?= check_var($data, 'no_statistik_bangunan', '-') ?>">
                  </td>
                </tr>
              </table>
            </div>

            <div class="col-12">
              <table class="table table-sm table-hover">
                <tr>
                  <td style="min-width: 150px;">AKREDITASI</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="akreditasi" id="akreditasi" class="form-control form-input-bg" value="<?= check_var($data, 'akreditasi', '-') ?>">
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">INKLUSIF</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="inklusif" id="inklusif" class="form-control form-input-bg" value="<?= check_var($data, 'inklusif', '-') ?>">
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">ALAMAT</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="alamat" id="alamat" class="form-control form-input-bg" value="<?= check_var($data, 'alamat', '-') ?>">
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">KELURAHAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="id_kelurahan" id="id_kelurahan" class="form-control form-input-bg" value="<?= check_var($data, 'id_kelurahan', '-') ?>">
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">KECAMATAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="id_kecamatan" id="id_kecamatan" class="form-control form-input-bg" value="<?= check_var($data, 'id_kecamatan', '-') ?>">
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">KODE POS</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="kode_pos" id="kode_pos" class="form-control form-input-bg" value="<?= check_var($data, 'kode_pos', '-') ?>">
                  </td>
                </tr>
                <!-- <tr>
                  <td style="min-width: 150px;">LATITUDE</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="lat" id="lat" class="form-control form-input-bg" value="<?= check_var($data, 'lat', '-') ?>">
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">LONGITUDE</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="long" id="long" class="form-control form-input-bg" value="<?= check_var($data, 'long', '-') ?>">
                  </td>
                </tr> -->
                <tr>
                  <td style="min-width: 150px;">NO. TELEPON</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="telepon" id="telepon" class="form-control form-input-bg" value="<?= check_var($data, 'telepon', '-') ?>">
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">WEBSITE</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="website" id="website" class="form-control form-input-bg" value="<?= check_var($data, 'website', '-') ?>">
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">EMAIL</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="email" name="email" id="email" class="form-control form-input-bg" value="<?= check_var($data, 'email', '-') ?>">
                  </td>
                </tr>
                <!-- <tr>
                  <td style="min-width: 150px;">NO. REK BANK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="no_rek_bank" id="no_rek_bank" class="form-control form-input-bg" value="<?= check_var($data, 'no_rek_bank', '-') ?>">
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NAMA BANK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="nama_bank" id="nama_bank" class="form-control form-input-bg" value="<?= check_var($data, 'nama_bank', '-') ?>">
                  </td>
                </tr> -->
                <tr>
                  <td style="min-width: 150px;">CABANG KCP UNIT</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="cabang_kcp_unit" id="cabang_kcp_unit" class="form-control form-input-bg" value="<?= check_var($data, 'cabang_kcp_unit', '-') ?>">
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NAMA WAJIB PAJAK</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="akreditasi" id="akreditasi" class="form-control form-input-bg" value="<?= check_var($data, 'akreditasi', '-') ?>">
                    <?= check_var($data, 'nama_wajib_pajak', '-') ?>
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NPWP</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="akreditasi" id="akreditasi" class="form-control form-input-bg" value="<?= check_var($data, 'akreditasi', '-') ?>">
                    <?= check_var($data, 'npwp', '-') ?>
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. SK PENDIRIAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="akreditasi" id="akreditasi" class="form-control form-input-bg" value="<?= check_var($data, 'akreditasi', '-') ?>">
                    <?= check_var($data, 'no_sk_pendirian', '-') ?>
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">TGL SK PENDIRIAN</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="akreditasi" id="akreditasi" class="form-control form-input-bg" value="<?= check_var($data, 'akreditasi', '-') ?>">
                    <?= check_var($data, 'tgl_sk_pendirian', '-') ?>
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NO. SK IZIN OPERASIONAL</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="akreditasi" id="akreditasi" class="form-control form-input-bg" value="<?= check_var($data, 'akreditasi', '-') ?>">
                    <?= check_var($data, 'no_sk_izin_operasional', '-') ?>
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">TGL SK OPERASIONAL</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="akreditasi" id="akreditasi" class="form-control form-input-bg" value="<?= check_var($data, 'akreditasi', '-') ?>">
                    <?= check_var($data, 'tgl_sk_izin_operasional', '-') ?>
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">LUAS TANAH</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="akreditasi" id="akreditasi" class="form-control form-input-bg" value="<?= check_var($data, 'akreditasi', '-') ?>">
                    <?= check_var($data, 'luas_tanah', '-') ?>
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">KEPEMILIKAN TANAH</td>
                  <td style="min-width: 20px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <input type="text" name="akreditasi" id="akreditasi" class="form-control form-input-bg" value="<?= check_var($data, 'akreditasi', '-') ?>">
                    <?= check_var($data, 'kepemilikan_tanah', '-') ?>
                  </td>
                </tr>
              </table>
            </div>
          </div>

          <div class="row">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.659744381474!2d117.1386300758696!3d-0.5108356352720974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67fbb2d3ac943%3A0xf8018e7d7a7a8af2!2sSMP%20Negeri%203%20Samarinda!5e0!3m2!1sid!2sid!4v1750324897367!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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