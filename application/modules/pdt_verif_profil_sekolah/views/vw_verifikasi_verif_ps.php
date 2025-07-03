<?php
$cur_kewenangan = $this->session->userdata('kewenangan');
?>
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Verifikasi Dokumen</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?= site_url('pdt_profil_sekolah') ?>">Verifikasi Profil Sekolah</a>
      </li>
      <li class="breadcrumb-item active">Verifikasi Dokumen Usulan Profil Sekolah</li>
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
              <?php highlight_string("<?php\nOLD_DATA = " . var_export($data, true) . ";\n\n?>"); ?>
              <?php highlight_string("<?php\nNEW_DATA = " . var_export($dokumen, true) . ";\n\n?>"); ?>
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
          <div class="alert alert-danger mb-0">
            <table>
              <tr>
                <td style="min-width: 50px; font-size: 1.5rem;" class="text-center">
                  <i class="fas fa-exclamation-triangle"></i>
                </td>
                <td style="width: 100%;" class="ps-2">
                  Silahkan lakukan pengecekan data awal dan data baru yang diusulkan untuk verifikasi, jika semua data dikonfirmasi benar silahkan pilih <b>Setuju</b> pada kolom tindak lanjut. Namun jika ada data yang tidak benar, silahkan pilih <b>Tolak</b> pada kolom tindak lanjut.<br>
                  Klik tombol <b>Verifikasi</b> di akhir halaman untuk menyelesaikan proses sesuai dengan tindak lanjut yang dipilih.
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <?php
    /// |----------------------------------------------------------------------
    /// | >> DATA AWAL 
    /// |----------------------------------------------------------------------
    ?>
    <div class="col-12 col-lg-6">

      <div class="card">
        <div class="card-body">
          <h4 class="card-title space-between mb-3">
            <div><i class="fas fa-building me-2"></i>Profil Sekolah (Saat Ini)</div>
            <div></div>
          </h4>

          <div class="row g-2">

            <div class="col-12">
              <div class="desc_block old_data old_kode_ukerja" attr-data="kode_ukerja">
                <label>Sekolah / Unit Kerja</label>
                <div><?= check_var($data, 'ket_ukerja', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_jenjang" attr-data="jenjang">
                <label>Jenjang</label>
                <div class="text_value"><?= check_var($data, 'jenjang', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_status" attr-data="status">
                <label>Status Sekolah</label>
                <div class="text_value"><?= check_var($data, 'ket_status_sekolah', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_npsn" attr-data="npsn">
                <label>NPSN</label>
                <div class="text_value"><?= check_var($data, 'npsn', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_nss" attr-data="nss">
                <label>NSS</label>
                <div class="text_value"><?= check_var($data, 'nss', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_no_statistik_bangunan" attr-data="no_statistik_bangunan">
                <label>No. Statistik Bangunan</label>
                <div class="text_value"><?= check_var($data, 'no_statistik_bangunan', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_akreditasi" attr-data="akreditasi">
                <label>Akreditasi</label>
                <div class="text_value"><?= check_var($data, 'akreditasi', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_inklusif" attr-data="inklusif">
                <label>Inklusif</label>
                <div class="text_value">
                  <?php
                  if (check_var($data, 'inklusif', '__') == '1') {
                    echo 'Ya, Sekolah ini Inklusif';
                  } elseif (check_var($data, 'inklusif', '__') == '0') {
                    echo 'Tidak, Sekolah ini tidak Inklusif';
                  } else {
                    echo '-';
                  }
                  ?>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_alamat" attr-data="alamat">
                <label>Alamat</label>
                <div class="text_value"><?= nl2br(check_var($data, 'alamat', '-')) ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_id_kecamatan" attr-data="id_kecamatan">
                <label>Kecamatan</label>
                <div class="text_value"><?= check_var($data, 'id_kecamatan', '...') . ' - ' . check_var($data, 'nama_kecamatan', '...') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_id_kelurahan" attr-data="id_kelurahan">
                <label>Kelurahan</label>
                <div class="text_value"><?= check_var($data, 'id_kelurahan', '...') . ' - ' . check_var($data, 'nama_kelurahan', '...') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_kode_pos" attr-data="kode_pos">
                <label>Kode POS</label>
                <div class="text_value"><?= check_var($data, 'kode_pos', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_map_location" attr-data="map_location">
                <label>Lokasi pada MAP</label>
                <div style="display: block; position: relative; width: calc(100% - 40px);">
                  <div id="old_map_location" style="height: 500px; z-index: 1;"></div>
                </div>
              </div>
            </div>

            <div class="col-6">
              <div class="desc_block old_data old_lat" attr-data="lat">
                <label>Latitude</label>
                <div class="text_value"><?= check_var($data, 'lat', '-') ?></div>
              </div>
            </div>

            <div class="col-6">
              <div class="desc_block old_data old_long" attr-data="long">
                <label>Longitude</label>
                <div class="text_value"><?= check_var($data, 'long', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_telepon" attr-data="telepon">
                <label>No. Telepon</label>
                <div class="text_value"><?= check_var($data, 'telepon', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_website" attr-data="website">
                <label>Website</label>
                <div class="text_value"><?= check_var($data, 'website', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_email" attr-data="email">
                <label>E-mail</label>
                <div class="text_value"><?= check_var($data, 'email', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_no_rek_bank" attr-data="no_rek_bank">
                <label>No. Rekening Bank</label>
                <div class="text_value"><?= check_var($data, 'no_rek_bank', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_nama_bank" attr-data="nama_bank">
                <label>Nama Bank</label>
                <div class="text_value"><?= check_var($data, 'nama_bank', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_cabang_kcp_unit" attr-data="cabang_kcp_unit">
                <label>Cabang KCP Unit</label>
                <div class="text_value"><?= check_var($data, 'cabang_kcp_unit', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_nama_wajib_pajak" attr-data="nama_wajib_pajak">
                <label>Nama Wajib Pajak</label>
                <div class="text_value"><?= check_var($data, 'nama_wajib_pajak', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_npwp" attr-data="npwp">
                <label>NPWP</label>
                <div class="text_value"><?= check_var($data, 'npwp', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_no_sk_pendirian" attr-data="no_sk_pendirian">
                <label>No. SK Pendirian</label>
                <div class="text_value"><?= check_var($data, 'no_sk_pendirian', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_tgl_sk_pendirian" attr-data="tgl_sk_pendirian">
                <label>Tgl. SK Pendirian</label>
                <div class="text_value">
                  <?php
                  $date_skp = check_var($data, 'tgl_sk_pendirian', '');
                  echo check_var(em_date('j F Y', 'set', $date_skp), null, '-');
                  ?>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_no_sk_izin_operasional" attr-data="no_sk_izin_operasional">
                <label>No. SK Izin Operasional</label>
                <div class="text_value"><?= check_var($data, 'no_sk_izin_operasional', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_tgl_sk_izin_operasional" attr-data="tgl_sk_izin_operasional">
                <label>Tgl. SK Izin Operasional</label>
                <div class="text_value">
                  <?php
                  $date_skio = check_var($data, 'tgl_sk_izin_operasional', '');
                  echo check_var(em_date('j F Y', 'set', $date_skio), null, '-');
                  ?>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_luas_tanah" attr-data="luas_tanah">
                <label>Luas Tanah (m<sup>2</sup>)</label>
                <div class="text_value"><?= number_format(check_var($data, 'luas_tanah', 0), 2, ',', ',') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block old_data old_kepemilikan_tanah" attr-data="kepemilikan_tanah">
                <label>Kepemilikan Tanah</label>
                <?php
                $arr_kepemilikan = [
                  'MILIK' => 'Hak Milik',
                  'SEWA' => 'Sewa',
                  'PINJAM' => 'Pinjam',
                  'invalid' => '-'
                ];
                ?>
                <div class="text_value"><?= $arr_kepemilikan[check_var($data, 'kepemilikan_tanah', 'invalid')] ?></div>
              </div>
            </div>

          </div>

        </div>
      </div>


    </div>

    <?php
    /// |----------------------------------------------------------------------
    /// | >> DATA BARU
    /// |----------------------------------------------------------------------
    ?>
    <div class="col-12 col-lg-6">

      <div class="card">
        <div class="card-body">
          <h4 class="card-title space-between mb-3">
            <div><i class="fas fa-building me-2"></i>Profil Sekolah (Baru)</div>
            <div></div>
          </h4>

          <div class="row g-2">

            <div class="col-12">
              <div class="desc_block new_data new_kode_ukerja" attr-data="kode_ukerja">
                <label>Sekolah / Unit Kerja</label>
                <div><?= check_var($dokumen, 'ket_ukerja', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_jenjang" attr-data="jenjang">
                <label>Jenjang</label>
                <div class="text_value"><?= check_var($dokumen, 'jenjang', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_status" attr-data="status">
                <label>Status Sekolah</label>
                <div class="text_value"><?= check_var($dokumen, 'ket_status_sekolah', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_npsn" attr-data="npsn">
                <label>NPSN</label>
                <div class="text_value"><?= check_var($dokumen, 'npsn', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_nss" attr-data="nss">
                <label>NSS</label>
                <div class="text_value"><?= check_var($dokumen, 'nss', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_no_statistik_bangunan" attr-data="no_statistik_bangunan">
                <label>No. Statistik Bangunan</label>
                <div class="text_value"><?= check_var($dokumen, 'no_statistik_bangunan', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_akreditasi" attr-data="akreditasi">
                <label>Akreditasi</label>
                <div class="text_value"><?= check_var($dokumen, 'akreditasi', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_inklusif" attr-data="inklusif">
                <label>Inklusif</label>
                <div class="text_value">
                  <?php
                  if (check_var($dokumen, 'inklusif', '__') == '1') {
                    echo 'Ya, Sekolah ini Inklusif';
                  } elseif (check_var($dokumen, 'inklusif', '__') == '0') {
                    echo 'Tidak, Sekolah ini tidak Inklusif';
                  } else {
                    echo '-';
                  }
                  ?>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_alamat" attr-data="alamat">
                <label>Alamat</label>
                <div class="text_value"><?= nl2br(check_var($dokumen, 'alamat', '-')) ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_id_kecamatan" attr-data="id_kecamatan">
                <label>Kecamatan</label>
                <div class="text_value"><?= check_var($dokumen, 'id_kecamatan', '...') . ' - ' . check_var($dokumen, 'nama_kecamatan', '...') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_id_kelurahan" attr-data="id_kelurahan">
                <label>Kelurahan</label>
                <div class="text_value"><?= check_var($dokumen, 'id_kelurahan', '...') . ' - ' . check_var($dokumen, 'nama_kelurahan', '...') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_kode_pos" attr-data="kode_pos">
                <label>Kode POS</label>
                <div class="text_value"><?= check_var($dokumen, 'kode_pos', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_map_location" attr-data="map_location">
                <label>Lokasi pada MAP</label>
                <div style="display: block; position: relative; width: calc(100% - 40px);">
                  <div id="new_map_location" style="height: 500px; z-index: 1;"></div>
                </div>
              </div>
            </div>

            <div class="col-6">
              <div class="desc_block new_data new_lat" attr-data="lat">
                <label>Latitude</label>
                <div class="text_value"><?= check_var($dokumen, 'lat', '-') ?></div>
              </div>
            </div>

            <div class="col-6">
              <div class="desc_block new_data new_long" attr-data="long">
                <label>Longitude</label>
                <div class="text_value"><?= check_var($dokumen, 'long', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_telepon" attr-data="telepon">
                <label>No. Telepon</label>
                <div class="text_value"><?= check_var($dokumen, 'telepon', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_website" attr-data="website">
                <label>Website</label>
                <div class="text_value"><?= check_var($dokumen, 'website', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_email" attr-data="email">
                <label>E-mail</label>
                <div class="text_value"><?= check_var($dokumen, 'email', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_no_rek_bank" attr-data="no_rek_bank">
                <label>No. Rekening Bank</label>
                <div class="text_value"><?= check_var($dokumen, 'no_rek_bank', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_nama_bank" attr-data="nama_bank">
                <label>Nama Bank</label>
                <div class="text_value"><?= check_var($dokumen, 'nama_bank', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_cabang_kcp_unit" attr-data="cabang_kcp_unit">
                <label>Cabang KCP Unit</label>
                <div class="text_value"><?= check_var($dokumen, 'cabang_kcp_unit', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_nama_wajib_pajak" attr-data="nama_wajib_pajak">
                <label>Nama Wajib Pajak</label>
                <div class="text_value"><?= check_var($dokumen, 'nama_wajib_pajak', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_npwp" attr-data="npwp">
                <label>NPWP</label>
                <div class="text_value"><?= check_var($dokumen, 'npwp', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_no_sk_pendirian" attr-data="no_sk_pendirian">
                <label>No. SK Pendirian</label>
                <div class="text_value"><?= check_var($dokumen, 'no_sk_pendirian', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_tgl_sk_pendirian" attr-data="tgl_sk_pendirian">
                <label>Tgl. SK Pendirian</label>
                <div class="text_value">
                  <?php
                  $date_skp = check_var($dokumen, 'tgl_sk_pendirian', '');
                  echo check_var(em_date('j F Y', 'set', $date_skp), null, '-');
                  ?>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_no_sk_izin_operasional" attr-data="no_sk_izin_operasional">
                <label>No. SK Izin Operasional</label>
                <div class="text_value"><?= check_var($dokumen, 'no_sk_izin_operasional', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_tgl_sk_izin_operasional" attr-data="tgl_sk_izin_operasional">
                <label>Tgl. SK Izin Operasional</label>
                <div class="text_value">
                  <?php
                  $date_skio = check_var($dokumen, 'tgl_sk_izin_operasional', '');
                  echo check_var(em_date('j F Y', 'set', $date_skio), null, '-');
                  ?>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_luas_tanah" attr-data="luas_tanah">
                <label>Luas Tanah (m<sup>2</sup>)</label>
                <div class="text_value"><?= number_format(check_var($dokumen, 'luas_tanah', 0), 2, ',', ',') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_kepemilikan_tanah" attr-data="kepemilikan_tanah">
                <label>Kepemilikan Tanah</label>
                <?php
                $arr_kepemilikan = [
                  'MILIK' => 'Hak Milik',
                  'SEWA' => 'Sewa',
                  'PINJAM' => 'Pinjam',
                  'invalid' => '-'
                ];
                ?>
                <div class="text_value"><?= $arr_kepemilikan[check_var($dokumen, 'kepemilikan_tanah', 'invalid')] ?></div>
              </div>
            </div>

          </div>

        </div>
      </div>


    </div>

  </div>

</div>

<script>
  function match_old_new_height() {
    $('.old_data').each(function() {
      const $old = $(this);
      const attr = $old.attr('attr-data');
      const $new = $('.new_data[attr-data="' + attr + '"]');

      if ($new.length) {
        // Reset heights first
        $old.css('min-height', '');
        $new.css('min-height', '');

        const oldHeight = $old.outerHeight();
        const newHeight = $new.outerHeight();
        const maxHeight = Math.max(oldHeight, newHeight);

        $old.css('min-height', maxHeight);
        $new.css('min-height', maxHeight);
      }
    });
  }

  <?php
  $new_change = get_changed_data($data, $dokumen);
  if (check_var($new_change, 'after')) {
    // kalau ada data yang beda, lakukan penambahan class ke desc_block nya
    foreach ($new_change['after'] as $key => $value) {
      echo "$('.new_{$key}').addClass('new_change');";
      if ($key == 'lat' || $key == 'long') {
        echo "$('.new_map_location').addClass('new_change');";
      }
    }
  }
  ?>

  /// |----------------------------------------
  /// | DOCUMENT READY
  /// |----------------------------------------
  $(document).ready(function() {
    /// |----------------------------------------
    /// | FORM SUBMISSION
    /// |----------------------------------------
    $('#form_edit_profil_sekolah').validate($.extend({
      submitHandler: function(form, event) {
        // declare element that will be affected
        // by every state of the form submission
        // right here
        let submit = $('.form_action_button');

        // declare button submit disabling right here if needed
        submit.attr('disabled', true);

        // change url based on which button pressed
        $(form).attr('action', form_action_url);

        $(form).ajaxSubmit({
          success: function(e) {
            if (e.status) {
              // what to do when the response status = true
              show_notify('success', e.message);
              setTimeout(() => {
                window.location.href = '<?= site_url('pdt_profil_sekolah') ?>/' + e.redirect + '/<?= $data['id_dokumen'] ?>';
              }, 2000);
            } else {
              // what to do when the response status = false
              show_notify('error', e.message);
              submit.attr('disabled', false);

              // reset error
              $('#form_edit_profil_sekolah .is-invalid').removeClass('is-invalid');
              $('#form_edit_profil_sekolah .invalid-feedback').html('');

              if (e.error_value) {
                $.each(e.error_value, function(field, error) {
                  const el_input = $('#' + field);
                  const wrapper = el_input.closest('.input_block');
                  const el_flatpickrInput = wrapper.find('.flatpickr');
                  const el_select2Input = wrapper.find('.select2-selection');
                  const el_select2Container = wrapper.find('.select2.select2-container');

                  el_input.addClass('is-invalid');
                  if (el_select2Input.length) {
                    el_select2Container.addClass('is-invalid');
                    el_select2Input.addClass('is-invalid');
                  } else if (el_flatpickrInput.length) {
                    el_flatpickrInput.addClass('is-invalid');
                  }

                  $('#error_' + field).html(error); // Display message
                });
              }
            }
          },
          error: function(xhr, status, error) {
            show_notify('error', xhr.status + ' : ' + error);
            console.error(error);
            submit.attr('disabled', false);
          },
          dataType: 'json'
        });
      },
      rules: {
        // nuptr: {
        //   required: true
        // },
      },
      errorClass: 'is-invalid',
      validClass: 'mv-valid',
      /* if there's select2 element, please use this errorPlacement */
      errorPlacement: function(error, element) {
        const feedback = element.closest('.form-floating').find('.invalid-feedback');
        if (feedback.length) {
          feedback.text(error.text());
        }
      },
      highlight: function(element) {
        $(element).addClass('is-invalid');
      },

      unhighlight: function(element) {
        const $el = $(element);
        const closest = $el.closest('.input_block');
        closest.find('.is-invalid').removeClass('is-invalid');
        $('#error_' + $el.attr('id')).html('');
      },
      messages: {
        // NUPTR: {
        //   required: "Username tidak boleh kosong!",
        // },
        // password: {
        //   required: "Password tidak boleh kosong!",
        //   minlength: "Password minimal 6 karakter!"
        // }
      },
    }));

    /// |----------------------------------------
    /// | MAP FUNCTIONALITY (OLD DATA)
    /// |----------------------------------------
    // Default coordinates if no value is set
    const old_defaultLat = <?= check_var($data, 'lat', ' -0.492215') ?>;
    const old_defaultLng = <?= check_var($data, 'long', '117.1432875') ?>;

    // Get initial coordinates
    var old_lat = $('.old_lat').val() || old_defaultLat;
    var old_lng = $('.old_long').val() || old_defaultLng;

    // Init map
    const old_map = L.map('old_map_location').setView([old_lat, old_lng], 17);

    // OPEN STREET MAP
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors',
      maxZoom: 19
    }).addTo(old_map);

    // Marker
    var old_marker = L.marker([old_lat, old_lng], {
      draggable: false
    }).addTo(old_map);

    /// |----------------------------------------
    /// | MAP FUNCTIONALITY (NEW DATA)
    /// |----------------------------------------
    // Default coordinates if no value is set
    const new_defaultLat = <?= check_var($dokumen, 'lat', ' -0.492215') ?>;
    const new_defaultLng = <?= check_var($dokumen, 'long', '117.1432875') ?>;

    // Get initial coordinates
    var new_lat = $('.new_lat').val() || new_defaultLat;
    var new_lng = $('.new_long').val() || new_defaultLng;

    // Init map
    const new_map = L.map('new_map_location').setView([new_lat, new_lng], 17);

    // OPEN STREET MAP
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors',
      maxZoom: 19
    }).addTo(new_map);

    // Marker
    var new_marker = L.marker([new_lat, new_lng], {
      draggable: false
    }).addTo(new_map);

    setTimeout(() => {
      match_old_new_height();
    }, 150);
  });
</script>