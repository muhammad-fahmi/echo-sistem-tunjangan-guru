<?php
$cur_kewenangan = $this->session->userdata('kewenangan');
?>
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Edit Dokumen</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?= site_url('pdt_profil_sekolah') ?>">Update Profil Sekolah</a>
      </li>
      <li class="breadcrumb-item active">Edit Dokumen</li>
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
          <div class="card-title">DATA (DEBUG)</div>
          <div class="card-body">
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
        <div class="card-title space-between">
          <div><i class="fas fa-file me-2"></i>Data Dokumen</div>
          <div></div>
        </div>
        <div class="card-body">
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
      <form id="form_edit_profil_sekolah" action="<?= site_url('pdt_profil_sekolah/edit') ?>" method="POST">
        <input type="hidden" name="id_dokumen" value="<?= check_var($data, 'id_dokumen', '') ?>">

        <div class="card">
          <div class="card-title space-between">
            <div><i class="fas fa-building me-2"></i>Profil Sekolah</div>
            <div></div>
          </div>
          <div class="card-body">

            <div class="row g-2">

              <!-- <div class="col-12 col-lg-3 col-xl-1"></div> -->

              <!-- <div class="col-12 col-lg-9 col-xl-11"> -->
              <div class="col-12">
                <div class="row g-2">

                  <div class="col-12">
                    <div class="desc_block">
                      <label>Sekolah / Unit Kerja</label>
                      <div><?= check_var($data, 'ket_ukerja', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="jenjang">Jenjang</label>
                      <select name="jenjang" id="jenjang" class="form-select">
                        <option value="" default hidden>- Pilih Jenjang -</option>
                        <?php
                        $arr_jenjang = ['TK', 'SD', 'SMP'];
                        foreach ($arr_jenjang as $value) {
                          $selected = ($value == $data['jenjang']) ? 'selected' : '';
                          echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
                        }
                        ?>
                      </select>
                      <div class="invalid-feedback" id="error_jenjang"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="status">Status Sekolah</label>
                      <select name="status" id="status" class="form-select select2_status">
                        <option value="" default hidden>- Pilih Status Sekolah -</option>
                        <?= (check_var($data, 'ket_status_sekolah', false) !== false)
                          ? '<option value="' . $data['status'] . '" selected>' . $data['ket_status_sekolah'] . '</option>'
                          : '' ?>
                      </select>
                      <div class="invalid-feedback" id="error_status"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="npsn">NPSN</label>
                      <input id="npsn" name="npsn" type="text" class="form-control" value="<?= check_var($data, 'npsn', '') ?>">
                      <div class="invalid-feedback" id="error_npsn"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="nss">NSS</label>
                      <input id="nss" name="nss" type="text" class="form-control" value="<?= check_var($data, 'nss', '') ?>">
                      <div class="invalid-feedback" id="error_nss"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="no_statistik_bangunan">No. Statistik Bangunan</label>
                      <input id="no_statistik_bangunan" name="no_statistik_bangunan" type="text" class="form-control" value="<?= check_var($data, 'no_statistik_bangunan', '') ?>">
                      <div class="invalid-feedback" id="error_no_statistik_bangunan"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="akreditasi">Akreditasi</label>
                      <?php
                      $akr = check_var($data, 'akreditasi', '');
                      ?>
                      <select name="akreditasi" id="akreditasi" class="form-select">
                        <option value="" default hidden>- Pilih Akreditasi -</option>
                        <option value="A" <?= ($akr == 'A') ? 'selected' : ''; ?>>Akreditasi A</option>
                        <option value="B" <?= ($akr == 'B') ? 'selected' : ''; ?>>Akreditasi B</option>
                        <option value="C" <?= ($akr == 'C') ? 'selected' : ''; ?>>Akreditasi C</option>
                      </select>
                      <div class="invalid-feedback" id="error_akreditasi"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="inklusif">Inklusif</label>
                      <select name="inklusif" id="inklusif" class="form-select">
                        <option value="" default hidden>- Pilih Tipe Inklusif -</option>
                        <option value="1" <?= (check_var($data, 'inklusif', '') == '1') ? 'selected' : '' ?>>Ya, Sekolah ini Inklusif</option>
                        <option value="0" <?= (check_var($data, 'inklusif', '') == '0') ? 'selected' : '' ?>>Tidak, Sekolah ini tidak Inklusif</option>
                      </select>
                      <div class="invalid-feedback" id="error_inklusif"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="alamat">Alamat</label>
                      <textarea id="alamat" name="alamat" rows="3" class="form-control"><?= check_var($data, 'alamat', '') ?></textarea>
                      <div class="invalid-feedback" id="error_alamat"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="id_kecamatan">Kecamatan</label>
                      <select name="id_kecamatan" id="id_kecamatan" class="form-select select2_kecamatan">
                        <option value="" default hidden>- Pilih Kecamatan -</option>
                        <?= (check_var($data, 'id_kecamatan', false) !== false)
                          ? '<option value="' . $data['id_kecamatan'] . '" selected>' . $data['nama_kecamatan'] . '</option>'
                          : '' ?>
                      </select>
                      <div class="invalid-feedback" id="error_id_kecamatan"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="id_kelurahan">Kelurahan</label>
                      <select name="id_kelurahan" id="id_kelurahan" class="form-select select2_kelurahan">
                        <option value="" default hidden>- Pilih Kelurahan -</option>
                        <?= (check_var($data, 'id_kelurahan', false) !== false)
                          ? '<option value="' . $data['id_kelurahan'] . '" selected>' . $data['nama_kelurahan'] . '</option>'
                          : '' ?>
                      </select>
                      <div class="invalid-feedback" id="error_id_kelurahan"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="kode_pos">Kode POS</label>
                      <input id="kode_pos" name="kode_pos" type="text" class="form-control" value="<?= check_var($data, 'kode_pos', '') ?>">
                      <div class="invalid-feedback" id="error_kode_pos"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="map_location">Lokasi pada MAP</label>
                      <div style="display: block; position: relative; width: calc(100% - 40px);">
                        <div id="map_location" style="height: 500px; z-index: 1;"></div>
                      </div>
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="input_block">
                      <label for="lat">Latitude</label>
                      <input type="text" id="lat" name="lat" class="form-control" value="<?= check_var($data, 'lat', '') ?>" readonly>
                      <div class="invalid-feedback" id="error_lat"></div>
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="input_block">
                      <label for="long">Longitude</label>
                      <input type="text" id="long" name="long" class="form-control" value="<?= check_var($data, 'long', '') ?>" readonly>
                      <div class="invalid-feedback" id="error_long"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="telepon">No. Telepon</label>
                      <input id="telepon" name="telepon" type="text" class="form-control" value="<?= check_var($data, 'telepon', '') ?>">
                      <div class="invalid-feedback" id="error_telepon"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="website">Website</label>
                      <input id="website" name="website" type="text" class="form-control" value="<?= check_var($data, 'website', '') ?>">
                      <div class="invalid-feedback" id="error_website"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="email">E-mail</label>
                      <input id="email" name="email" type="text" class="form-control" value="<?= check_var($data, 'email', '') ?>">
                      <div class="invalid-feedback" id="error_email"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="no_rek_bank">No. Rekening Bank</label>
                      <input id="no_rek_bank" name="no_rek_bank" type="text" class="form-control" value="<?= check_var($data, 'no_rek_bank', '') ?>">
                      <div class="invalid-feedback" id="error_no_rek_bank"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="nama_bank">Nama Bank</label>
                      <input id="nama_bank" name="nama_bank" type="text" class="form-control" value="<?= check_var($data, 'nama_bank', '') ?>">
                      <div class="invalid-feedback" id="error_nama_bank"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="cabang_kcp_unit">Cabang KCP Unit</label>
                      <input id="cabang_kcp_unit" name="cabang_kcp_unit" type="text" class="form-control" value="<?= check_var($data, 'cabang_kcp_unit', '') ?>">
                      <div class="invalid-feedback" id="error_cabang_kcp_unit"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="nama_wajib_pajak">Nama Wajib Pajak</label>
                      <input id="nama_wajib_pajak" name="nama_wajib_pajak" type="text" class="form-control" value="<?= check_var($data, 'nama_wajib_pajak', '') ?>">
                      <div class="invalid-feedback" id="error_nama_wajib_pajak"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="npwp">NPWP</label>
                      <input id="npwp" name="npwp" type="text" class="form-control" value="<?= check_var($data, 'npwp', '') ?>">
                      <div class="invalid-feedback" id="error_npwp"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="no_sk_pendirian">No. SK Pendirian</label>
                      <input id="no_sk_pendirian" name="no_sk_pendirian" type="text" class="form-control" value="<?= check_var($data, 'no_sk_pendirian', '') ?>">
                      <div class="invalid-feedback" id="error_no_sk_pendirian"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="tgl_sk_pendirian">Tgl. SK Pendirian</label>
                      <input id="tgl_sk_pendirian" name="tgl_sk_pendirian" type="text" class="form-control flatpickr" value="<?= check_var($data, 'tgl_sk_pendirian', '') ?>">
                      <div class="invalid-feedback" id="error_tgl_sk_pendirian"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="no_sk_izin_operasional">No. SK Izin Operasional</label>
                      <input id="no_sk_izin_operasional" name="no_sk_izin_operasional" type="text" class="form-control" value="<?= check_var($data, 'no_sk_izin_operasional', '') ?>">
                      <div class="invalid-feedback" id="error_no_sk_izin_operasional"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="tgl_sk_izin_operasional">Tgl. SK Izin Operasional</label>
                      <input id="tgl_sk_izin_operasional" name="tgl_sk_izin_operasional" type="text" class="form-control flatpickr" value="<?= check_var($data, 'tgl_sk_izin_operasional', '') ?>">
                      <div class="invalid-feedback" id="error_tgl_sk_izin_operasional"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="luas_tanah">Luas Tanah</label>
                      <input id="luas_tanah" type="number" step="0.01" min="0" name="luas_tanah" type="text" class="form-control" value="<?= check_var($data, 'luas_tanah', '') ?>">
                      <div class="invalid-feedback" id="error_luas_tanah"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="kepemilikan_tanah">Kepemilikan Tanah</label>
                      <select name="kepemilikan_tanah" id="kepemilikan_tanah" class="form-select">
                        <?php
                        $kptn = check_var($data, 'kepemilikan_tanah', '');
                        ?>
                        <option value="" hidden default>- Pilih Status Kepemilikan Tanah -</option>
                        <option value="MILIK" <?= ($kptn == 'MILIK') ? 'selected' : '' ?>>Hak Milik</option>
                        <option value="SEWA" <?= ($kptn == 'SEWA') ? 'selected' : '' ?>>Sewa</option>
                        <option value="PINJAM" <?= ($kptn == 'PINJAM') ? 'selected' : '' ?>>Pinjam</option>
                      </select>
                      <div class="invalid-feedback" id="error_kepemilikan_tanah"></div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <div class="card-title">
            <div><i class="fas fa-list me-2"></i>Data Inventarisasi</div>
          </div>

          <div class="card-body">
            <table class="table table-sm table-bordered table-hover">
              <thead class="text-center">
                <tr>
                  <th style="width: 40%;" class="vam">GEDUNG</th>
                  <th style="width: 10%;" class="vam">Baik</th>
                  <th style="width: 10%;" class="vam">Rusak<br>Ringan</th>
                  <th style="width: 10%;" class="vam">Rusak<br>Sedang</th>
                  <th style="width: 10%;" class="vam">Rusak<br>Berat</th>
                  <th style="width: 10%;" class="vam">Rusak<br>Total</th>
                  <th style="width: 10%;" class="vam">JUMLAH</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $items = get_inventaris_items();
                $fields = get_inventaris_fields();

                foreach ($items as $key => $value) {
                  echo '<tr>';
                  echo ($key == 'total')
                    ? '<td class="text-start vam"><b>' . $value . '</b></td>'
                    : '<td class="text-start vam">' . $value . '</td>';
                  foreach ($fields as $field_name) {
                    $data_inv = $data['inventaris'];
                    $default_value = (isset($data['inventaris'][$key][$field_name]))
                      ? $data['inventaris'][$key][$field_name]
                      : 0;

                    $exist_class = ($default_value > 0) ? 'exist' : '';

                    if ($key != 'total' && $field_name != 'jumlah') {
                      echo '<td>' .

                        '<input type="number" step="1" min="0" name="inventaris[' . $key . '][' . $field_name . ']" class="form-control form-control-sm vam text-end input_inventaris ' . $exist_class . ' ' . $key . ' ' . $field_name . '" style="width: 100%;" value="' . $default_value . '">' .

                        '</td>';
                    } else {
                      echo '<td>' .

                        '<input type="hidden" name="inventaris[' . $key . '][' . $field_name . ']" class="hidden_input ' . $key . ' ' . $field_name . '" value="' . $default_value . '">' .

                        '<div class="display_value vam text-end ' . $key . ' ' . $field_name . '" style="font-weight: bold;">' . $default_value . '</div>' .

                        '</td>';
                    }
                  }
                  echo '</tr>';
                }
                ?>
              </tbody>
            </table>
          </div>

          <div class="card-footer text-end">
            <button type="button" class="form_action_button btn btn-info ms-2" onclick="save_draft()"><i class="fas fa-save me-2"></i>Simpan Draft</button>
            <button type="button" class="form_action_button btn btn-success ms-2" onclick="submit_draft()"><i class="fas fa-paper-plane me-2"></i>Submit Draft</button>
          </div>
        </div>

      </form>
    </div>

  </div>

</div>

<script>
  function recalculate_inventaris_total() {
    const items = <?= json_encode(array_keys(get_inventaris_items())); ?>;
    const fields = <?= json_encode(get_inventaris_fields()); ?>;

    items.forEach(function(item) {
      let total_row = 0;

      // Sum all inputs of the same items (same column)
      $('.input_inventaris.' + item).each(function() {
        const val = parseInt($(this).val()) || 0;
        total_row += val;
      });

      // Update the display div and hidden input in the "jumlah" column
      $('.display_value.' + item + '.jumlah').text(total_row);
      $('input[name="inventaris[' + item + '][jumlah]"]').val(total_row);
    });

    fields.forEach(function(field) {
      let total_col = 0;
      let selector = (field == 'jumlah') ?
        '.hidden_input.' + field :
        '.input_inventaris.' + field;

      $(selector).each(function() {
        const val = parseInt($(this).val()) || 0;
        total_col += val;
      });

      // Update the display div and hidden input in the "jumlah" row
      $('.display_value.total.' + field).text(total_col);
      $('input[name="inventaris[total][' + field + ']"]').val(total_col);
    });
  }


  function modal(d_action, d_id) {
    var url = "<?= site_url('pdt_profil_sekolah/modal') ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {
        action: d_action,
        id: d_id
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

  $(".flatpickr").flatpickr({
    enableTime: false,
    altFormat: "j M Y",
    altInput: true,
    dateFormat: "Y-m-d",
    disableMobile: true,
    locale: {
      firstDayOfWeek: 1,
      weekdays: {
        shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
        longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
      },
      months: {
        shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
      }
    }
  });

  /// |----------------------------------------
  /// | INIT SELECT2
  /// |----------------------------------------
  init_select2(
    '.select2_status',
    '- Pilih Status Sekolah -',
    '<?= site_url('config/select2_status_sekolah') ?>'
  );

  setTimeout(() => {
    init_select2(
      '.select2_kecamatan',
      '- Pilih Kecamatan -',
      '<?= site_url('config/select2_kecamatan') ?>'
    );
  }, 50);

  setTimeout(() => {
    init_select2(
      '.select2_kelurahan',
      '- Pilih Kelurahan -',
      '<?= site_url('config/select2_kelurahan') ?>',
      () => ({
        id_kecamatan: $('#id_kecamatan').val()
      })
    );
  }, 100);

  setTimeout(() => {
    $('.select2-hidden-accessible').on('change', function() {
      $(this).valid();
    });
  }, 150);

  /// |----------------------------------------
  /// | FORM ACTION
  /// |----------------------------------------
  var form_action_url = '<?= site_url('pdt_profil_sekolah/edit_draft') ?>';

  function save_draft() {
    form_action_url = '<?= site_url('pdt_profil_sekolah/edit_draft') ?>';
    $('#form_edit_profil_sekolah').submit();
  }

  function submit_draft() {
    form_action_url = '<?= site_url('pdt_profil_sekolah/submit_draft') ?>';
    $('#form_edit_profil_sekolah').submit();
  }

  /// |----------------------------------------
  /// | DOCUMENT READY
  /// |----------------------------------------
  $(document).ready(function() {

    /// |----------------------------------------
    /// | FORM SUBMISSION
    /// |----------------------------------------
    $('#form_edit_profil_sekolah').on('keydown', function(e) {
      if (e.key === 'Enter') {
        // prevent Enter key from triggering form submission
        if (e.target.tagName !== 'TEXTAREA') {
          e.preventDefault();
          return false;
        }
      }
    });

    recalculate_inventaris_total();

    $('.input_inventaris').on('input', function() {

      if ($(this).val() > 0) {
        $(this).addClass('exist');
      } else {
        $(this).removeClass('exist');
      }

      recalculate_inventaris_total();
    });

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
    /// | MAP FUNCTIONALITY
    /// |----------------------------------------
    // Default coordinates if no value is set
    const defaultLat = <?= check_var($data, 'lat', ' -0.492215') ?>;
    const defaultLng = <?= check_var($data, 'long', '117.1432875') ?>;

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

    // Update hidden fields on click
    map.on('click', function(e) {
      const {
        lat,
        lng
      } = e.latlng;
      marker.setLatLng([lat, lng]); // move marker
      $('#lat').val(lat).valid();
      $('#long').val(lng).valid();
    });

    // add search control to the map using leaflet-control-geocoder
    L.Control.geocoder({
        defaultMarkGeocode: false
      })
      .on('markgeocode', function(e) {
        const bbox = e.geocode.bbox;
        const bounds = [
          [bbox.getSouth(), bbox.getWest()],
          [bbox.getNorth(), bbox.getEast()]
        ];
        map.fitBounds(bounds);

        // Optional: move your marker there too
        const latlng = e.geocode.center;
        marker.setLatLng(latlng);
        $('#lat').val(latlng.lat);
        $('#long').val(latlng.lng);
      })
      .addTo(map);
  });
</script>